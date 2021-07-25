<?php

namespace App\Providers;

use App\Mail\MailTemplateParser;
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
    }

    public function boot()
    {
        Paginator::defaultView('pagination::default');
    }
}
