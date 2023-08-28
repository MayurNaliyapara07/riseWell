<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Cyber', 'last_name' => 'Joker', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'eric.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Pixel', 'last_name' => 'Princess', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'ersely.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Code', 'last_name' => 'Ninja', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'erselyy.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Byte', 'last_name' => 'Babe', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'festim.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Techno', 'last_name' => 'Whiz', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'fisnik86.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Virtual', 'last_name' => 'Vixen', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'fitimii.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Crypto', 'last_name' => 'Guru', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'fjollaaa.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Digital', 'last_name' => 'Daynamo', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'gokgaurav.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Geek', 'last_name' => 'Goddess', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'gzoni05.olsen@gmail.com'),
            array('user_type' => 'Provider', 'suffix' => 'Dr', 'first_name' => 'Techno', 'last_name' => 'Champ', 'designation' => 'Test', 'dob' => date('Y-m-d'), 'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(), 'password' => Hash::make("12345678"), 'email' => 'intelasif27.olsen@gmail.com'),
        );
        DB::table('users')->insert($users);
    }
}
