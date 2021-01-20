<?php

namespace Inbenta\YodaBot\Domain\Entities\Character;



use Inbenta\YodaBot\Domain\ValueObjects\Name;

class CharacterFactory
{

    public function __construct()
    {
    }


    public function fromArray(array $characterArray): Character
    {
        $name = new Name($characterArray['name']);
        $character =  $this->build($name);
        $character->setName($name);
        return $character;
    }


    public function build(Name $name): Character
    {
        return new Character($name);
    }

    public function buildCollection(array $array)
    {
        return new CharacterCollection($array);
    }

    public function fromListArray(array $data) : CharacterCollection
    {
        return $this->buildCollection(
            array_map(
                function ($data) {
                    return $this->fromArray($data);
                },
                $data
            )
        );
    }
}
