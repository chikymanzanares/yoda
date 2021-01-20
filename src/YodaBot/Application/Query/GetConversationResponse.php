<?php
declare(strict_types=1);

namespace Inbenta\YodaBot\Application\Query;


use Inbenta\SharedKernel\Application\DtoResponse;

class GetConversationResponse implements DtoResponse
{

    private array $session;
    private string $reply;
    private array $alternativeReply;
    private array $infoResponse;

    public function __construct(array $session, string $reply, array $alternativeReply, array $infoResponse)
    {
        $this->session          = $session;
        $this->reply            = $reply;
        $this->alternativeReply = $alternativeReply;
        $this->infoResponse          = $infoResponse;
    }

    public function session(): array
    {
        return $this->session;
    }

    public function reply(): string
    {
        return $this->reply;
    }

    public function alternativeReply(): array
    {
        return $this->alternativeReply;
    }

    public function infoResponse(): array
    {
        return $this->infoResponse;
    }

    public function isForce(): bool
    {
        return $this->infoResponse['isForce'];
    }

    public function secondNotFound(): bool
    {
        return $this->infoResponse['secondNotFound'];
    }

    public function toArray(): array
    {
        return array_merge(array_merge($this->session, array_merge(
                            $this->alternativeReply,
                            $this->alternativeReply),
                            $this->infoResponse));
    }
}
