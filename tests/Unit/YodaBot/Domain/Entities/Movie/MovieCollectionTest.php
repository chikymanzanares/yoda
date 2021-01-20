<?php

namespace Tests\Unit\YodaBot\Domain\Entities\Movie;

use Inbenta\YodaBot\Domain\Entities\Movie\MovieCollection;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieFactory;
use PHPUnit\Framework\TestCase;

class MovieCollectionTest extends TestCase
{
    public function testBasicTest()
    {
        $collection = (new MovieFactory())->fromListArray(
            [
                [
                    'title' => 'The new hope'
                ],
                [
                    'title' => 'The empire strik'
                ]
            ]
        );
        $this->assertTrue($collection instanceof MovieCollection);
    }
}
