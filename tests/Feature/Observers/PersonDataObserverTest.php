<?php

namespace Tests\Feature\Observers;

use Tests\TestCase;

class PersonDataObserverTest extends TestCase
{
    /**
     * @return void
     */
    public function test_gets_email_from_user_on_create()
    {
        $user = $this->createUser();
        $this->assertEquals($user->personData->email, $user->email);
    }

    /**
     * @return void
     */
    public function test_syncs_email_with_user_on_update()
    {
        $user = $this->createUser(['email' => $this->faker->unique()->safeEmail]);
        $this->assertEquals($user->personData->email, $user->email);

        $user->personData->update(['email' => $this->faker->unique()->safeEmail]);
        $user->refresh();
        $this->assertEquals($user->personData->email, $user->email);
    }
}
