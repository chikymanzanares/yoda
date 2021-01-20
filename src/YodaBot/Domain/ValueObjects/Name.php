<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class Name
{

    protected string $value;

    public function __construct($value)
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid name '.$value);
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
        return isset($value[0])
             && (ctype_upper($value[0]));
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
