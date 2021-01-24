<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class TemplateApiClientFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'template_api_client';
    }
}
