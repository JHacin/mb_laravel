<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => config('settings.enable_emails'),
                'name' => 'Omogoči pošiljanje mailov',
                'value' => config('settings.value_false'),
                'field' => '{"name":"value","label":"Veljavno?","type":"checkbox"}',
                'active' => 1,
            ],
            [
                'key' => config('settings.enable_mailing_lists'),
                'name' => 'Omogoči mailing sezname',
                'value' => config('settings.value_false'),
                'field' => '{"name":"value","label":"Veljavno?","type":"checkbox"}',
                'active' => 1,
            ],
        ];

        foreach ($settings as $index => $setting) {
            $result = DB::table('settings')->insert($setting);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }
    }
}
