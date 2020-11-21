<?php

namespace Tests\Feature\Observers;

use App\Models\PersonData;
use App\Models\User;
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
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var PersonData $personData */
        $personData = PersonData::firstWhere('email', $user->email);

        $this->assertEquals($personData->user->id, $user->id);
    }

    /**
     * @return void
     */
    public function test_associates_existing_person_data_on_create()
    {
        /** @var PersonData $personData */
        $personData = PersonData::factory()->createOne();
        /** @var User $user */
        $user = User::factory()->createOne(['email' => $personData->email]);

        $personData = $personData->refresh();
        $user = $user->refresh();

        $this->assertEquals($personData->user->id, $user->id);
        $this->assertEquals($user->personData->id, $personData->id);
    }

    /**
     * @return void
     */
    public function test_syncs_email_with_person_data_on_update()
    {
        /** @var User $user */
        $user = User::factory()->createOne(['email' => $this->faker->unique()->safeEmail]);

        $this->assertEquals($user->personData->email, $user->email);

        $user->update(['email' => $this->faker->unique()->safeEmail]);
        $user = $user->refresh();

        $this->assertEquals($user->personData->email, $user->email);
    }
}
