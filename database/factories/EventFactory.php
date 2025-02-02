<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence('4'),
            'description' => $this->faker->paragraph(),
            'length' => $this->faker->numberBetween(1, 5),
            'start_date' => $this->faker->dateTime('now', null)
        ];
    }
}
