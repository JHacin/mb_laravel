<?php

namespace Database\Factories;

use App\Models\PersonData;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PersonData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail
        ];
    }
}
