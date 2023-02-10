<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->name(),
            "last_name" => fake()->lastName(),
            "weight" => fake()->numberBetween(0, 130),
            "height" => fake()->numberBetween(150, 230),
            "city_id" => City::factory(),
            "user_id" => User::factory()
        ];
    }
}
