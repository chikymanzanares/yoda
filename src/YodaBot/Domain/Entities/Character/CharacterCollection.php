<?php


namespace Inbenta\YodaBot\Domain\Entities\Character;



use Inbenta\SharedKernel\Domain\AbstractCollection;

class CharacterCollection extends AbstractCollection
{
    const CLASSNAME = Character::class;

    public function toResponseReply(): array
    {
        $array = [];
        foreach ($this->collection as $entity){
            $array[] = $entity->toResponseReply();
        }
        return $array;
    }
}
