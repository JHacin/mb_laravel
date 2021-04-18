<?php

namespace Tests\Unit\Mail\Client;

use App\Mail\Client\MailClient;
use Illuminate\Contracts\Container\BindingResolutionException;
use Mailgun\Mailgun;
use Mockery\MockInterface;
use Tests\TestCase;

class MailClientTest extends TestCase
{
    protected MockInterface $mailgunMock;
    protected MailClient $client;
    protected string $list = 'list';
    protected string $listAddress;
    protected string $emailAddress = 'email_address';

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mailgunMock = $this->mock(Mailgun::class);
        $this->client = $this->app->make(MailClient::class);
        $this->listAddress = $this->list . '@' . env('MAILGUN_DOMAIN');
    }

    public function test_sends_message_with_params()
    {
        $params = [
            'to' => env('MAIL_TEST_TO'),
            'subject' => 'Hello',
            'text' => 'This is a message.',
        ];

        $this->mailgunMock
            ->shouldReceive('messages->send')
            ->once()
            ->with(
                env('MAILGUN_DOMAIN'),
                array_merge(['from' => env('MAIL_FROM_ADDRESS')], $params)
            );

        $this->client->send($params);
    }

    public function test_adds_member_to_list()
    {
        $variables = ['var' => 'value'];

        $this->mailgunMock
            ->shouldReceive('mailingList->member->create')
            ->once()
            ->with($this->listAddress, $this->emailAddress, null, $variables);

        $this->client->addMemberToList($this->list, $this->emailAddress, $variables);
    }

    public function test_updates_list_member()
    {
        $parameters = ['param' => 'value'];

        $this->mailgunMock
            ->shouldReceive('mailingList->member->update')
            ->once()
            ->with($this->listAddress, $this->emailAddress, $parameters);

        $this->client->updateListMember($this->list, $this->emailAddress, $parameters);
    }

    public function test_removes_member_from_list()
    {
        $this->mailgunMock
            ->shouldReceive('mailingList->member->delete')
            ->once()
            ->with($this->listAddress, $this->emailAddress);

        $this->client->removeMemberFromList($this->list, $this->emailAddress);
    }
}
