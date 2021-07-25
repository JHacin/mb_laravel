<?php

namespace Tests\Unit\Mail\Client;

use App\Mail\Client\MailClient;
use App\Settings\Settings;
use Mailgun\Mailgun;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class MailClientTest extends TestCase
{
    /**
     * @var MockInterface|Settings
     */
    protected $settingsMock;

    /**
     * @var MockInterface|Mailgun
     */
    protected $mailgunMock;

    protected MailClient $client;
    protected string $list = 'list';
    protected string $listAddress;
    protected string $emailAddress = 'email_address';

    protected function setUp(): void
    {
        parent::setUp();

        $this->settingsMock = $this->mock('overload:'.Settings::class);
        $this->mailgunMock = $this->mock(Mailgun::class);
        $this->client = new MailClient($this->mailgunMock);
        $this->listAddress = $this->list . '@' . env('MAILGUN_DOMAIN');
    }

    public function test_sends_message_with_params()
    {
        $this->enableSetting(config('settings.enable_emails'));

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
        $this->enableSetting(config('settings.enable_mailing_lists'));

        $variables = ['var' => 'value'];

        $this->mailgunMock
            ->shouldReceive('mailingList->member->create')
            ->once()
            ->with($this->listAddress, $this->emailAddress, null, $variables);

        $this->client->addMemberToList($this->list, $this->emailAddress, $variables);
    }

    public function test_updates_list_member()
    {
        $this->enableSetting(config('settings.enable_mailing_lists'));

        $parameters = ['param' => 'value'];

        $this->mailgunMock
            ->shouldReceive('mailingList->member->update')
            ->once()
            ->with($this->listAddress, $this->emailAddress, $parameters);

        $this->client->updateListMember($this->list, $this->emailAddress, $parameters);
    }

    public function test_removes_member_from_list()
    {
        $this->enableSetting(config('settings.enable_mailing_lists'));

        $this->mailgunMock
            ->shouldReceive('mailingList->member->delete')
            ->once()
            ->with($this->listAddress, $this->emailAddress);

        $this->client->removeMemberFromList($this->list, $this->emailAddress);
    }

    private function enableSetting(string $key)
    {
        $this->settingsMock->shouldReceive('hasValueTrue')->once()->with($key)->andReturn(true);
    }
}
