<?php

namespace Tests\Feature\Observers;

use App\Models\PersonData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function test_creates_person_data_on_create()
    {
        $user = $this->createUser();
        $personData = PersonData::firstWhere('email', $user->email);
        $this->assertEquals($personData->user->id, $user->id);
    }

    /**
     * @return void
     */
    public function test_associates_existing_person_data_on_create()
    {
        $personData = $this->createPersonData();
        $user = $this->createUser(['email' => $personData->email]);

        $personData->refresh();
        $user->refresh();

        $this->assertEquals($personData->user->id, $user->id);
        $this->assertEquals($user->personData->id, $personData->id);
    }

    /**
     * @return void
     */
    public function test_syncs_email_with_person_data_on_update()
    {
        $user = $this->createUser(['email' => $this->faker->unique()->safeEmail]);
        $this->assertEquals($user->personData->email, $user->email);

        $user->update(['email' => $this->faker->unique()->safeEmail]);
        $user->refresh();
        $this->assertEquals($user->personData->email, $user->email);
    }
}
