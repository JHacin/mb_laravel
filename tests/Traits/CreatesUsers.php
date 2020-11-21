<?php

namespace Tests\Traits;

use App\Models\User;

trait CreatesUsers
{
    /**
     * @param array $attributes
     * @return User
     */
    protected function createUser($attributes = [])
    {
        /** @var User $user */
        $user = User::factory()->createOne($attributes);
        return $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    protected function createAdminUser($attributes = [])
    {
        $user = $this->createUser($attributes);
        $user->assignRole(User::ROLE_ADMIN);
        return $user;
    }
}
