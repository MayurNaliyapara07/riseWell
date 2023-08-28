<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GeneralSettingSeeder::class,
            ProviderSeeder::class,
            UserSeeder::class,
            PatientsSeeder::class,
            MessageSeeder::class,
            CategorySeeder::class,
            LabCategorySeeder::class,
            ProductSeeder::class,
            EventSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,

        ]);
    }
}
