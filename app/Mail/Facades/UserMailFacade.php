<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class UserMailFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'user_mail';
    }
}
