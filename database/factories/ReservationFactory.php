<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    private static $resNumber = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'res_date' => now(), //fake()->date(),
            'res_number' => self::$resNumber++,
            'member_id' => Member::all()->random()->id,
            'status' => fake()->randomElement(['Activa', 'Cancelada', 'Completada']),
            //'notes' => fake()->sentence($nbWords = 2, $variableNbWords = true),
        ];
    }
}
