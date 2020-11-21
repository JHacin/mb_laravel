<?php

namespace Database\Seeders;

use App\Models\PersonData;
use Illuminate\Database\Seeder;

class PersonDataSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        PersonData::factory()->count(10)->create();
    }
}
