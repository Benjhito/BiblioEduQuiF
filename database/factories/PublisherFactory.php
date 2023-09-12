<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    private static $code = 100;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => (string)self::$code++,
            'name' => mb_strtoupper(substr(fake()->company(), 0, 40)),
            'address' => mb_strtoupper(substr(fake()->streetAddress(), 0, 50)),
            'postcode' => substr(fake()->postcode(), 0, 8),
            'city' => mb_strtoupper(substr(fake()->city(), 0, 40)),
            'state' => mb_strtoupper(substr(fake()->city(), 0, 40)),
            'country' => mb_strtoupper(substr(fake()->country(), 0, 40)),
            'phone' => substr(fake()->phoneNumber(), 0, 20),
            'email' => fake()->unique()->safeEmail(),
            'url' => fake()->url(),
            'logo' => '',
        ];
    }
}
