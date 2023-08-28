<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalSetting = new \App\Models\GeneralSetting();
        $generalSetting->site_title = "RiseWell";
        $generalSetting->save();
    }
}
