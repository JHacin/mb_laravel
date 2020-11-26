<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    /**
     * @return void
     */
    public function test_returns_if_user_is_admin()
    {
        $this->assertFalse($this->user->isAdmin());

        foreach (User::ADMIN_ROLES as $role) {
            $this->user->assignRole($role);
            $this->assertTrue($this->user->isAdmin());
            $this->user->removeRole($role);
        }
    }

    /**
     * @return void
     */
    public function test_returns_email_and_id_attribute()
    {
        $email = $this->user->email;
        $id = $this->user->id;

        $this->assertEquals("$email ($id)", $this->user->email_and_id);
    }
}
