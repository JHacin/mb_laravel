<?php

namespace Database\Seeders;

use App\Models\SponsorshipMessageType;
use Illuminate\Database\Seeder;

class SponsorshipMessageTypeSeeder extends Seeder
{
    public function run()
    {
        SponsorshipMessageType::factory()->count(10)->create();

        SponsorshipMessageType::factory()->createOne([
            'name' => 'Prvi pozdrav 1',
            'subject' => 'Prvi pozdrav 1',
            'template_id' => 'prvi_pozdrav_1',
            'is_active' => true,
        ]);
    }
}
