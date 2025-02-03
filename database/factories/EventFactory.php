<?php

namespace Database\Factories;

use App\Models\Category;
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
            'available_tickets' => $this->faker->numberBetween(10, 200),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'category_id' => Category::find(rand(1, 5))
        ];
    }
}
