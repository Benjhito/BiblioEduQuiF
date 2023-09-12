<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    private static $loanNumber = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_date' => now(), //fake()->date(),
            'loan_number' => self::$loanNumber++,
            'member_id' => Member::all()->random()->id,
            'status' => fake()->randomElement(['Pendiente', 'Confirmado']),
            //'notes' => fake()->sentence($nbWords = 2, $variableNbWords = true),
        ];
    }
}
