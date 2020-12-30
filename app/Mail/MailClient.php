<?php

namespace App\Mail;

use Mailgun\Mailgun;

class MailClient
{
    /**
     * @var Mailgun
     */
    private Mailgun $client;

    /**
     * @var mixed
     */
    private string $domain;

    /**
     * @param Mailgun|null $mailgun
     */
    public function __construct($mailgun = null)
    {
        $this->client = $mailgun ?: Mailgun::create(env('MAILGUN_SECRET'), 'https://' . env('MAILGUN_ENDPOINT'));
        $this->domain = env('MAILGUN_DOMAIN');
    }

    /**
     * @param array $params
     */
    public function send(array $params)
    {
        $this->client->messages()->send(
            $this->domain,
            array_merge(['from' => env('MAIL_FROM_ADDRESS')], $params)
        );
    }
}
