<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservationDetail>
 */
class ReservationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(), //all()->random()->id,
            'book_id' => Book::all()->unique()->random()->id,
            'status' => fake()->randomElement(['Pendiente', 'Confirmada']),
        ];
    }
}
