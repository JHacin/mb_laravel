<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\CatLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Cat::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name,
            'gender' => array_rand(Cat::GENDER_LABELS),
            'story' => $this->faker->text,
            'date_of_birth' => $this->faker->date(),
            'date_of_arrival_mh' => $this->faker->date(),
            'date_of_arrival_boter' => $this->faker->date(),
            'location_id' => CatLocation::inRandomOrder()->first() ?: CatLocation::factory(),
            'is_active' => true,
            'is_group' => $this->faker->boolean,
        ];
    }
}
