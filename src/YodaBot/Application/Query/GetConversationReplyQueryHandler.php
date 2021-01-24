<?php

namespace Inbenta\YodaBot\Application\Query;


use Inbenta\YodaBot\Domain\Conversation\Conversation;
use Inbenta\YodaBot\Domain\Entities\Character\CharacterRepositoryInterface;
use Inbenta\YodaBot\Domain\Entities\Movie\MovieRepositoryInterface;
use Inbenta\YodaBot\Domain\ValueObjects\AlternativeReply;
use Inbenta\YodaBot\Domain\ValueObjects\Reply;
use Inbenta\YodaBot\Domain\ValueObjects\ReplyInfo;
use Inbenta\YodaBot\Domain\ValueObjects\Session;

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
        $session = new Session($query->session());
        if ($this->conversation->tokenHasExpired($session)){
            $newSession = $this->conversation->initConversation();
        } else {
            $newSession = clone $session;
        }
        $reply = new Reply($query->reply());
        $alternativeReply = new AlternativeReply();
        $replyInfo     = new ReplyInfo();
        $replyBot = $this->conversation->sendReply($newSession , $reply);
        $newSession->setPreviousNotFound($replyBot->notFoundAnswer());
        if ($newSession->bothPreviousNotFound($session)){
            $alternativeReply->setValue(($this->characterRepository->getCharacters())->toResponseReply());
            $replyInfo->setSecondNotFound();
        }
        if ($reply->isForce()){
            $alternativeReply->setValue(($this->movieRepository->getMovies())->toResponseReply());
            $replyInfo->setIsForce();
        }
        return new GetConversationResponse($newSession->getValue(), $replyBot->getValueResponse(), $alternativeReply->getValue(), $replyInfo->getValue());
    }
}
