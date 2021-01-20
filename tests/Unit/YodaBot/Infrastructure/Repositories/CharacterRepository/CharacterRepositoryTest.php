<?php

namespace Tests\Unit\YodaBot\Infrastructure\Repositories\CharacterRepository;

use GuzzleHttp\Client;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterCollection;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterFactory;
use Inbenta\YodaBot\Infrastructure\Repositories\Character\CharacterRepository;
use PHPUnit\Framework\TestCase;

class CharacterRepositoryTest extends TestCase
{
    public function testBasicTest()
    {
        $repository = new CharacterRepository(
            new Client(),
            new CharacterFactory()
        );
        $characterCollection = $repository->getCharacters();
        $this->assertTrue($characterCollection instanceof CharacterCollection);
    }

}
