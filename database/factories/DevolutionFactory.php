<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devolution>
 */
class DevolutionFactory extends Factory
{
    private static $devNumber = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $loan = Loan::all()->random();

        return [
            'dev_date' => now(), //fake()->date(),
            'dev_number' => self::$devNumber++,
            'member_id' => $loan->member_id,
            'status' => fake()->randomElement(['Pendiente', 'Confirmada']), //['Bueno', 'Aceptable', 'Dañado']),
            //'notes' => fake()->sentence($nbWords = 2, $variableNbWords = true),
        ];
    }
}
