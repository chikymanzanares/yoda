<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testBasicTest()
    {
        $name = new Name('Anakin');
        $this->assertTrue($name instanceof Name);
        $this->assertEquals($name->getValue(), 'Anakin');
    }

    public function testNotUppercaseTest()
    {
        $this->expectException(\InvalidArgumentException::class);
        $name = new Name('anakin');
        $this->assertTrue($name instanceof $name);
    }
}
