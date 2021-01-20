<?php

namespace Inbenta\YodaBot\Domain\Entities\Character;


use Inbenta\SharedKernel\Domain\AbstractEntity;
use Inbenta\YodaBot\Domain\ValueObjects\Name;

class Character extends AbstractEntity
{
    protected Name $name;

    public function __construct(Name $name)
    {
        $this->name = $name;
    }

    public function setName(Name $name)
    {
        $this->name = $name;
    }

    public function toResponseReply(): string
    {
        return $this->name->getValue(); // '\r\n';
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function equals($object) : bool
    {
        return get_class($this) == get_class($object)
            && $this->getName() == $object->getName();
    }
}
