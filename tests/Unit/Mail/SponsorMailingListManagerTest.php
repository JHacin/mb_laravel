<?php

namespace Tests\Unit\Mail;

use App\Mail\Client\MailClient;
use App\Mail\SponsorMailingListManager;
use App\Models\PersonData;
use Illuminate\Contracts\Container\BindingResolutionException;
use Mockery\MockInterface;
use Tests\TestCase;

class SponsorMailingListManagerTest extends TestCase
{
    protected MockInterface $mailClientMock;
    protected SponsorMailingListManager $manager;
    protected PersonData $sponsor;

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mailClientMock = $this->mock(MailClient::class);
        $this->manager = $this->app->make(SponsorMailingListManager::class);

        $this->mailClientMock->shouldReceive('addMemberToList');
        $this->sponsor = $this->createPersonData();
    }


    public function test_adds_sponsor_to_all_mailing_lists()
    {
        $variables = [
            'boter_moski' => $this->sponsor->gender === PersonData::GENDER_MALE,
            'boter_ime' => $this->sponsor->first_name,
            'boter_priimek' => $this->sponsor->last_name,
        ];

        $this->mailClientMock
            ->shouldReceive('addMemberToList')
            ->with(SponsorMailingListManager::ALL_SPONSORS_LIST_ADDRESS, $this->sponsor->email, $variables);

        $this->manager->addToAllLists($this->sponsor);
    }

    public function test_removes_sponsor_from_all_mailing_lists()
    {
        $this->mailClientMock
            ->shouldReceive('removeMemberFromList')
            ->with(SponsorMailingListManager::ALL_SPONSORS_LIST_ADDRESS, $this->sponsor->email);
    }
}
