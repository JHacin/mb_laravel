<?php

namespace Tests\Feature\Observers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonDataObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_gets_email_from_user_on_create()
    {
        $user = $this->createUser();
        $this->assertEquals($user->personData->email, $user->email);
    }
}
