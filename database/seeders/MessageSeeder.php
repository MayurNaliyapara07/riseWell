<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++)
        {
            $user = $users->random();

            $message = new Message();
            $message->body = $faker->sentence;
            $message->sent_by = $user->id;
            $message->save();
        }
    }
}
