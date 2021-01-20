<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class Reply
{
    protected string $value;

    public function __construct($value)
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid reply '.$value);
        }
        $this->value = html_entity_decode($value);
    }

    protected function validCondition($value)
    {
        if (!(isset($value)
            && is_string($value))) {
            return false;
        }
        $value = html_entity_decode($value);
        return isset($value[0]);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isForce(): bool
    {
        $pos = strpos(strtolower($this->value), 'force');
        if ($pos === false) {
            return false;
        } else {
            return true;
        }
    }
}
