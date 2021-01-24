<?php

namespace Inbenta\YodaBot\Domain\Conversation;


use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyBot;
use Inbenta\YodaBot\Domain\ValueObjects\Session;

interface Conversation
{
    function initConversation(): Session;

    function sendReply(Session $session, Reply $reply): ReplyBot;

    function tokenHasExpired(Session $session): bool;

}
