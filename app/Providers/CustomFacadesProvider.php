<?php

namespace App\Providers;

use App\Mail\Client\MailClient;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CustomFacadesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mail_client', function (Application $app) {
            return $app->make(MailClient::class);
        });
    }

    public function boot()
    {
        //
    }
}
