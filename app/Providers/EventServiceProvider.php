<?php

namespace App\Providers;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Models\PersonData;
use App\Models\User;
use App\Observers\CatObserver;
use App\Observers\CatPhotoObserver;
use App\Observers\PersonDataObserver;
use App\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot()
    {
        Cat::observe(CatObserver::class);
        CatPhoto::observe(CatPhotoObserver::class);
        User::observe(UserObserver::class);
        PersonData::observe(PersonDataObserver::class);
    }
}
