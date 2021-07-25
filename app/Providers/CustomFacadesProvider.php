<?php

namespace App\Providers;

use App\Mail\Client\MailClient;
use App\Mail\Client\TemplateApiClient;
use App\Mail\SponsorshipMail;
use App\Mail\SponsorshipMessageHandler;
use App\Mail\UserMail;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CustomFacadesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mail_client', function (Application $app) {
            return $app->make(MailClient::class);
        });

        $this->app->bind('user_mail', function (Application $app) {
            return $app->make(UserMail::class);
        });

        $this->app->bind('sponsorship_mail', function (Application $app) {
            return $app->make(SponsorshipMail::class);
        });

        $this->app->bind('sponsorship_message_handler', function (Application $app) {
            return $app->make(SponsorshipMessageHandler::class);
        });

        $this->app->bind('template_api_client', function (Application $app) {
            return $app->make(TemplateApiClient::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
