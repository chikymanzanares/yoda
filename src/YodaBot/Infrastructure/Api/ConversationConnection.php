<?php

namespace Inbenta\YodaBot\Infrastructure\Api;


use GuzzleHttp\Client;
use Inbenta\YodaBot\Domain\Conversation\Conversation;
use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyBot;
use Inbenta\YodaBot\Domain\ValueObjects\Session;
use Symfony\Component\HttpFoundation\Request;

class ConversationConnection implements Conversation
{

    protected string $accessToken;
    protected int $expiration;
    protected string $chatBot;
    protected string $sessionToken;
    protected string $sessionId;
    protected Client $client;
    protected Request $request;
    protected string $serviceUrl;
    protected string $apiKey;
    protected string $secret;

    public function __construct(Client $client, array $apiConnection= [])
    {
        $this->client = $client;
        $this->serviceUrl = isset($apiConnection['serviceUrl']) ? $apiConnection['serviceUrl'] : env("SERVICE_URL");
        $this->apiKey = isset($apiConnection['apiKey']) ? $apiConnection['apiKey'] : env("API_KEY");
        $this->secret = isset($apiConnection['secret']) ? $apiConnection['secret'] : env("SECRET");

    }

    function initConversation(): Session
    {
        $headers = [
            'x-inbenta-key' => $this->apiKey,
            'Content-Type' => 'application/json'
        ];
        $body = [
            'secret' => $this->secret
        ];
        $this->client = new Client(['headers' => $headers]);
        $response = $this->client->request(
            'POST',
            $this->serviceUrl,
            [
                'form_params' =>
                    $body
            ]
        );
        $arrayResponse = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->accessToken = $arrayResponse['accessToken'];
        $this->expiration = $arrayResponse['expiration'];

        $headers = [
            'x-inbenta-key' => $this->apiKey,
            'Authorization' => 'Bearer '.$this->accessToken
        ];
        $this->client = new Client(['headers' => $headers]);
        $response = $this->client->request(
            'GET',
            'https://api.inbenta.io/v1/apis',
            [
            ]
        );
        $arrayResponse = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->chatBot = $arrayResponse['apis']['chatbot'].'/v1';

        $this->client = new Client(['headers' => $headers]);

        $response = $this->client->request(
            'POST',
            $this->chatBot.'/conversation',
            [
            ]
        );
        $arrayResponse = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->sessionToken = $arrayResponse['sessionToken'];
        $this->sessionId = $arrayResponse['sessionId'];
        return new Session([
            'accessToken' => $this->accessToken,
            'expiration' => $this->expiration,
            'sessionToken' => $this->sessionToken,
            'sessionId' => $this->sessionId,
            'chatBot' => $this->chatBot
        ]);
    }

    function sendReply(Session $session, Reply $reply): ReplyBot
    {
        $sessionArray = $session->getValue();
        $headers = [
            'x-inbenta-key' => $this->apiKey,
            'Authorization' => 'Bearer '.$sessionArray['accessToken'],
            'x-inbenta-session' => 'Bearer '.$sessionArray['sessionToken']
        ];

        $this->client = new Client(['headers' => $headers]);
        $body = [
            'message' => $reply->getValue()
        ];
        $response = $this->client->request(
            'POST',
            $sessionArray['chatBot'].'/conversation/message',
            [
                'form_params' =>
                    $body
            ]
        );
        $arrayResponse = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        return new ReplyBot($arrayResponse);
    }

    function tokenHasExpired(Session $session): bool
    {
        $sessionArray = $session->getValue();
        return (!(isset($sessionArray['expiration']))) || ($sessionArray['expiration'] < time());
    }

}
