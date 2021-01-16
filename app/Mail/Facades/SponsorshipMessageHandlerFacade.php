<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class SponsorshipMessageHandlerFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sponsorship_message_handler';
    }
}
