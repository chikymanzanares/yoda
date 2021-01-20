<?php

namespace App\Http\Controllers;

use Inbenta\YodaBot\Application\Query\GetConversationReplyQueryHandler;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BotController extends Controller
{

    protected SessionInterface $session;
    protected Request $request;
    protected ContainerInterface $container;
    protected array $arraySession;
    protected GetConversationReplyQueryHandler $getConversationReplyQueryHandler;

    public function __construct(SessionInterface $session,
                                ContainerInterface $container
        )
    {
        $this->session = $session;
        $this->container = $container;
    }

    public function __invoke()
    {

        return (view('yoda'));
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
