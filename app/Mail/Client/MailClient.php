<?php

namespace App\Mail\Client;

use Exception;
use Log;
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
        if (env('TEST_ENV') === 'dusk' || env('DISABLE_EMAILS') === true) {
            return;
        }

        if (env('APP_ENV') !== 'production') {
            $params['to'] = env('MAIL_TEST_TO');
        }

        $this->client->messages()->send(
            $this->domain,
            array_merge(['from' => env('MAIL_FROM_ADDRESS')], $params)
        );
    }

    public function addMemberToList(string $list, string $email, array $variables)
    {
        try {
            $this->client->mailingList()->member()->create(
                $this->constructListAddress($list),
                $email,
                null,
                $variables
            );
        } catch (Exception $e) {
            $this->logException($e);
        }
    }

    public function updateListMember(string $list, string $email, array $parameters)
    {
        try {
            $this->client->mailingList()->member()->update(
                $this->constructListAddress($list),
                $email,
                $parameters
            );
        } catch (Exception $e) {
            $this->logException($e);
        }
    }

    public function removeMemberFromList(string $list, string $email)
    {
        try {
            $this->client->mailingList()->member()->delete(
                $this->constructListAddress($list),
                $email
            );
        } catch (Exception $e) {
            $this->logException($e);
        }
    }

    protected function constructListAddress(string $list): string
    {
        return sprintf('%s@%s', $list, env('MAILGUN_DOMAIN'));
    }

    protected function logException(Exception $e)
    {
        Log::error($e->getMessage(), ['trace' => $e->getTrace()]);
    }
}
