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
     * @var string
     */
    protected $model = CatPhoto::class;

    public function definition(): array
    {
        return [
            'cat_id' => Cat::factory(),
            'filename' => $this->faker->ean13 . '.jpg',
            'alt' => $this->faker->text,
            'index' => $this->faker->numberBetween(
                Arr::first(CatPhotoService::INDICES),
                Arr::last(CatPhotoService::INDICES)
            ),
        ];
    }
}
