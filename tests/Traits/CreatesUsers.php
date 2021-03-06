<?php

namespace Tests\Traits;

use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Support\Arr;

trait CreatesUsers
{
    protected function createUser(array $attributes = []): User
    {
        /** @var User $user */
        $user = User::factory()->createOne($attributes);

        return $user;
    }

    protected function createUserWithoutEvents(array $attributes = []): User
    {
        $user = User::withoutEvents(function () use ($attributes) {
            return $this->createUser($attributes);
        });

        return $user;
    }

    protected function makeUser(array $attributes = []): User
    {
        /** @var User $user */
        $user = User::factory()->makeOne($attributes);

        return $user;
    }

    protected function createSuperAdminUser(array $attributes = []): User
    {
        $user = $this->createUser($attributes);
        $user->assignRole(User::ROLE_SUPER_ADMIN);
        $user->assignRole(User::ROLE_ADMIN);
        $user->assignRole(User::ROLE_EDITOR);

        return $user;
    }

    protected function createNonSuperAdminUser(array $attributes = []): User
    {
        $user = $this->createUser($attributes);
        $user->assignRole(User::ROLE_ADMIN);
        $user->assignRole(User::ROLE_EDITOR);

        return $user;
    }

    protected function createUserWithPersonData(array $userAttributes = [], array $personDataAttributes = []): User
    {
        $user = $this->createUser($userAttributes);

        $personData = Arr::except(
            PersonData::factory()->make($personDataAttributes)->toArray(),
            ['id', 'email']
        );
        $user->personData->update($personData);
        $user->refresh();

        return $user;
    }

    protected function createUserWithSponsorships(array $attributes = []): User
    {
        $user = $this->createUserWithPersonData($attributes);

        Sponsorship::factory()->count(4)->create(['sponsor_id' => $user->personData->id]);
        $user->refresh();

        return $user;
    }
}
