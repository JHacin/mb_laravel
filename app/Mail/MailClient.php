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
     * @param Mailgun $client
     */
    public function __construct(Mailgun $client)
    {
        $this->client = $client;
        $this->domain = env('MAILGUN_DOMAIN');
    }

    /**
     * @param array $params
     */
    public function send(array $params)
    {
        if (env('APP_ENV') !== 'production') {
            $params['to'] = env('MAIL_TEST_TO');
        }

        $this->client->messages()->send(
            $this->domain,
            array_merge(['from' => env('MAIL_FROM_ADDRESS')], $params)
        );
    }
}
