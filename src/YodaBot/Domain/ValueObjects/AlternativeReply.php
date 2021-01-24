<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class AlternativeReply
{
    protected array $value;

    public function __construct(array $value = [])
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid reply '.json_encode($value));
        }
        $this->value = $value;
    }

    protected function validCondition($value)
    {
        if (!(is_array($value))){
            return false;
        }
        return true;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value)
    {
        $this->value = $value;
    }

}
