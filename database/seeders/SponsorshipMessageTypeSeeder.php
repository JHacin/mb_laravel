<?php

namespace Database\Seeders;

use App\Models\SponsorshipMessageType;
use Illuminate\Database\Seeder;

class SponsorshipMessageTypeSeeder extends Seeder
{
    public function run()
    {
        SponsorshipMessageType::factory()->count(10)->create();
    }
}
