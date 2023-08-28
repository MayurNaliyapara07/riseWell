<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TimeLine
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $patients_id;
    public $notes;
    public $type;
    public function __construct($patients_id=0,$notes=null,$type=null)
    {
        $this->patients_id = $patients_id;
        $this->notes = $notes;
        $this->type = $type;
        $timeLine = new \App\Models\TimeLine();
        $timeLine->patients_id=$this->patients_id;
        $timeLine->notes=$this->notes;
        $timeLine->type=$this->type;
        $timeLine->created_id=Auth::user()->id;
        $timeLine->save();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
