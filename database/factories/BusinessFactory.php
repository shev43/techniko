<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{

    private static $i = 3;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $latestEntry = Business::get();

        return [
            'user_id' => self::$i++,
            'business_number' => str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT),
            'name' => $this->faker->company(),
            'phone' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->companyEmail(),
            'address' => $this->faker->streetAddress(),
            'description' => $this->faker->realText(),
        ];
    }
}
