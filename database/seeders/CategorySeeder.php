<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frontend_category')->delete();
        $category = array(
            array('category_name' => 'Vitamins'),
            array('category_name' => 'Longevity'),
            array('category_name' => 'Erectile Dysfunction Treatments'),
            array('category_name' => 'Testosterone Replacement Therapy'),
        );
        DB::table('frontend_category')->insert($category);
    }
}
