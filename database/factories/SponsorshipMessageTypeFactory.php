<?php

namespace Database\Factories;

use App\Models\SponsorshipMessageType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipMessageTypeFactory extends Factory
{
    protected $model = SponsorshipMessageType::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'template_id' => $this->faker->unique()->uuid,
            'is_active' => $this->faker->boolean,
        ];
    }
}
