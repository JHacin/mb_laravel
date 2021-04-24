<?php

namespace Tests\Feature\Observers;

use App\Mail\SponsorMailingListManager;
use App\Models\PersonData;
use Exception;
use Mockery\MockInterface;
use Tests\TestCase;

class PersonDataObserverTest extends TestCase
{
    private MockInterface $mailingManagerMock;
    private PersonData $personData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailingManagerMock = $this->mock(SponsorMailingListManager::class);
        $this->mailingManagerMock->shouldReceive('addToAllLists')->once();
        $this->personData = $this->createPersonData();
    }

    public function test_on_create_gets_email_from_user_and_is_subscribed_to_mailing_lists()
    {
        $this->mailingManagerMock->shouldReceive('addToAllLists')->once();
        $personData = $this->createPersonData(['user_id' => $this->createUserWithoutEvents()->id]);
        $this->assertEquals($personData->email, $personData->user->email);
    }

    public function test_on_updating_updates_mailing_list_properties()
    {
        $emailInList = $this->personData->email;
        $newEmail = 'new_' . $emailInList;

        // Original email
        $this->mailingManagerMock->shouldReceive('updateProperties')->once()->with($this->personData, $emailInList);
        $this->personData->update(['email' => $newEmail]);

        // Updated email
        $this->mailingManagerMock->shouldReceive('updateProperties')->once()->with($this->personData, $newEmail);
        $this->personData->update(['email' => null]);

        // Should not update properties if original email is falsy
        $this->mailingManagerMock->shouldNotReceive('updateProperties');
        $this->personData->update(['email' => null]);

        // Should not update properties if current email is falsy
        $this->mailingManagerMock->shouldNotReceive('updateProperties');
        $this->personData->update(['first_name' => null]);
    }

    public function test_on_update_syncs_email_with_user()
    {
        $this->mailingManagerMock->shouldReceive('addToAllLists');
        $this->mailingManagerMock->shouldReceive('updateProperties');

        $user = $this->createUser(['email' => $this->faker->unique()->safeEmail]);
        $this->assertEquals($user->personData->email, $user->email);

        $user->personData->update(['email' => $this->faker->unique()->safeEmail]);
        $user->refresh();
        $this->assertEquals($user->personData->email, $user->email);
    }

    /**
     * @throws Exception
     */
    public function test_on_delete_is_unsubscribed_from_all_mailing_lists()
    {
        $this->mailingManagerMock->shouldReceive('removeFromAllLists')->once()->with($this->personData);
        $this->personData->delete();
    }
}
