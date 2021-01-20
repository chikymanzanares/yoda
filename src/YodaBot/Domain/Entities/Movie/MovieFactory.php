<?php

namespace Inbenta\YodaBot\Domain\Entities\Movie;



use Inbenta\YodaBot\Domain\ValueObjects\Name;

class MovieFactory
{

    public function __construct()
    {
    }


    public function fromArray(array $MovieArray): Movie
    {
        $name = new Name($MovieArray['title']);
        $Movie =  $this->build($name);
        $Movie->setName($name);
        return $Movie;
    }


    public function build(Name $name): Movie
    {
        return new Movie($name);
    }

    public function buildCollection(array $array)
    {
        return new MovieCollection($array);
    }

    public function fromListArray(array $data) : MovieCollection
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
