<?php

namespace Tests\Unit\YodaBot\Application;

use Inbenta\YodaBot\Application\Query\GetConversationResponse;
use PHPUnit\Framework\TestCase;

class GetConversationResponseTest extends TestCase
{

    public function testQueryTest()
    {
        $getConversationReplyQuery = new GetConversationResponse([
            'accessToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJwcm9qZWN0IjoieW9kYV9jaGF0Ym90X2VuIiwia2V5IjoibnlVbDd3elhvS3Rnb0huZDJmQjB1UnJBdjBkRHlMQytiNFk2eG5ncEpEWT0iLCJpYXQiOjE2MTA5NjIzOTksImV4cCI6MTYxMDk2MzU5OX0.nQyvyvOtkIXxn-ZZMZ97cO4JezVSwGNKWLzG1mrp7SE',
            'expiration' => 1610963599,
            'sessionToken' => 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJzZXNzaW9uSWQiOiJwNWxlMXVuM3Z1bG0wb2Q1MTZtM3VuMDhzNiIsInRpbWVzdGFtcCI6MTYxMDk2MjQwMCwicHJvamVjdCI6InlvZGFfY2hhdGJvdF9lbiJ9.RFdozeaQ2NgIoeS2Ml1GnrXgHeFrxf19R0BbXGVX21o',
            'sessionId' => 'p5le1un3vulm0od516m3un08s6',
            'chatBot' => 'https://api-gce3.inbenta.io/prod/chatbot/v1',
            'previousNotFound' => true
        ], 'Hello!', ['Luke', 'Leia'], ['isForce' => true, 'secondNotFound'=> true]);
        $this->assertTrue($getConversationReplyQuery instanceof GetConversationResponse);
        $this->assertTrue(is_array($getConversationReplyQuery->toArray()));
    }

}
