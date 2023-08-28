<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_type' => 'Provider',
            'suffix' => 'Dr',
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'designation' => 'Test',
            'dob' => date('Y-m-d'),
            'gender' => 'M',
            'city_name' => $this->faker->city(),
            'bio' => $this->faker->text(),
            'status' => '1',
            'is_approve' => '1',
            'middle_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phone_no' =>'1234567890',
            'country_code' =>'91',
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
            'remember_token' => Str::random(10),
        ];
    }

}
