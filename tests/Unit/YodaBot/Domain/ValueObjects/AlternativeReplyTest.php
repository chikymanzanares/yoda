<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\AlternativeReply;
use PHPUnit\Framework\TestCase;

class AlternativeReplyTest extends TestCase
{
    public function testGoodAlternativeReply()
    {
        $alternativeReply = new AlternativeReply(['Luke', 'Leia']);
        $this->assertTrue($alternativeReply instanceof AlternativeReply);
    }

    public function testGoodEmptyAlternativeReply()
    {
        $alternativeReply = new AlternativeReply([]);
        $this->assertTrue($alternativeReply instanceof AlternativeReply);
    }

}
