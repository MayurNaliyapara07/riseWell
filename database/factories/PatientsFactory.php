<?php

namespace Database\Factories;

use App\Models\Patients;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientsFactory extends Factory
{
    protected $model = Patients::class;
    private static $memberId = 1;
    public function definition()
    {
        return [
            'member_id' => self::$memberId++,
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'dob' => date('Y-m-d'),
            'profile_claimed' => date('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_no' =>'1234567890',
            'country_code' =>'91',
            'gender' => 'M',
            'ssn' => '1234',
            'address' => $this->faker->address(),
            'status' => '1',
        ];
    }
}
