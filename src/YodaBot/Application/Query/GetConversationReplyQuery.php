<?php
declare(strict_types=1);

namespace Inbenta\YodaBot\Application\Query;


use Inbenta\SharedKernel\Application\QueryBus\Query;

class GetConversationReplyQuery implements Query
{
    protected array $session;
    protected string $reply;

    public function __construct(array $session, string $reply)
    {
        $this->session = $session;
        $this->reply = $reply;
    }

    public function reply() : string
    {
        return $this->reply;
    }

    public function session() : array
    {
        return $this->session;
    }
}
