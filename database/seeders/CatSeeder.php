<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Seeder;
use Tests\Utilities\TestData\TestCatGarfield;

class CatSeeder extends Seeder
{
    public function run()
    {
        Cat::factory()->createOne([
            'name' => (new TestCatGarfield())->name
        ]);
    }
}
