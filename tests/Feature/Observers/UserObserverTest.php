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
    public function testCreatesPersonDataOnCreate()
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
    public function testAssociatesExistingPersonDataOnCreate()
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
    public function testSyncsEmailWithPersonDataOnUpdate()
    {
        /** @var User $user */
        $user = User::factory()->createOne(['email' => $this->faker->unique()->safeEmail]);

        $this->assertEquals($user->personData->email, $user->email);

        $user->update(['email' => $this->faker->unique()->safeEmail]);
        $user = $user->refresh();

        $this->assertEquals($user->personData->email, $user->email);
    }
}
