<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    public function testBasicTest()
    {
        $name = new Title('New Hope');
        $this->assertTrue($name instanceof Title);
    }

    public function testNotUppercaseTest()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Title('anakin');
    }
}
