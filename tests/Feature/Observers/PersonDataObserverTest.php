<?php

namespace Tests\Feature\Observers;

use App\Mail\SponsorMailingListManager;
use Tests\TestCase;

class PersonDataObserverTest extends TestCase
{
    public function test_on_create_gets_email_from_user()
    {
        $user = $this->createUser();
        $this->assertEquals($user->personData->email, $user->email);
    }

    public function test_on_create_is_subscribed_to_mailing_lists()
    {
        $mailingManagerMock = $this->mock(SponsorMailingListManager::class);
        $mailingManagerMock->shouldReceive('addToAllLists')->once();
        $this->createUser();
    }

    public function test_on_update_syncs_email_with_user()
    {
        $user = $this->createUser(['email' => $this->faker->unique()->safeEmail]);
        $this->assertEquals($user->personData->email, $user->email);

        $user->personData->update(['email' => $this->faker->unique()->safeEmail]);
        $user->refresh();
        $this->assertEquals($user->personData->email, $user->email);
    }
}
