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

    public function definition(): array
    {
        return [
            'cat_id' => Cat::factory(),
            'sponsor_id' => PersonData::factory(),
            'payer_id' => PersonData::factory(),
            'payment_type' => Sponsorship::PAYMENT_TYPE_BANK_TRANSFER,
            'monthly_amount' => 5,
            'is_active' => true,
            'is_anonymous' => false,
            'is_gift' => false,
        ];
    }
}
