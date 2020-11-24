<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CatPhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CatPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cat_id' => Cat::factory(),
            'filename' => $this->faker->word . '.jpg',
            'alt' => $this->faker->text,
            'index' => $this->faker->unique()->numberBetween(
                Arr::first(CatPhotoService::INDICES),
                Arr::last(CatPhotoService::INDICES)
            ),
        ];
    }
}
