<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sponsorship::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'cat_id' => Cat::factory(),
            'person_data_id' => PersonData::factory(),
            'monthly_amount' => 5,
            'is_active' => true,
            'is_anonymous' => false,
        ];
    }
}
