<?php

namespace App\Http\Controllers;

use App\Models\AssginProgram;
use App\Models\Day;
use App\Models\MedicationHistory;
use App\Models\Patients;
use App\Models\Schedule;
use App\Models\State;
use App\Models\UserWiseWorkingHours;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $_model;
    public function __construct()
    {
        $this->_model = new Schedule;
    }
    public function index()
    {
        return view('master.appointment.index')->with('AJAX_PATH', 'get-appointment');
    }

    public function getAppointment(){
        return $this->_model->getAppointmentList();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
