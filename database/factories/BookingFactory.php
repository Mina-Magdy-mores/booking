<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $event = Event::inRandomOrder()->first();
        $max_quantity = min(10, $event->available_seats);
        $quantity = $this->faker->numberBetween(1, $max_quantity);
        $event_new_available_seats = $event->available_seats - $quantity;
        $event->available_seats = $event_new_available_seats;
        $event->save();
        $total_price = $quantity * $event->price;
        return [
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'event_id' => $event->id ?? Event::factory()->create()->id,
            'quantity' => $quantity,
            'total_price' => $total_price,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),

        ];
    }
}
