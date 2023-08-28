<?php

namespace Database\Seeders;

use App\Models\Patients;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patients::factory()->count(10)->create();
    }
}
