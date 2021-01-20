<?php


namespace Inbenta\YodaBot\Domain\Entities\Character;



interface CharacterRepositoryInterface
{

    const ENTITY_FACTORY_CLASS = CharacterFactory::class;

    public function getCharacters(): CharacterCollection;

}
