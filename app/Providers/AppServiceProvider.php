<?php

namespace App\Providers;

use App\Mail\Client\TemplateApiClient;
use App\Mail\MailTemplateParser;
use App\Mail\UserMail;
use Handlebars\Handlebars;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Mailgun\Mailgun;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Mailgun::class, function (Application $app) {
            return Mailgun::create(env('MAILGUN_SECRET'), env('MAILGUN_ENDPOINT'));
        });
        $this->app->singleton(MailTemplateParser::class, function (Application $app) {
            return new MailTemplateParser(new Handlebars());
        });
        $this->app->singleton(TemplateApiClient::class, function (Application $app) {
            return new TemplateApiClient();
        });
        $this->app->singleton(UserMail::class, function (Application $app) {
            return new UserMail();
        });
    }

    public function boot()
    {
        Paginator::defaultView('pagination::default');
    }
}
