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
                                ContainerInterface $container)
    {
        $this->session = $session;
        $this->container = $container;
    }

    public function __invoke()
    {
        return (view('yoda'));
    }
}
