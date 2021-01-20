<?php

namespace Inbenta\YodaBot\Domain\ValueObjects;


class ReplyBot
{
    protected array $value;

    public function __construct($value)
    {
        if  (!($this->validCondition($value))){
            throw new \InvalidArgumentException('Invalid reply '.json_encode($value));
        }
        $this->value = $value;
    }

    protected function validCondition($value)
    {
        if (!(isset($value)
            && is_array($value))
            && (!(isset($value['answers'][0]['type'])))
            && (!(isset($value['answers'][0]['message'])))){
            return false;
        }
        return true;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function getValueResponse(): string
    {
        return $this->value['answers'][0]['message'];
    }

    public function notFoundAnswer(): bool
    {
        return isset($this->value['answers'][0]['flags'][0]) &&
            $this->value['answers'][0]['flags'][0] === 'no-results';
    }

}
