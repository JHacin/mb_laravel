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
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cat_id' => Cat::factory(),
            'person_data_id' => PersonData::factory(),
            'monthly_amount' => 5,
            'is_active' => true,
        ];
    }
}
