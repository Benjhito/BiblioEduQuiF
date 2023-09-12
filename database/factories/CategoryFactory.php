<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'code' => (string)self::$code++, //Str::random(10),
            'name' => substr(fake()->name(), 0, 30),
            'descrip' => substr(fake()->sentence(2), 0, 40),
            'image' => '', //fake()->imageUrl(200, 200),
        ];
    }
}
