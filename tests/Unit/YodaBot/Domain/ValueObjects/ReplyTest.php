<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use PHPUnit\Framework\TestCase;

class ReplyTest extends TestCase
{
    public function testNoForce()
    {
        $reply = new Reply('Hello!');
        $this->assertTrue($reply instanceof Reply);
        $this->assertTrue(!$reply->isForce());

    }

    public function testForce()
    {
        $reply = new Reply('may force with you!');
        $this->assertTrue($reply instanceof Reply);
        $this->assertTrue($reply->isForce());

    }
}
