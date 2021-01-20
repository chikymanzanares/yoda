<?php


namespace Inbenta\YodaBot\Domain\Entities\Movie;



use Inbenta\SharedKernel\Domain\AbstractCollection;

class MovieCollection extends AbstractCollection
{
    const CLASSNAME = Movie::class;

    public function toResponseReply(): array
    {
        $array = [];
        foreach ($this->collection as $entity){
            $array[] = $entity->toResponseReply();
        }
        return $array;
    }
}
