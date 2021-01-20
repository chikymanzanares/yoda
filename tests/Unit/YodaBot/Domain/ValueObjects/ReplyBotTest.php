<?php

namespace Tests\Unit\YodaBot\Domain\ValueObjects;

use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyBot;
use PHPUnit\Framework\TestCase;

class ReplyBotTest extends TestCase
{
    public function testNotFoundAnswerForce()
    {
        $replyBot = new ReplyBot(['answers' =>
            [
                [
                'type'        => 'answer',
                'message'     => "I've had a look and there's nothing I can find which fits your question. Please search again using a
                                    different word or phrase.",
                'messageList' => ["I've had a look and there's nothing I can find which fits your question. Please search again using a different
                                    word or phrase."],
                'options' => '',
                'parameters' => '',
                'flags' => ['no-results']
                ],
            ],
        ]);
        $this->assertTrue($replyBot instanceof ReplyBot);
        $this->assertTrue($replyBot->notFoundAnswer());
    }

    public function testFoundAnswerForce()
    {
        $replyBot = new ReplyBot(['answers' =>
            [
                [
                    'type' => 'answer',
                    'message' => "Powerful you have become, the dark side I sense in you. What answers do you seek?",
                    'messageList' => ["Powerful you have become, the dark side I sense in you. What answers do you seek?"]
                ]
            ],
            'options' => '',
            'parameters' => '',
            'flags' => [],
            'source' => ['type' => 'chatbot', 'name' => 'chatbot'],
            'intent' => ['type' => 'AIML', 'score' => 1]
        ]);
        $this->assertTrue($replyBot instanceof ReplyBot);
        $this->assertFalse($replyBot->notFoundAnswer());
        $this->assertEquals($replyBot->getValueResponse(), "Powerful you have become, the dark side I sense in you. What answers do you seek?");
    }
}
