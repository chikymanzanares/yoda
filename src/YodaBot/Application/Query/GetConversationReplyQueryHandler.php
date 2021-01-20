<?php

namespace Inbenta\YodaBot\Application\Query;


use Inbenta\YodaBot\Domain\Conversation\Conversation;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterRepositoryInterface;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieRepositoryInterface;
use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyBot;

class GetConversationReplyQueryHandler
{
    protected GetConversationReplyQuery $query;
    protected Conversation $conversation;
    protected CharacterRepositoryInterface $characterRepository;
    protected MovieRepositoryInterface $movieRepository;

    public function __construct(Conversation $conversation,
                                CharacterRepositoryInterface $characterRepository,
                                MovieRepositoryInterface $movieRepository)
    {
        $this->conversation = $conversation;
        $this->characterRepository = $characterRepository;
        $this->movieRepository = $movieRepository;
    }

    public function __invoke(GetConversationReplyQuery $query): GetConversationResponse
    {
        if ($this->conversation->tokenHasExpired($query->session())){
            $newSession = $this->conversation->initConversation();
        } else {
            $newSession = $query->session();
        }
        $reply = new Reply($query->reply());
        $alternativeReply = [];
        $infoResponse     = ['secondNotFound' => false, 'isForce'=> false ];
        $replyBot = new ReplyBot($this->conversation->sendReply($newSession , $query->reply()));
        if (($newSession['previousNotFound'] = $replyBot->notFoundAnswer()) &&
            $query->session()['previousNotFound']){
            $alternativeReply = ($this->characterRepository->getCharacters())->toResponseReply();
            $infoResponse['secondNotFound'] = true;
        }
        if ($reply->isForce()){
            $alternativeReply = ($this->movieRepository->getMovies())->toResponseReply();
            $infoResponse['isForce'] = true;
        }
        return new GetConversationResponse($newSession, $replyBot->getValueResponse(), $alternativeReply, $infoResponse);
    }
}
