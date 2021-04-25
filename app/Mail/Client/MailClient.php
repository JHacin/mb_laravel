<?php

namespace App\Mail\Client;

use App\Settings\Settings;
use Exception;
use Log;
use Mailgun\Mailgun;

class MailClient
{
    private Mailgun $client;
    private string $domain;

    public function __construct(Mailgun $client)
    {
        $this->client = $client;
        $this->domain = env('MAILGUN_DOMAIN');
    }

    public function send(array $params)
    {
        if (!Settings::hasValueTrue(config('settings.enable_emails'))) {
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
        if (!Settings::hasValueTrue(config('settings.enable_mailing_lists'))) {
            return;
        }

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
        if (!Settings::hasValueTrue(config('settings.enable_mailing_lists'))) {
            return;
        }

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
        if (!Settings::hasValueTrue(config('settings.enable_mailing_lists'))) {
            return;
        }

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
