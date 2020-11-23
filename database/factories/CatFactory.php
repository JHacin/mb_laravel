<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\CatLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name,
            'gender' => array_rand(Cat::GENDER_LABELS),
            'date_of_arrival_mh' => $this->faker->date(),
            'date_of_arrival_boter' => $this->faker->date(),
            'location_id' => CatLocation::factory()->createOne(),
            'is_active' => true,
        ];
    }
}
