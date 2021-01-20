<?php

namespace Tests\Unit\YodaBot\Domain\Entities\Character;

use Inbenta\YodaBot\Domain\Entities\Character\Character;
use Inbenta\YodaBot\Domain\ValueObjects\Name;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    public function testBasicTest()
    {
        $name = new Character(new Name('Anakin'));
        $this->assertTrue($name instanceof Character);
        $this->assertEquals($name->getName()->getValue(), 'Anakin');
    }
}
