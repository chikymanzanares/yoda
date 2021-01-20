<?php

namespace Tests\Unit\YodaBot\Infrastructure\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Inbenta\YodaBot\Infrastructure\Api\ConversationConnection;
use PHPUnit\Framework\TestCase;

class ConversationConnectionTest extends TestCase
{
    protected array $apiConnection =
        [
            'serviceUrl' => 'https://api.inbenta.io/v1/auth',
            'apiKey' => 'nyUl7wzXoKtgoHnd2fB0uRrAv0dDyLC+b4Y6xngpJDY=',
            'secret' => 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIn0.anf_eerFhoNq6J8b36_qbD4VqngX79-yyBKWih_eA1-HyaMe2skiJXkRNpyWxpjmpySYWzPGncwvlwz5ZRE7eg'
        ];
    public function testBasicTest()
    {
        $conversation = new ConversationConnection(
            new Client(),
            $this->apiConnection
        );
        $arraySession = $conversation->initConversation();
        $this->assertTrue(!empty($arraySession['accessToken']));
        $this->assertTrue(!empty($arraySession['expiration']));
        $this->assertTrue(!empty($arraySession['sessionToken']));
        $this->assertTrue(!empty($arraySession['sessionId']));
        $this->assertTrue(!empty($arraySession['chatBot']));
    }

    public function testReply()
    {
        $conversation = new ConversationConnection(
            new Client(),
            $this->apiConnection
        );
        $arraySession = $conversation->initConversation();
        $this->assertTrue(is_array($conversation->sendReply($arraySession, 'me enseñas a luchar ?')));
    }

    public function testExpiredSessionReply()
    {
        $conversation = new ConversationConnection(
            new Client(),
            $this->apiConnection
        );
        $arraySession = [
            'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
            'expiration' => 1610963599,
            'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
            'sessionId' => 'p5le1un3vulm0od516m3un08s6',
            'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1'
        ];
        try {
            $conversation->sendReply($arraySession, 'me enseñas a luchar ?');
        } catch (ClientException $exception){
            $response = $exception->getResponse();
            $arrayResponse = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
            $this->assertEquals($arrayResponse['message'],'User is not authorized to access this resource with an explicit deny');
        }
    }

    public function testConnectIfNeedAndReply()
    {
        $conversation = new ConversationConnection(
            new Client(),
            $this->apiConnection
        );
        $arraySession = [
            'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
            'expiration' => 1610963599,
            'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
            'sessionId' => 'p5le1un3vulm0od516m3un08s6',
            'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1'
        ];
        $reply = 'Hello!';
        $arrayResponse = $conversation->connectIfSessionExpiredAndSendReply($arraySession, $reply);
        $this->assertTrue(isset($arrayResponse['answers'][0]['message']));
    }

    public function testIsExpiredSession()
    {
        $conversation = new ConversationConnection(
            new Client(),
            $this->apiConnection
        );
        $this->assertTrue($conversation->tokenHasExpired([]));
        $arraySession = [
            'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
            'expiration' => 1610963599,
            'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
            'sessionId' => 'p5le1un3vulm0od516m3un08s6',
            'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1'
        ];
        $this->assertTrue($conversation->tokenHasExpired($arraySession));
    }
}
