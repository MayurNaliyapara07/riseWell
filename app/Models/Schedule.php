<?php

namespace App\Models;

use App\Events\TimeLineCreate;
use App\Jobs\AppointmentSend;
use App\Jobs\AppointmentSendJobs;
use App\Jobs\SendEmailJob;
use App\Mail\appointmentsEmailSend;
use Twilio\Rest\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class Schedule extends BaseModel
{
    use HasFactory;

    protected $table = "schedule";
    protected $primaryKey = "schedule_id";
    protected $fillable = [
        'patients_id',
        'assign_program_id',
        'user_id',
        'color',
        'date',
        'description',
        'time_slot',
    ];

    protected $entity = 'schedule';
    public $filter;
    protected $_helper;
    protected $_user_wise_working_hours;
    protected $_patients;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new \App\Helpers\Schedule\Helper;
        $this->_user_wise_working_hours = new UserWiseWorkingHours;
    }

    public function getAppointmentList()
    {

        $patientObj = new Patients();
        $providerObj = new User();
        $assignProgramObj = new AssginProgram();
        $eventObj = new Event();
        $eventTable = $eventObj->getTable();
        $patientTable = $patientObj->getTable();
        $assignProgramTable = $assignProgramObj->getTable();
        $providerTable = $providerObj->getTable();


        $this->setSelect();
        $this->selectColomns([
            $this->table . '.date',
            $this->table . '.time_slot',
            $this->table . '.created_at',
            $patientTable . '.patients_id',
            $patientTable . '.first_name',
            $patientTable . '.last_name',
            $eventTable . '.event_name',
            $providerTable . '.first_name',
            $providerTable . '.last_name',
        ]);

        $this->queryBuilder->join($patientTable, function ($join) use ($patientTable) {
            $join->on($this->table . '.patients_id', '=', $patientTable . '.patients_id');
        });

        $this->queryBuilder->join($assignProgramTable, function ($join) use ($assignProgramTable) {
            $join->on($this->table . '.assign_program_id', '=', $assignProgramTable . '.assign_program_id');
        });

        $this->queryBuilder->join($eventTable, function ($join) use ($eventTable, $assignProgramTable) {
            $join->on($assignProgramTable . '.event_id', '=', $eventTable . '.event_id');
        });

        $this->queryBuilder->join($providerTable, function ($join) use ($providerTable) {
            $join->on($this->table . '.user_id', '=', $providerTable . '.id');
        });

        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query->addColumn('action', function ($row) {
            $action = '<a href="' . route('get-visit-lab', $row->patients_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Visit Lab"><i class="la la-eye"></i> </a>';
            return $action;
        })->editColumn('patients_name', function ($row) {
            $firstName = !empty($row->first_name) ? $row->first_name : '';
            $lastName = !empty($row->last_name) ? $row->last_name : '';
            return $firstName . " " . $lastName;
        })->editColumn('provider_name', function ($row) {
            $firstName = !empty($row->first_name) ? $row->first_name : '';
            $lastName = !empty($row->last_name) ? $row->last_name : '';
            return $firstName . " " . $lastName;
        })->editColumn('date', function ($row) {
            $timeSlot = !empty($row->time_slot) ? $row->time_slot : '';
            return $this->displayDate($row->date) . " " . $this->timeFormat($timeSlot);
        })->editColumn('program_name', function ($row) {
            return !empty($row->event_name) ? $row->event_name : '';
        })->rawColumns(['date', 'patients_name', 'provider_name', 'program_name','action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];

                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->orWhere('program_name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('first_name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('last_name', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function getPatientsName()
    {
        return $this->belongsTo(Patients::class, 'patients_id', 'patients_id');
    }

    public function getProviderName()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAssignProgramName()
    {
        return $this->belongsTo(AssginProgram::class, 'assign_program_id', 'assign_program_id');
    }

    public function createRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['assign_program_id'] = $request['assign_program_id'];
        $data['description'] = $request['description'];
        $data['patients_id'] = $request['patients_id'];
        $data['time_slot'] = $request['time_slot'];
        $data['user_id'] = $request['user_id'];
        $data['date'] = $this->dateFormat($request['date']);
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['schedule_id'] = $response['schedule_id'];
            $result['redirectUrl'] = '/patients';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveRecord($data)
    {
        $rules['date'] = 'required|date_format:Y-m-d';
        $rules['assign_program_id'] = 'required';
        $rules['user_id'] = 'required';
        $rules['time_slot'] = 'required';
        $message['date.required'] = 'Please select available times';
        $message['assign_program_id.required'] = 'Please select program';
        $message['user_id.required'] = 'Please select provider';
        $message['time_slot.required'] = 'Please select time slot';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $this->beforeSave($data);
        $saveRec = self::create($data);
        $this->afterSave($data, $saveRec);
        $scheduleId = $saveRec->schedule_id;
        $patientsId = $saveRec->patients_id;

        /* appointment send email and sms */
        $patientObj = new Patients();
        $patientDetails = $patientObj->setSelect()->loadModel($patientsId);
        $patientName = !empty($patientDetails) ? $patientDetails->first_name . " " . $patientDetails->last_name : "";
        $phoneNo = !empty($patientDetails->phone_no) ? $patientDetails->country_code.$patientDetails->phone_no : "";
        $countryCode = !empty($patientDetails->country_code) ? $patientDetails->country_code : "";
        $timeSlot = !empty($saveRec) ? $saveRec->date . " " . $saveRec->time_slot : "";
        $appointmentTemplate = $this->_helper->getAppointmentTemplate($patientName, $timeSlot);
        $smsTemplate = $this->_helper->getSMSMessage($patientName, $timeSlot);

        $details = [
            'template' => $appointmentTemplate,
            'email' => !empty($patientDetails->email) ? $patientDetails->email : "",
            'time_slot' => $timeSlot,
            'patients_name' => $patientName,
            'patients_id'=> !empty($patientDetails->patients_id)?$patientDetails->patients_id:""
        ];
        $this->sendAppointmentTimeLine($details);
        dispatch(new AppointmentSendJobs($details));
        $this->_helper->twilio($phoneNo,$countryCode,$smsTemplate);

        $response['success'] = true;
        $response['redirectUrl'] = url('/patients');
        $response['message'] = !empty($data['schedule_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['schedule_id'] = $scheduleId;
        return $response;

    }

    public function sendAppointmentTimeLine($details)
    {
        $patientsId = $details['patients_id'];
        $timeslot = $details['time_slot'];
        $notes = "Hi,Your Appointment is booked on $timeslot ";
        event(new \App\Events\TimeLine($patientsId, $notes, 'Schedule'));
    }


}
