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
    public function testGetsEmailFromUserOnCreate()
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        $personData = $user->personData;

        $this->assertEquals($personData->email, $user->email);
    }
}
