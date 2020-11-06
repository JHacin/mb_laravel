<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Illuminate\Database\Seeder;
use Tests\Utilities\TestData\TestCatGarfield;
use Tests\Utilities\TestData\TestPersonDataUnauthenticated;
use Tests\Utilities\TestData\TestUserAuthenticated;

class SponsorshipSeeder extends Seeder
{
    /**
     * @var Cat
     */
    protected $cat;

    public function run()
    {
        $this->cat = Cat::factory()->createOne(['name' => TestCatGarfield::getName()]);
        $this->createOneWithAuthenticatedUser();
        $this->createOneWithUnauthenticatedUser();
    }

    protected function createOneWithAuthenticatedUser()
    {
        Sponsorship::factory()->createOne([
            'cat_id' => $this->cat->id,
            'person_data_id' => PersonData::firstWhere('email', TestUserAuthenticated::getEmail())->id,
        ]);
    }

    protected function createOneWithUnauthenticatedUser()
    {
        Sponsorship::factory()->createOne([
            'cat_id' => $this->cat->id,
            'person_data_id' => PersonData::firstWhere('email', TestPersonDataUnauthenticated::getEmail())->id,
        ]);
    }
}
