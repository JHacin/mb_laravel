<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class SponsorshipMailFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sponsorship_mail';
    }
}
