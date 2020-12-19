<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Cat::factory()->count(50)->create();
    }
}
