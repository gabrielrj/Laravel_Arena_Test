<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NumberFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numerify('#########'),
            'status' => 'active'
        ];
    }
}
