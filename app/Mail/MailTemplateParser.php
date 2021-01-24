<?php

namespace App\Mail;

use Handlebars\Handlebars;

class MailTemplateParser
{
    protected Handlebars $engine;

    public function __construct(Handlebars $engine)
    {
        $this->engine = $engine;
    }

    public function parse(string $template, array $variables): string
    {
        return $this->engine->render($template, $variables);
    }
}
