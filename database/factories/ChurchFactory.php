<?php

namespace Database\Factories;

use App\Models\Church;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChurchFactory extends Factory
{
    protected $model = Church::class;

    public function definition(): array
    {
        return [
            'name'=>fake()->firstName(),
            'abbreviation'=>fake()->slug(),
            'phone'=>fake()->phoneNumber(),
            'email'=>fake()->email(),
            'address'=>fake()->address(),
            'city'=>fake()->city(),
            'state'=>fake()->randomElement(['HAUT-KATANGA','KINSHASA','GOMA']),
            'country'=>'R.D Congo',
            'user_id'=>User::all()->random()->id,
        ];
    }
}
