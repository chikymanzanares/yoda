<?php


namespace Inbenta\YodaBot\Domain\Entities\Movie;



interface MovieRepositoryInterface
{

    const ENTITY_FACTORY_CLASS = MovieFactory::class;

    public function getMovies(): MovieCollection;

}
