<?php

namespace Database\Factories;

use App\Models\Church;
use App\Models\Preaching;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreachingFactory extends Factory
{
    protected $model = Preaching::class;

    public function definition(): array
    {
        return [
            'title' => fake()->firstName(),
            'description' => fake()->paragraph(),
            'audio_url' => fake()->url(),
            'preacher' => fake()->firstName(),
            'color' => fake()->colorName,
            'church_id' => Church::all()->random()->id,
        ];
    }
}
