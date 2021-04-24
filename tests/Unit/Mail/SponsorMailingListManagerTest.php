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
    private MockInterface $mailClientMock;
    private SponsorMailingListManager $manager;
    private PersonData $sponsor;
    private array $sponsorVariables;

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
        $this->sponsorVariables = [
            'boter_moski' => $this->sponsor->gender === PersonData::GENDER_MALE,
            'boter_ime' => $this->sponsor->first_name,
            'boter_priimek' => $this->sponsor->last_name,
        ];
    }


    public function test_adds_sponsor_to_all_mailing_lists()
    {
        $this->mailClientMock
            ->shouldReceive('addMemberToList')
            ->with(
                SponsorMailingListManager::ALL_SPONSORS_LIST_ADDRESS,
                $this->sponsor->email,
                $this->sponsorVariables
            );

        $this->manager->addToAllLists($this->sponsor);
    }

    public function test_updates_sponsor_properties()
    {
        $prevEmail = 'previous@example.com';

        $this->mailClientMock
            ->shouldReceive('updateListMember')
            ->with(
                SponsorMailingListManager::ALL_SPONSORS_LIST_ADDRESS,
                $prevEmail,
                [
                    'vars' => $this->sponsorVariables,
                    'address' => $this->sponsor->email,
                ]
            );

        $this->manager->updateProperties($this->sponsor, $prevEmail);
    }

    public function test_removes_sponsor_from_all_mailing_lists()
    {
        $this->mailClientMock
            ->shouldReceive('removeMemberFromList')
            ->with(
                SponsorMailingListManager::ALL_SPONSORS_LIST_ADDRESS,
                $this->sponsor->email
            );
    }
}
