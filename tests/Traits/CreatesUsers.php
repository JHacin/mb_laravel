<?php

namespace Tests\Traits;

use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Support\Arr;

trait CreatesUsers
{
    /**
     * @param array $attributes
     * @return User
     */
    protected function createUser($attributes = []): User
    {
        /** @var User $user */
        $user = User::factory()->createOne($attributes);

        return $user;
    }

    /**
     * @param array $attributes
     * @return User
     */
    protected function createAdminUser($attributes = []): User
    {
        $user = $this->createUser($attributes);
        $user->assignRole(User::ROLE_ADMIN);

        return $user;
    }

    /**
     * @param array $userAttributes
     * @param array $personDataAttributes
     * @return User
     */
    protected function createUserWithPersonData($userAttributes = [], $personDataAttributes = []): User
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

    /**
     * @param array $attributes
     * @return User
     */
    protected function createUserWithSponsorships($attributes = []): User
    {
        $user = $this->createUserWithPersonData($attributes);

        Sponsorship::factory()->count(4)->create(['person_data_id' => $user->personData->id]);
        $user->refresh();

        return $user;
    }
}
