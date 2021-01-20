<?php


namespace App\Http\Controllers;

use GuzzleHttp\Client;

use Inbenta\YodaBot\Application\Query\GetConversationReplyQuery;
use Inbenta\YodaBot\Application\Query\GetConversationReplyQueryHandler;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterFactory;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieFactory;
use Inbenta\YodaBot\Infrastructure\Api\ConversationConnection;
use Inbenta\YodaBot\Infrastructure\Repositories\Character\CharacterRepository;
use Inbenta\YodaBot\Infrastructure\Repositories\Movie\MovieRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class BotHandlerController extends Controller
{

    protected SessionInterface $session;
    protected Request $request;
    protected ContainerInterface $container;
    protected array $arraySession;
    protected GetConversationReplyQueryHandler $getConversationReplyQueryHandler;

    public function __construct(SessionInterface $session,
                                ContainerInterface $container,
                                Request $request,
                                JsonResponse $jsonResponse
                                //, GetConversationReplyQueryHandler $getConversationReplyQueryHandler
        )
    {
        $this->session = $session;
        $this->request = $request;
        $this->container = $container;
        $this->jsonResponse = $jsonResponse;
        //$this->getConversationReplyQueryHandler = $getConversationReplyQueryHandler;
        $this->getConversationReplyQueryHandler = new GetConversationReplyQueryHandler(
            new ConversationConnection(
                new Client()
            ),
            new CharacterRepository(
                new Client(),
                new CharacterFactory()
            ),
            new MovieRepository(
                new Client(),
                new MovieFactory()
            )
        );
    }

    public function reply()
    {
        $message = $this->request->get('message');
        $getConversationResponse = $this->getConversationReplyQueryHandler->__invoke(
            new GetConversationReplyQuery($this->getSession(), $message)
        );
        $this->setSession($getConversationResponse->session());
        return new JsonResponse(['reply' => $getConversationResponse->reply(),
            'alternativeReply' => $getConversationResponse->alternativeReply(),
            'isForce' => $getConversationResponse->isForce(),
            'secondNotFound' => $getConversationResponse->secondNotFound()]);
    }


    private function getSession(): array
    {
        $this->session = $this->container->get(SessionInterface::class);
        $this->arraySession = [
            'expiration' => $this->session->get('expiration'),
            'accessToken' => $this->session->get('accessToken'),
            'sessionToken' => $this->session->get('sessionToken'),
            'sessionId' => $this->session->get('sessionId'),
            'chatBot' => $this->session->get('chatBot'),
            'previousNotFound' => $this->session->get('previousNotFound'),
        ];
        return $this->arraySession;
    }

    private function setSession(array $arraySession): void
    {
        $this->session->set('expiration', $arraySession['expiration']);
        $this->session->set('accessToken', $arraySession['accessToken']);
        $this->session->set('sessionToken', $arraySession['sessionToken']);
        $this->session->set('sessionId', $arraySession['sessionId']);
        $this->session->set('chatBot', $arraySession['chatBot']);
        $this->session->set('previousNotFound', $arraySession['previousNotFound']);
        $this->arraySession = $arraySession;
    }
}
