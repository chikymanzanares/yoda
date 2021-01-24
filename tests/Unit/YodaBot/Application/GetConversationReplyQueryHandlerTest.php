<?php

namespace Tests\Unit\YodaBot\Application;

use GuzzleHttp\Client;
use Inbenta\YodaBot\Application\Query\GetConversationReplyQuery;
use Inbenta\YodaBot\Application\Query\GetConversationReplyQueryHandler;
use Inbenta\YodaBot\Application\Query\GetConversationResponse;
use Inbenta\YodaBot\Domain\Conversation\Conversation;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterFactory;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieFactory;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyBot;
use Inbenta\YodaBot\Domain\ValueObjects\Session;
use Inbenta\YodaBot\Infrastructure\Repositories\Character\CharacterRepository;
use Inbenta\YodaBot\Infrastructure\Repositories\Movie\MovieRepository;
use PHPUnit\Framework\TestCase;

class GetConversationReplyQueryHandlerTest extends TestCase
{

    public function testBotGoodAnswerTest()
    {
        $this->getConversationReplyQueryHandler = new GetConversationReplyQueryHandler(
            $this->conversationConnectionMock(),
            new CharacterRepository(
                new Client(),
                new CharacterFactory()
            ),
            new MovieRepository(
                new Client(),
                new MovieFactory()
            )
        );
        $getConversationResponse = $this->getConversationReplyQueryHandler->__invoke(
            new GetConversationReplyQuery(            [
                'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
                'expiration' => 1610963599,
                'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
                'sessionId' => 'p5le1un3vulm0od516m3un08s6',
                'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1',
                'previousNotFound' => false
            ], 'Hello!')
        );
        $this->assertTrue($getConversationResponse instanceof GetConversationResponse);
        $this->assertFalse($getConversationResponse->secondNotFound());
        $this->assertFalse($getConversationResponse->isForce());
    }

    public function testBotSecondFailTest()
    {
        $this->getConversationReplyQueryHandler = new GetConversationReplyQueryHandler(
            $this->conversationConnectionMock(),
            new CharacterRepository(
                new Client(),
                new CharacterFactory()
            ),
            new MovieRepository(
                new Client(),
                new MovieFactory()
            )
        );
        $getConversationResponse = $this->getConversationReplyQueryHandler->__invoke(
            new GetConversationReplyQuery(            [
                'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
                'expiration' => 1610963599,
                'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
                'sessionId' => 'p5le1un3vulm0od516m3un08s6',
                'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1',
                'previousNotFound' => true
            ], 'Egss')
        );
        $this->assertTrue($getConversationResponse->secondNotFound());
        $this->assertFalse($getConversationResponse->isForce());
    }

    public function testBotForceTest()
    {
        $this->getConversationReplyQueryHandler = new GetConversationReplyQueryHandler(
            $this->conversationConnectionMock(),
            new CharacterRepository(
                new Client(),
                new CharacterFactory()
            ),
            new MovieRepository(
                new Client(),
                new MovieFactory()
            )
        );
        $getConversationResponse = $this->getConversationReplyQueryHandler->__invoke(
            new GetConversationReplyQuery(            [
                'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
                'expiration' => 1610963599,
                'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
                'sessionId' => 'p5le1un3vulm0od516m3un08s6',
                'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1',
                'previousNotFound' => false
            ], 'May Force with you')
        );
        $this->assertFalse($getConversationResponse->secondNotFound());
        $this->assertTrue($getConversationResponse->isForce());
    }

    private function conversationConnectionMock(): Conversation
    {
        $mock = $this->createMock(Conversation::class);
        $mock->expects($this->once())->method('tokenHasExpired')->willReturn(true);
        $mock->expects($this->once())->method('initConversation')->willReturn(
            new Session(
            [
                'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
                'expiration' => 1610963599,
                'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
                'sessionId' => 'p5le1un3vulm0od516m3un08s6',
                'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1'
            ])
        );
        $mock->expects($this->once())->method('sendReply')->willReturn(
            new ReplyBot(
            ['answers' =>
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
            ])
        );
        return $mock;
    }
}
