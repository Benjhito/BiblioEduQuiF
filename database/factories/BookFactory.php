<?php

namespace Database\Factories;

use App\Models\IvaRate;
use App\Models\Publisher;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    private static $code = 10000;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => (string)self::$code++, //fake()->unique()->randomNumber(4),
            'title' => fake()->sentence,
            'subtitle' => fake()->sentence,
            'descrip' => fake()->sentence, //paragraph,
            'author' => fake()->lastName(),
            'edition' => fake()->randomNumber(1,3),
            'pub_year' => fake()->year(),
            'isbn' => fake()->isbn13(),
            'collection_id' => Collection::all()->random()->id,
            'publisher_id' => Publisher::all()->random()->id,
            'binding' => fake()->randomElement(['Tapa blanda', 'Tapa dura', 'En espiral', 'Cosido']),
            'page_count' => fake()->numberBetween(100, 500),
            'format' => fake()->randomElement(['A4', 'A5']),
            'tome_count' => fake()->numberBetween(1, 3),
            'weight' => fake()->numberBetween(200, 800), //fake()->randomFloat(2, 0.1, 2.0),
            'price' => $price = fake()->randomFloat($maxDecimals = 2, $min = 100, $max = 1000),
            'disc_rate' => fake()->randomElement([0, 5, 10, 15, 20, 25, 30]),
            'iva_rate_id' => IvaRate::all()->random()->id,
            'status' => fake()->randomElement(['Disponible', 'Prestado', 'Reservado']),
            'image' => '', //fake()->imageUrl(200, 200),
        ];
    }
}
