<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event')->delete();
        $event = array(
            array('event_name'=>'Event 1','location_type'=>'In-Metting','location'=>'Test Location','color'=>'red','duration'=>'15'),
            array('event_name'=>'Event 2','location_type'=>'In-Metting','location'=>'Test Location','color'=>'violet','duration'=>'30'),
            array('event_name'=>'Event 3','location_type'=>'In-Metting','location'=>'Test Location','color'=>'blue','duration'=>'45'),
            array('event_name'=>'Event 4','location_type'=>'In-Metting','location'=>'Test Location','color'=>'green','duration'=>'60'),
            array('event_name'=>'Event 5','location_type'=>'In-Metting','location'=>'Test Location','color'=>'black','duration'=>'15'),
        );
        DB::table('event')->insert($event);
    }
}
