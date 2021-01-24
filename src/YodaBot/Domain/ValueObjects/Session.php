<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class Session
{
    protected array $value;

    public function __construct($value)
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid session '.json_encode($value));
        }
        $this->value = $value;
    }

    protected function validCondition($value)
    {
        if (!(is_array($value))
            || !array_key_exists('accessToken', $value)
            || !array_key_exists('sessionToken', $value)
            || !array_key_exists('sessionId', $value)
            || !array_key_exists('chatBot', $value)
            || !array_key_exists('expiration', $value)){
            return false;
        }
        return true;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setPreviousNotFound(bool $previousNotFound)
    {
        $this->value['previousNotFound'] = $previousNotFound;
    }

    public function getPreviousNotFound(): bool
    {
        return $this->value['previousNotFound'];
    }

    public function bothPreviousNotFound(Session $session): bool
    {
        return (($this->getPreviousNotFound()) &&
            $session->getPreviousNotFound());
    }
}
