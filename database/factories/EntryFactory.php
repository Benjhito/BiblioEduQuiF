<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book = Book::all()->random();

        return [
            'rec_date' => now(),
            'book_id' => $book->id,
            'book_code' => $book->code,
            'title' => fake()->sentence,
            'isbn' => $book->isbn,
            'provider_id' => Provider::all()->random()->id,
            'quantity' => fake()->numberBetween(10, 20),
            'missing' => fake()->numberBetween(0, 1),
            'surplus' => fake()->numberBetween(0, 21),
            'price' => fake()->randomFloat($maxDecimals = 2, $min = 1000, $max = 3000),
            'disc_rate' => fake()->randomElement([0, 5, 10, 15, 20, 25, 30]),
            'iva_rate_id' => $book->iva_rate_id,
        ];
    }
}
