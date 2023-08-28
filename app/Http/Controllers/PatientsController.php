<?php

namespace App\Http\Controllers;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Common\BaseController;
use App\Models\AssginProgram;
use App\Models\Chat;
use App\Models\Event;
use App\Models\Order;
use App\Models\Patients;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientsController extends BaseController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new Patients;
    }

    public function index()
    {
        return view('master.patients.index')->with('AJAX_PATH', 'get-patients');
    }

    public function getPatients()
    {
        return $this->_model->getPatientsList();
    }

    public function getSurveyForm($patientsId)
    {
        $surveyForm = $this->_model->getSurveyForm($patientsId);
        return view('master.patients.survey-form')->with(compact('surveyForm'));
    }

    public function getUniqueUrl(Request $request)
    {
        return $this->_model->getUniqueUrl($request);
    }

    public function create()
    {
        $memberId = $this->_model->getMemberId();
        return view('master.patients.create')->with(compact('memberId'));
    }

    public function store(Request $request)
    {
        return $this->_model->createRecord($request);
    }

    public function saveVisitNote(Request $request)
    {
        return $this->_model->createVisitNote($request);
    }

    public function saveMedication(Request $request)
    {
        return $this->_model->createMedication($request);
    }

    public function saveOrder(Request $request)
    {
        $data = $request->all();
        return app('App\Http\Controllers\StripePaymentController')->oneTimeCheckout($data);
    }

    public function saveLabReport(Request $request)
    {
        return $this->_model->createLabReport($request);
    }

    public function show($id)
    {
        $patientDetails = $this->_model->loadModel($id);
        $surveyFormType = !empty($patientDetails) ? $patientDetails->survey_form_type : '';
        $surveyForm = $this->_model->getSurveyForm($id, $surveyFormType);
        $getStatName = $this->_model->getStateName($patientDetails->state_id);
        $getBillingStatName = $this->_model->getStateName($patientDetails->billing_state_id);
        $getShippingStatName = $this->_model->getStateName($patientDetails->shipping_state_id);
        $medicalHistory = $this->_model->getMedicalHistory($id);
        $visitNote = $this->_model->getVisitNote($id);
        $getLabReport = $this->_model->getLabReport($id);
        $getTimeZone = $this->_model->getTimeZone();
        $getSchedule = $this->getSchduleList($id);
        $getOrderHistory = $this->getOrderHistory($id);

        return view('master.patients.profile')->with(compact('getOrderHistory','getLabReport', 'patientDetails', 'visitNote', 'medicalHistory', 'getTimeZone', 'getStatName', 'getBillingStatName', 'getShippingStatName', 'surveyForm','getSchedule'));

    }

    public function getSchduleList($patientsID)
    {
        $scheduleObj = new Schedule();
        $result = $scheduleObj::with(
            [
                'getProviderName' => function ($query) {
                    $query->select('id', 'first_name', 'middle_name', 'last_name', 'email');
                },
                'getAssignProgramName.getEvents'
            ]
        )->where('patients_id', $patientsID)->get();
        return $result;
    }

    public function getOrderHistory($patientsID){
       $orderHistoryObj = new Order();
       $table = $orderHistoryObj->getTable();
       return $orderHistoryObj->setSelect()->addFieldToFilter($table,'patients_id','=',$patientsID)->get();
    }

    public function edit($id)
    {
        $patients = $this->_model->loadModel($id);
        $getStatName = $this->_model->getStateName($patients->state_id);
        $getBillingStatName = $this->_model->getStateName($patients->billing_state_id);
        $getShippingStatName = $this->_model->getStateName($patients->shipping_state_id);
        return view('master.patients.create')->with(compact('patients', 'getStatName', 'getBillingStatName', 'getShippingStatName'));
    }

    public function update(Request $request, $id)
    {
        $request->merge(['patients_id' => $id]);
        return $this->_model->createRecord($request);
    }

    public function calender()
    {
        $events = $this->getAppointmentList();
        return view('master.calender.index')->with(compact('events'));
    }

    public function getAppointmentList()
    {
        $scheduleObj = new Schedule();
        $events = [];
        $data = $scheduleObj::with(['getProviderName', 'getAssignProgramName', 'getPatientsName'])->get();
        foreach ($data as $value) {
            $assignProgramId = !empty($value->getAssignProgramName) ? $value->getAssignProgramName->assign_program_id : '';
            $eventDetails = $this->assignProgramDetails($assignProgramId);
            $providerName = !empty($value->getProviderName) ? $value->getProviderName->first_name . ' ' . $value->getProviderName->last_name : '';
            $patientsName = !empty($value->getPatientsName) ? $value->getPatientsName->first_name . ' ' . $value->getPatientsName->last_name : '';
            $programName = !empty($eventDetails) ? $eventDetails->event_name : '';
            $color = !empty($eventDetails) ? $eventDetails->color : '';
            $scheduleId = !empty($value->schedule_id) ? $value->schedule_id : '';
            $events[] = [
                'id' => $scheduleId,
                'title' => $patientsName,
                'start' => $value->date,
                'end' => '',
                'description' => $programName . "\n" . $providerName,
                'color' => $color,
            ];
        }
        if (request()->ajax()) {
            return \response()->json($events);
        } else {
            return $events;
        }
    }

    public function appointmentDetails(Request $request)
    {
        $scheduleObj = new Schedule();
        $scheduleId = $request->schedule_id;
        if (request()->ajax()) {
            $appointMentDeatils = $scheduleObj->with(['getProviderName', 'getAssignProgramName', 'getPatientsName'])->find($scheduleId);
            $assignProgramId = !empty($appointMentDeatils->getAssignProgramName) ? $appointMentDeatils->getAssignProgramName->assign_program_id : '';
            $eventDetails = $this->assignProgramDetails($assignProgramId);
            $response = [
                'schedule_id' => !empty($appointMentDeatils) ? $appointMentDeatils->schedule_id : '',
                'providerName' => "Dr." . !empty($appointMentDeatils->getProviderName) ? $appointMentDeatils->getProviderName->first_name . ' ' . $appointMentDeatils->getProviderName->last_name : '',
                'patientsName' => !empty($appointMentDeatils->getPatientsName) ? $appointMentDeatils->getPatientsName->first_name . ' ' . $appointMentDeatils->getPatientsName->last_name : '',
                'date' => !empty($appointMentDeatils->date) ? $this->_model->displayDate($appointMentDeatils->date) . " " . $this->_model->timeFormat($appointMentDeatils->time_slot) : '-',
                'program_name' => !empty($eventDetails) ? $eventDetails->event_name : '',
                'description' => !empty($appointMentDeatils) ? $appointMentDeatils->description : '',
            ];
            return \response()->json($response, 200);
        }
    }

    public function assignProgramDetails($assignProgramId)
    {
        $assignProgramObj = new AssginProgram();
        $eventObj = new Event();
        $details = $assignProgramObj->loadModel($assignProgramId);
        $eventDetails = $eventObj->loadModel($details->event_id);
        return $eventDetails;
    }

    public function saveAppointment(Request $request)
    {
        $scheduleObj = new Schedule();
        return $scheduleObj->createRecord($request);
    }

    public function patientsStatusUpdate($id)
    {
        $patients = $this->_model->loadModel($id);
        if (!empty($patients->status) && $patients->status == 1) {
            $patients->update(['status' => '0']);
            return $this->webResponse('Patients been in-active successfully.');
        } else {
            $patients->update(['status' => '1']);
            return $this->webResponse('Patients has been active successfully.');
        }
    }

    public function getAvailableTimes(Request $request)
    {

        $assignProgramObj = new AssginProgram();
        $scheduleObj = new Schedule();
        $scheduleTable = $scheduleObj->getTable();
        $date = $this->_model->dateFormat($request->date);
        $dayName = Carbon::parse($date)->format('l');
        $providerId = $request->provider_id;
        $assignProgramId = $request->assign_program_id;
        $getTimeSlot = $assignProgramObj->getAssignProgramDetails($assignProgramId, $providerId, $dayName);

        $html = '';
        if (!empty($getTimeSlot)) {
            $newArray = array_merge(...$getTimeSlot);
            foreach ($newArray as $key => $value) {
                /* if check time slot booked or not */
                $scheduleDetails = $scheduleObj->setSelect()
                    ->addFieldToFilter($scheduleTable, 'user_id', '=', $providerId)
                    ->addFieldToFilter($scheduleTable, 'date', '=', $date)
                    ->addFieldToFilter($scheduleTable, 'time_slot', '=', $value)
                    ->get()
                    ->first();
                if (!empty($scheduleDetails->time_slot) && $scheduleDetails->time_slot == $value) {
                    unset($newArray[$key]);
                } else {
                    $html .= '<div class="col-md-3 col-sm-3 mt-1">
                          <label class="radio">
                          <input type="radio" name="time_slot" value="' . $value . '">
                          <span></span>&nbsp;' . $value . '
                          </label></div>';
                }
            }
        }
        return response()->json($html, 200);
    }

    public function chat($id = 0)
    {
        $getPatientsNameList = $this->_model->getPatientNameList();
        $getChatList = $this->_model->getChatLatestList();
        if ($id) {
            $getPatientDetails = $this->_model->getPatientNameList($id);
            $getChatList = $this->_model->getChatList($id);
            return view('chat-message')->with(compact('getPatientsNameList', 'getPatientDetails', 'getChatList'));
        } else {
            return view('chat')->with(compact('getPatientsNameList', 'getChatList'));
        }
    }

    public function sendMsg(Request $request)
    {

        $baseHelper = new BaseHelper();
        $patientsId = $request->post('patients_id');
        $message = $request->post('content');
        $phoneNo = $request->post('phone_no');
        $countryCode = $request->post('country_code');

        $data = [
            'content' => $message,
            'patients_id' => $patientsId,
            'user_id' => Auth::user()->id,
        ];
        $chatObject = new Chat();
        $result = $chatObject->create($data);

        event(new \App\Events\TimeLine($result->patients_id, $result->content, 'Chat'));
        $baseHelper->twilio($phoneNo, $countryCode, $message);

        return response()->json($result);
    }

    public function getTimeLine(Request $request)
    {
        $patientsId = $request->patients_id;
        $getTimeLine = $this->_model->getTimeLine($patientsId);
        return response()->json([$getTimeLine]);
    }

    public function getChatHistory(Request $request)
    {
        $patientsId = $request->patients_id;
        $getChatHistory = $this->_model->getChatHistory($patientsId);
        return response()->json([$getChatHistory]);
    }

}
