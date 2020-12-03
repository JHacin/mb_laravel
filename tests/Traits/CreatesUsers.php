<?php

namespace Tests\Traits;

use App\Models\PersonData;
use App\Models\User;
use Illuminate\Support\Arr;

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

    /**
     * @param array $attributes
     * @return User
     */
    protected function createUserWithPersonData($attributes = [])
    {
        $user = $this->createUser($attributes);
        $personData = Arr::except(PersonData::factory()->make()->toArray(), ['id', 'email']);
        $user->personData->update($personData);
        $user->refresh();
        return $user;
    }
}
