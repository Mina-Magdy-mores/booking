<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
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
        $start_date = $this->faker->dateTimeBetween('now', '+1 month');
        $end_date = clone $start_date;
        $end_date->modify('+' . $this->faker->numberBetween(1, 30) . ' days');
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'start_date' => $start_date,
            'ended_date' => $end_date,
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'available_seats' => $this->faker->numberBetween(10, 1000),
            'is_active' => $this->faker->boolean(90),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
        ];
    }
}
