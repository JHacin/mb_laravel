<?php

namespace Database\Seeders;

use App\Models\PersonData;
use Illuminate\Database\Seeder;
use Tests\Utilities\TestData\TestPersonDataUnauthenticated;

class PersonDataSeeder extends Seeder
{
    public function run()
    {
        $this->createOneUnauthenticated();
    }

    protected function createOneUnauthenticated()
    {
        PersonData::factory()->createOne(['email' => TestPersonDataUnauthenticated::getEmail()]);
    }
}
