<?php

namespace Tests\Feature\Observers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonDataObserverTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function test_gets_email_from_user_on_create()
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        $personData = $user->personData;

        $this->assertEquals($personData->email, $user->email);
    }
}
