<?php

namespace Tests\Unit\YodaBot\Infrastructure\Repositories\MovieRepository;

use GuzzleHttp\Client;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieCollection;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieFactory;
use Inbenta\YodaBot\Infrastructure\Repositories\Movie\MovieRepository;
use PHPUnit\Framework\TestCase;

class MovieRepositoryTest extends TestCase
{
    public function testBasicTest()
    {
        $repository = new MovieRepository(
            new Client(),
            new MovieFactory()
        );
        $characterCollection = $repository->getMovies();
        $this->assertTrue($characterCollection instanceof MovieCollection);
    }

}
