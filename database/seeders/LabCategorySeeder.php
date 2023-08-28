<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->delete();
        $event = array(
            array('category_name'=>'Category 1'),
            array('category_name'=>'Category 2'),
            array('category_name'=>'Category 3'),
            array('category_name'=>'Category 4'),
            array('category_name'=>'Category 5'),
        );
        DB::table('category')->insert($event);
    }
}
