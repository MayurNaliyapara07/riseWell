<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = array(
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Cyber', 'last_name' => 'Joker',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'olsen@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Pixel', 'last_name' => 'Princess',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'ersely@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Code', 'last_name' => 'Ninja',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'erselyy@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Byte', 'last_name' => 'Babe',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'festim@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Techno', 'last_name' => 'Whiz',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'fisnik86@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Virtual', 'last_name' => 'Vixen',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'fitimii@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Crypto', 'last_name' => 'Guru',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'fjollaaa@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Digital', 'last_name' => 'Daynamo',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'gokgaurav@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Geek', 'last_name' => 'Goddess',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'gzoni05@gmail.com'),
            array('user_type' => 'User', 'suffix' => 'Dr', 'first_name' => 'Techno', 'last_name' => 'Champ',  'gender' => 'M', 'status' => 1, 'is_approve' => 1, 'phone_no' => 1234567890, 'country_code' => 91, 'email_verified_at' => now(),  'email' => 'intelasif27@gmail.com'),
        );
        DB::table('users')->insert($users);

    }
}
