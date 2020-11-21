<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        Sponsorship::factory()->count(5)->create();
    }
}
