<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Devolution;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DevolutionDetail>
 */
class DevolutionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'devolution_id' => Devolution::factory(), //all()->random()->id,
            'book_id' => Book::all()->unique()->random()->id,
            'loan_id' => Loan::factory(),
            'status' => fake()->randomElement(['Bueno', 'Aceptable', 'Dañado']),
        ];
    }
}
