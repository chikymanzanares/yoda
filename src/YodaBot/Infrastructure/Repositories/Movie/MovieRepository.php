<?php


namespace Inbenta\YodaBot\Infrastructure\Repositories\Movie;


use GuzzleHttp\Client;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieCollection;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieFactory;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{

    protected Client $client;
    protected MovieFactory $MovieFactory;

    const SERVICE_URL = 'https://inbenta-graphql-swapi-prod.herokuapp.com/api';

    public function __construct(Client $client,
                                MovieFactory $MovieFactory)
    {
        $this->client = $client;
        $this->MovieFactory = $MovieFactory;
    }

    public function getMovies(): MovieCollection
    {
        $response = $this->client->request(
            'GET',
            self::SERVICE_URL,
            [
                'form_params' =>
                    $this->getPeopleRequest()
            ]
        );
        $array = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        return $this->MovieFactory->fromListArray($array['data']['allFilms']['films']);
    }

    private function getPeopleRequest() : array
    {
        return json_decode('{"query":"{allFilms(first: 10){films{title}}}","variables":{}}', true, 512, JSON_THROW_ON_ERROR);
    }
}
