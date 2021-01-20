<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Inbenta\YodaBot\Application\Query\GetConversationReplyQueryHandler;
use Inbenta\YodaBot\Infrastructure\Api\ConversationConnection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     * use Symfony\Component\HttpFoundation\Session\Session;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
     */
    public function register()
    {
        $this->app->bind('Symfony\\Component\\HttpFoundation\\Session\\SessionInterface',
            'Symfony\\Component\\HttpFoundation\\Session\\Session');

        $this->app->bind('Inbenta\\YodaBot\\Domain\\Conversation\\Conversation',
            'Inbenta\\YodaBot\\Infrastructure\\Api\\ConversationConnection');

        /*
        $this->app->bind('Inbenta\\YodaBot\\Application\\Query\\GetConversationReplyQueryHandler', function($app)
        {
            return new GetConversationReplyQueryHandler(
                new ConversationConnection(
                    new Client()
                )
            );
        });
        */

        $this->app->bind('Inbenta\\YodaBot\\Application\\Query\\GetConversationReplyQueryHandler', function($app)
        {
            return new GetConversationReplyQueryHandler(
                new ConversationConnection(
                    new Client()
                )
            );
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
