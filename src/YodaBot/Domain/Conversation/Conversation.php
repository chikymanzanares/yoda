<?php

namespace Inbenta\YodaBot\Domain\Conversation;


interface Conversation
{
    function initConversation(): array;

    function sendReply(array $session, string $reply): array;

    function tokenHasExpired(array $session): bool;

    function connectIfSessionExpiredAndSendReply(array $session, string $reply): array;
}
