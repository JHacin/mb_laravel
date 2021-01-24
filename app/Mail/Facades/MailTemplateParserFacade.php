<?php

/** @noinspection PhpUndefinedClassInspection */

namespace App\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class MailTemplateParserFacade extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'template_parser';
    }
}
