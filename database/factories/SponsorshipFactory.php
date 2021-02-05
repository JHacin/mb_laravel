<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Sponsorship::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'cat_id' => Cat::inRandomOrder()->first() ?: Cat::factory(),
            'person_data_id' => PersonData::inRandomOrder()->first() ?: PersonData::factory(),
            'payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER,
            'monthly_amount' => 5,
            'is_active' => true,
            'is_anonymous' => false,
        ];
    }
}
