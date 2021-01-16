<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessage;
use App\Models\SponsorshipMessageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipMessageFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = SponsorshipMessage::class;

    public function definition(): array
    {
        return [
            'message_type_id' => SponsorshipMessageType::inRandomOrder()->first() ?: SponsorshipMessageType::factory(),
            'cat_id' => Cat::inRandomOrder()->first() ?: Cat::factory(),
            'person_data_id' => PersonData::inRandomOrder()->first() ?: PersonData::factory(),
        ];
    }
}
