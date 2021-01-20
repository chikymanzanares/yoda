<?php

namespace Tests\Unit\YodaBot\Domain\Entities\Character;

use Inbenta\YodaBot\Domain\Entities\Character\CharacterCollection;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterFactory;
use PHPUnit\Framework\TestCase;

class CharacterCollectionTest extends TestCase
{
    public function testBasicTest()
    {
        $collection = (new CharacterFactory())->fromListArray(
            [
                [
                    'name' => 'Anakin'
                ],
                [
                    'name' => 'Luke'
                ]
            ]
        );
        $this->assertTrue($collection instanceof CharacterCollection);
    }
}
