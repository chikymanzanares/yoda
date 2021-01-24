<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class ReplyInfo
{
    protected array $value;

    public function __construct(array $value = ['secondNotFound' => false, 'isForce'=> false ])
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid reply '.json_encode($value));
        }
        $this->value = $value;
    }

    protected function validCondition($value)
    {
        if (!(is_array($value))
            || !array_key_exists('secondNotFound', $value)
            || !array_key_exists('isForce', $value)){
            return false;
        }
        return true;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setSecondNotFound()
    {
        $this->value['secondNotFound'] = true;
    }

    public function setIsForce()
    {
        $this->value['isForce'] = true;
    }

}
