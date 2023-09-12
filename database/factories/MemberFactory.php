<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    private static $code = 1000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => (string)self::$code++, //fake()->unique()->randomNumber(4),
            'last_name' => mb_strtoupper(substr(fake()->lastName(), 0, 30)),
            'first_name' => mb_strtoupper(substr(fake()->firstName(), 0, 30)),
            'doc_number' => fake()->unique()->numerify('##-########-#'), //fake()->unique()->randomNumber(8),
            'address' => mb_strtoupper(substr(fake()->streetAddress(), 0, 50)),
            'postcode' => substr(fake()->postcode(), 0, 8),
            'locality' => mb_strtoupper(substr(fake()->city(), 0, 40)),
            'mobile' => substr(fake()->phoneNumber(), 0, 20),
            'email' => fake()->unique()->safeEmail(),
            'adm_date' => $adm_date = fake()->dateTimeBetween('-1 month', 'now'), //fake()->date(),
            'status' => 'Activo', //fake()->randomElement(['Activo', 'Suspendido']),
            'notes' => fake()->sentence($nbWords = 2, $variableNbWords = true), //fake()->text(),
        ];
    }
}
