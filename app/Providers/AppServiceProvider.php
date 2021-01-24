<?php

namespace App\Providers;

use Handlebars\Handlebars;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Mailgun\Mailgun;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Mailgun::class, function ($app) {
            return Mailgun::create(env('MAILGUN_SECRET'), env('MAILGUN_ENDPOINT'));
        });
        $this->app->bind(Handlebars::class, function ($app) {
            return new Handlebars();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('pagination::default');
    }
}
