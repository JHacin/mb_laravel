<?php

namespace Database\Seeders;

use App\Models\CatLocation;
use Illuminate\Database\Seeder;

class CatLocationSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        CatLocation::factory()->count(25)->create();
    }
}
