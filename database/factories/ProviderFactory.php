<?php

namespace Database\Factories;

use App\Models\IvaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
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
            'code' => (string)self::$code++, //str(fake()->unique()->numberBetween(100, 200)),
            'business_name' => mb_strtoupper(substr(fake()->company(), 0, 40)),
            'address' => mb_strtoupper(substr(fake()->streetAddress(), 0, 50)),
            'postcode' => substr(fake()->postcode(), 0, 8),
            'locality' => mb_strtoupper(substr(fake()->city(), 0, 40)),
            'province' => mb_strtoupper(substr(fake()->city(), 0, 40)),
            'country' => mb_strtoupper(substr(fake()->country(), 0, 40)),
            'phone1' => substr(fake()->phoneNumber(), 0, 20),
            'phone2' => substr(fake()->phoneNumber(), 0, 20),
            'email' => fake()->unique()->safeEmail(),
            'url' => fake()->url(),
            'acc_type' => fake()->randomElement(['CC', 'CA']),
            'acc_number' => fake()->numerify('###############'),
            'cuit' => fake()->unique()->numerify('##-########-#'), //regexify('\d{2}-\d{8}-\d{1}'),
            'iva_type_id' => IvaType::all()->random()->id,
            'inv_type' => fake()->randomElement(['A', 'B', 'C', 'X']),
            'contact' => substr(fake()->name(), 0, 30)
        ];
    }
}
