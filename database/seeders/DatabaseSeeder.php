<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PersonDataSeeder::class,
            UserSeeder::class,
            CatLocationSeeder::class,
            CatSeeder::class,
            SponsorshipSeeder::class,
            SponsorshipMessageTypeSeeder::class,
            SponsorshipMessageSeeder::class,
        ]);
    }
}
