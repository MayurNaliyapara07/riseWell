<?php

namespace App\Observers;

use App\Events\TimeLine;

class TimeLineObserver
{
    /**
     * Handle the TimeLine "created" event.
     *
     * @param  \App\Models\TimeLine  $timeLine
     * @return void
     */
    public function created(TimeLine $timeLine)
    {
        TimeLine::dispatch($timeLine->patients_id,$timeLine->notes);
    }

    /**
     * Handle the TimeLine "updated" event.
     *
     * @param  \App\Models\TimeLine  $timeLine
     * @return void
     */
    public function updated(TimeLine $timeLine)
    {
        //
    }

    /**
     * Handle the TimeLine "deleted" event.
     *
     * @param  \App\Models\TimeLine  $timeLine
     * @return void
     */
    public function deleted(TimeLine $timeLine)
    {
        //
    }

    /**
     * Handle the TimeLine "restored" event.
     *
     * @param  \App\Models\TimeLine  $timeLine
     * @return void
     */
    public function restored(TimeLine $timeLine)
    {
        //
    }

    /**
     * Handle the TimeLine "force deleted" event.
     *
     * @param  \App\Models\TimeLine  $timeLine
     * @return void
     */
    public function forceDeleted(TimeLine $timeLine)
    {
        //
    }
}
