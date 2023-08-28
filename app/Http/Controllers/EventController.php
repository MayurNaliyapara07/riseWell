<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAvailableTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    protected $_model;
    public function __construct()
    {
        $this->_model = new Event();
    }

    public function index()
    {
        return view('master.event.index')->with('AJAX_PATH', 'get-event');
    }

    public function getEvent(){

        return $this->_model->getEventList();
    }

    public function create()
    {
        $locationType = $this->_model->getLocationType();
        $duration = $this->_model->getDuration();
        $day = $this->_model->getWeekOfDay();
        $workingHours = $this->_model->getWorkingHours();
        return view('master.event.create')->with(compact('locationType','duration','day','workingHours'));
    }

    public function store(Request $request)
    {
        return $this->_model->createRecord($request);

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $event= $this->_model->loadModel($id);
        $locationType = $this->_model->getLocationType();
        $duration = $this->_model->getDuration();
        $workingHours = $this->_model->getWorkingHours();
        return view('master.event.create')->with(compact('event','locationType','duration','workingHours'));
    }

    public function update(Request $request, $id)
    {
        $request->merge(['event_id' => $id]);
        return $this->_model->createRecord($request);
    }

    public function destroy($id)
    {
        return $this->_model->removed($id);
    }

    public function deleteWorkingHours(Request $request){
        return $this->_model->deleteWorkingHours($request->all());
    }

}
