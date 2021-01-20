<?php


namespace Inbenta\YodaBot\Infrastructure\Repositories\Character;


use GuzzleHttp\Client;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterCollection;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterFactory;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterRepositoryInterface;

class CharacterRepository implements CharacterRepositoryInterface
{

    protected Client $client;
    protected CharacterFactory $characterFactory;

    const SERVICE_URL = 'https://inbenta-graphql-swapi-prod.herokuapp.com/api';

    public function __construct(Client $client,
                                CharacterFactory $characterFactory)
    {
        $this->client = $client;
        $this->characterFactory = $characterFactory;
    }

    public function getCharacters(): CharacterCollection
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
        return $this->characterFactory->fromListArray($array['data']['allPeople']['people']);
    }

    private function getPeopleRequest() : array
    {
        return json_decode('{"query":"{allPeople(first: 10){people{name}}}","variables":{}}', true, 512, JSON_THROW_ON_ERROR);
    }
}
