<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\ReplyInfo;
use PHPUnit\Framework\TestCase;

class ReplyInfoTest extends TestCase
{
    public function testGoodReply()
    {
        $replyInfo = new ReplyInfo(['secondNotFound' => false, 'isForce'=> false ]);
        $this->assertTrue($replyInfo instanceof ReplyInfo);
        $replyInfo->setIsForce();
        $replyInfo->setSecondNotFound();
        $this->assertTrue($replyInfo->getValue()['isForce']);
        $this->assertTrue($replyInfo->getValue()['secondNotFound']);

    }

    public function testBadReplyInfo()
    {
        $this->expectException(\InvalidArgumentException::class);
        $replyInfo = new ReplyInfo(['isForce'=> false ]);
        $this->assertTrue($replyInfo instanceof ReplyInfo);
    }
}
