<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    private static $business_phone = '380670000001';
    private static $customer_phone = '380660000001';
    private static $count1 = 1;
    private static $i = 0;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        self::$i++;

        $latestEntry = User::get();

        return [
            'profile_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'account_type' => (self::$i <= 5) ? 2 : 3,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => (self::$i <= 5) ? self::$customer_phone++ : self::$business_phone++,
            'email' => (self::$i <= 5) ? 'user' . self::$count1++ . '.customer@gmail.com' : 'user' . self::$count1++ . '.business@gmail.com',
            'email_verified_at' => now(),
            'address' => (self::$i <= 5) ? null : $this->faker->postcode() . ', ' . $this->faker->country() . ', ' . $this->faker->city(),
            'password' => (self::$i <= 5) ? null : '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
