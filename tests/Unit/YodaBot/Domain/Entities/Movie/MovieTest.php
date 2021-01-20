<?php

namespace Tests\Unit\YodaBot\Domain\Entities\Movie;

use Inbenta\YodaBot\Domain\Entities\Movie\Movie;
use Inbenta\YodaBot\Domain\ValueObjects\Name;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    public function testBasicTest()
    {
        $name = new Movie(new Name('The new Hope'));
        $this->assertTrue($name instanceof Movie);
        $this->assertEquals($name->getName()->getValue(), 'The new Hope');
    }
}
