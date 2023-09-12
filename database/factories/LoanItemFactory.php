<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanDetail>
 */
class LoanItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(), //all()->random()->id,
            'book_id' => Book::all()->unique()->random()->id,
            'due_date' => now()->addDay(3),
        ];
    }
}
