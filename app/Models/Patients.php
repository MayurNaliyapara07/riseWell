<?php

namespace App\Models;

use App\Helpers\Patients\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Patients extends BaseModel
{
    use HasFactory;

    protected $table = "patients";
    protected $primaryKey = "patients_id";
    protected $fillable = ['trt_refill', 'survey_form_type', 'product_id', 'first_name', 'last_name', 'gender', 'dob', 'profile_claimed', 'image', 'member_id', 'email', 'ssn', 'phone_no', 'country_code', 'status', 'city_name', 'zip', 'address', 'state_id', 'billing_address_1', 'billing_address_2', 'billing_address_3', 'billing_state_id', 'billing_city_name', 'billing_zip', 'shipping_address_1', 'shipping_address_2', 'shipping_address_3', 'shipping_state_id', 'shipping_city_name', 'shipping_zip', 'height', 'weight', 'time_zone'];

    protected $entity = 'patients';
    public $filter;
    protected $_helper;
    protected $_medication_history;

    const EST = 'est';
    const TST = 'tst';
    const CST = 'cst';
    const STATUS_ACTIVE = 1;
    const STATUS_INCTIVE = 0;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
        $this->_medication_history = new MedicationHistory;
    }

    public function getPlaceholderForFile($files_type = 'images')
    {
        $return = asset('assets/media/users/default.jpg');
        return $return;
    }

    public function getTimeZone()
    {
        return [
            ['key' => self::EST, 'value' => self::EST, 'label' => 'EST/EDT'],
            ['key' => self::TST, 'value' => self::TST, 'label' => 'TST/TDT'],
            ['key' => self::CST, 'value' => self::CST, 'label' => 'CST/CDT'],
        ];
    }

    public function getMemberId()
    {
        $lastPatients = $this->setSelect()->addOrderby($this->table, 'patients_id', 'DESC')->get()->first();
        $lastPatientsNo = @$lastPatients->patients_id;
        $prefix = '';
        $number = str_replace($prefix, '', $lastPatientsNo ?? 0) + 1;
        $lengthOfNumber = strlen($number);
        $numberOfZeros = 2 - $lengthOfNumber;
        $totalLength = $numberOfZeros + $lengthOfNumber;
        $memberId = str_pad($number, $totalLength, '0', STR_PAD_LEFT);
        return $prefix . '' . $memberId;
    }

    public function getPatientsList()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.first_name', $this->table . '.last_name', $this->table . '.image', $this->table . '.email', $this->table . '.phone_no', $this->table . '.country_code', $this->table . '.dob', $this->table . '.member_id', $this->table . '.ssn', $this->table . '.profile_claimed', $this->table . '.status', $this->table . '.patients_id', $this->table . '.state_id']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<a class="addAppointment ml-3 btn btn-sm btn-info btn-clean btn-icon" data-toggle="modal"  data-id="' . $row->patients_id . '"  data-state-id="' . $row->state_id . '"   ><i class="la la-calendar"></i></a>';
            return $action;
        })->editColumn('patients_name', function ($row) {
            $image = $this->getFileUrl($row->image);
            $patientsName = '<span style="width: 250px;">
            <div class="d-flex align-items-center">
            <a href="' . $image . '"  class="symbol symbol-40 symbol-sm flex-shrink-0">
                <img class="" src="' . $image . '" alt="photo">
            </a><br>
            <div class="ml-4">
            <a href="' . route('patients.show', $row->patients_id) . '" class="text-dark-75 font-weight-bold line-height-sm text-hover-primary">' . $row->first_name . "" . $row->last_name . '</a><br>
            <a href="#" class="font-size-sm text-dark-50">' . $row->email . '</a>
            </div></div></span>';
            return $patientsName;

        })->editColumn('dob', function ($row) {
            return !empty($row->dob) ? $this->displayDate($row->dob) : "";
        })->editColumn('phone_no', function ($row) {
            return "+" . $row->country_code . $row->phone_no;
        })->editColumn('profile_claimed', function ($row) {
            return !empty($row->profile_claimed) ? $this->displayDate($row->profile_claimed) : "";
        })->editColumn('status', function ($row) {
            if ($row->status == $this::STATUS_ACTIVE) {
                return '<span class="switch switch-sm switch-icon"><label><input type="checkbox" checked="checked" onclick="patientsChangeStatus(\'patients-status-update\',' . $row->patients_id . ')" name="select"/><span></span></label></span>';
            } else {
                return '<span class="switch switch-sm switch-icon"><label><input onclick="patientsChangeStatus(\'patients-status-update\',' . $row->patients_id . ')"  type="checkbox"  /><span></span></label></span>';
            }
        })->addIndexColumn()
            ->rawColumns(['patients_name', 'dob', 'member_id', 'ssn', 'profile_claimed', 'status', 'action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->orWhere('email', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('user_type', "LIKE", '%' . trim($search_value) . '%');

                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));

    }

    public function joinEdFlow()
    {
        $edFlowObj = new EDFlow();
        $edFlowTable = $edFlowObj->getTable();
        $this->queryBuilder->join($edFlowTable, function ($join) use ($edFlowTable) {
            $join->on($this->table . '.patients_id', '=', $edFlowTable . '.patients_id');
        });
        return $this;
    }

    public function joinTrtFlow()
    {
        $trtFlowObj = new TrtFlow();
        $trtFlowTable = $trtFlowObj->getTable();
        $this->queryBuilder->leftjoin($trtFlowTable, function ($join) use ($trtFlowTable) {
            $join->on($this->table . '.patients_id', '=', $trtFlowTable . '.patients_id');
        });
        return $this;
    }

    public function getSurveyForm($patientsId, $surveyFormType)
    {

        $joinTable = "";
        $edFlowObj = new EDFlow();
        $edFlowTable = $edFlowObj->getTable();

        $trtFlowObj = new TrtFlow();
        $trtFlowTable = $trtFlowObj->getTable();

        if ($surveyFormType == "ed") {
            $joinTable = $edFlowTable . '.*';
        } elseif ($surveyFormType == 'trt') {
            $joinTable = $trtFlowTable . '.*';
        }

        $selectedColumns = array(
            $this->table . '.product_id',
            $this->table . '.survey_form_type',
            $this->table . '.member_id',
            $this->table . '.patients_id',
            $this->table . '.first_name',
            $this->table . '.last_name',
            $this->table . '.image',
            $this->table . '.height',
            $this->table . '.weight',
            $this->table . '.email',
            $this->table . '.phone_no',
            $this->table . '.country_code',
            $this->table . '.dob',
            $this->table . '.state_id',
            $this->table . '.status',
            $joinTable,
        );

        if ($surveyFormType == 'ed') {
            $result = $this->setSelect()
                ->joinEdFlow()
                ->addFieldToFilter($this->table, 'patients_id', '=', $patientsId)
                ->addFieldToFilter($this->table, 'survey_form_type', '=', $surveyFormType)
                ->get($selectedColumns);
        } elseif ($surveyFormType == 'trt') {
            $result = $this->setSelect()
                ->joinTrtFlow()
                ->addFieldToFilter($this->table, 'patients_id', '=', $patientsId)
                ->addFieldToFilter($this->table, 'survey_form_type', '=', $surveyFormType)
                ->get($selectedColumns);
        }

        return !empty($result) ? $result : [];


    }

    public function getUniqueUrl($request)
    {

        $flowId = $request['flow_id'];
        $surveyFormType = $request['survey_form_type'];

        if ($surveyFormType == 'ed') {
            $edFlowObj = new EDFlow();
            $getPatientsDetails = $edFlowObj->loadByPatientsId($flowId);
            $uniqueUrl = !empty($getPatientsDetails) ? $getPatientsDetails->unique_url : '';
            if (!empty($uniqueUrl)) {
                $result = ['success' => true, 'message' => '', 'data' => url('survey-form/ed/' . $uniqueUrl)];
            } else {
                $generateUniqueUrl = $edFlowObj->checkUniqueUrlExit($flowId);
                $result = ['success' => true, 'message' => '', 'data' => url('survey-form/ed/' . $generateUniqueUrl)];
            }
        } elseif ($surveyFormType == 'trt') {
            $trtFlowObj = new TrtFlow();
            $getPatientsDetails = $trtFlowObj->loadByPatientsId($flowId);
            $uniqueUrl = !empty($getPatientsDetails) ? $getPatientsDetails->unique_url : '';
            if (!empty($uniqueUrl)) {
                $result = ['success' => true, 'message' => '', 'data' => url('survey-form/trt/' . $uniqueUrl)];
            } else {
                $generateUniqueUrl = $trtFlowObj->checkUniqueUrlExit($flowId);
                $result = ['success' => true, 'message' => '', 'data' => url('survey-form/trt/' . $generateUniqueUrl)];
            }
        }

        return $result;

    }

    public function createRecord($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['gender'] = $request['gender'];
        $data['dob'] = $this->dateFormat($request['dob']);
        $data['profile_claimed'] = $this->dateFormat($request['profile_claimed']);
        $data['email'] = $request['email'];
        $data['phone_no'] = $request['phone_no'];
        $data['country_code'] = $request['country_code'];
        $data['member_id'] = $request['member_id'];
        $data['ssn'] = $request['ssn'];
        $data['city_name'] = $request['city_name'];
        $data['state_id'] = $request['state_id'];
        $data['zip'] = $request['zip'];
        $data['address'] = $request['address'];
        $data['billing_address_1'] = $request['billing_address_1'];
        $data['billing_address_2'] = $request['billing_address_2'];
        $data['billing_address_3'] = $request['billing_address_3'];
        $data['billing_state_id'] = $request['billing_state_id'];
        $data['billing_city_name'] = $request['billing_city_name'];
        $data['billing_zip'] = $request['billing_zip'];
        $data['shipping_address_1'] = $request['shipping_address_1'];
        $data['shipping_address_2'] = $request['shipping_address_2'];
        $data['shipping_address_3'] = $request['shipping_address_3'];
        $data['shipping_state_id'] = $request['shipping_state_id'];
        $data['shipping_city_name'] = $request['shipping_city_name'];
        $data['shipping_zip'] = $request['shipping_zip'];
        $data['height'] = $request['height'];
        $data['weight'] = $request['weight'];
        $data['time_zone'] = $request['time_zone'];
        $data['patients_id'] = !empty($request['patients_id']) ? $request['patients_id'] : '';

        if ($request->hasFile('image')) {
            $logo = $request->file('image');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['image'] = $fileName;
            }
            if (isset($request->logo_hidden) && !empty($request->logo_hidden)) {
                $filePath = $this->getFilesDirectory();
                $this->removeFileFromStorage($filePath . '/' . $request->logo_hidden);
            }
        }

        $response = $this->saveRecord($data);

        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['patients_id'] = $response['patients_id'];
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

        if (!empty($data['patients_id'])) {
            $rules['patients_id'] = 'required';
        } else {
            $rules['member_id'] = 'required';
            $rules['dob'] = 'required';
            $rules['profile_claimed'] = 'required';
            $rules['email'] = 'required|email';
            $rules['phone_no'] = 'required|numeric';
            $rules['city_name'] = 'required';
            $rules['state_id'] = 'required|numeric';
            $rules['zip'] = 'required|numeric';
            $rules['address'] = 'required';
        }

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }
        $this->beforeSave($data);
        if (isset($data['patients_id']) && $data['patients_id'] != '') {
            $patients = self::findOrFail($data['patients_id']);
            $patients->update($data);
            $patients_id = $patients->patients_id;
            $this->afterSave($data, $patients);
        } else {
            $patients = self::create($data);
            $this->afterSave($data, $patients);
            $patients_id = $patients->patients_id;
        }

        $response['success'] = true;
        $response['message'] = !empty($data['patients_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['patients_id'] = $patients_id;
        return $response;

    }

    public function createVisitNote($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['patients_id'] = $request['patients_id'];
        if ($request['icd_code']) {
            $json = json_decode($request['icd_code']);
            $data['icd_code'] = collect($json)->pluck('value')->toArray();
        }
        $data['visit_note'] = $request['visit_note'];
        $response = $this->saveVisitNoteRecord($data);

        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['patients_visit_note_id'] = $response['patients_visit_note_id'];
            $result['redirectUrl'] = ('show');
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }

        return $result;
    }

    public function saveVisitNoteRecord($data)
    {

        $rules['patients_id'] = 'required';
        $rules['visit_note'] = 'required';
        $rules['icd_code'] = 'required';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $patientVisitNoteObj = new PatientsVisitNote();
        $patientVisitNoteObj->patients_id = $data['patients_id'];
        $patientVisitNoteObj->visit_note = $data['visit_note'];
        $patientVisitNoteObj->created_by = Auth::user()->id;
        $patientVisitNoteObj->icd_code = $data['icd_code'] ? implode(',', $data['icd_code']) : '';
        $patientVisitNoteObj->save();
        $patients_visit_note_id = $patientVisitNoteObj->patients_visit_note_id;

        /* visit note add in timeline */
        $note = nl2br("ICD10 Code: " . $patientVisitNoteObj->icd_code . "\nVisit note: " . $patientVisitNoteObj->visit_note);
        event(new \App\Events\TimeLine($patientVisitNoteObj->patients_id, $note, 'Visit Note'));

        $response['success'] = true;
        $response['message'] = 'Visit Note has been created successfully.';
        $response['patients_visit_note_id'] = $patients_visit_note_id;
        return $response;
    }

    public function createMedication($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['patients_id'] = $request['patients_id'];
        $data['medication_details'] = $request['medication_details'];
        $response = $this->saveMedicationRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['medication_history_id'] = $response['medication_history_id'];
            $result['redirectUrl'] = ('show');
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;

    }

    public function saveMedicationRecord($data)
    {

        $rules['patients_id'] = 'required';
        $rules['medication_details.*.medication_name'] = 'required';
        $rules['medication_details.*.qty'] = 'required|numeric';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (!empty($data['medication_details'])) {
            $medicationHistory = $data['medication_details'];
            $result = $this->_medication_history->saveMedicationHistory($medicationHistory, $data['patients_id']);
        }

        $response['success'] = true;
        $response['message'] = 'Medication has been created successfully.';
        $response['medication_history_id'] = $result['medication_history_id'];
        return $response;

    }

    public function createLabReport($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['patients_id'] = $request['patients_id'];
        $data['lab_detail'] = $request['lab_detail'];
        $response = $this->saveLabReportRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['patients_lab_report_id'] = $response['patients_lab_report_id'];
            $result['redirectUrl'] = ('show');
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }

        return $result;
    }

    public function saveLabReportRecord($data)
    {

        $rules['patients_id'] = 'required';
        $rules['lab_details.*.category'] = 'required';
        $rules['lab_details.*.value'] = 'required';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (!empty($data['lab_detail'])) {
            $labDetails = $data['lab_detail'];
            $labReportObj = new PatientsLabReport();
            $result = $labReportObj->saveLabReportHistory($labDetails, $data['patients_id']);
        }

        $response['success'] = true;
        $response['message'] = 'Patients Lab Report has been created successfully.';
        $response['patients_lab_report_id'] = $result['patients_lab_report_id'];
        return $response;
    }

    public function getMedicalHistory($patientId)
    {

        $medicalHistoryTable = $this->_medication_history->getTable();
        return $this->_medication_history->setSelect()->addFieldToFilter($medicalHistoryTable, 'patients_id', '=', $patientId)->get();
    }

    public function getVisitNote($patientsId)
    {
        $patientsVisitNoteObj = new PatientsVisitNote();
        $patientsVisitNoteTable = $patientsVisitNoteObj->getTable();
        $visitNote = $patientsVisitNoteObj->setSelect()->addFieldToFilter($patientsVisitNoteTable, 'patients_id', '=', $patientsId)->get();
        return $visitNote;
    }

    public function joinChat()
    {
        $chatObj = new Chat();
        $chatTable = $chatObj->getTable();
        $this->queryBuilder->leftJoin($chatTable, function ($join) use ($chatTable) {
            $join->on($this->table . '.patients_id', '=', $chatTable . '.patients_id');
        });
        return $this;
    }

    public function getPatientNameList($id = 0)
    {
        if ($id) {
            $selectedColumns = array($this->table . '.patients_id', $this->table . '.first_name', $this->table . '.last_name', $this->table . '.image', $this->table . '.email', $this->table . '.phone_no', $this->table . '.country_code');
            $results = $this->setSelect()
                ->addFieldToFilter($this->table, 'patients_id', '=', $id)
                ->get($selectedColumns)
                ->first();
        } else {

            $selectedColumns = array($this->table . '.patients_id', $this->table . '.first_name', $this->table . '.last_name', $this->table . '.image', $this->table . '.email');
            $results = $this->setSelect()
                ->addOrderby($this->table, 'patients_id', 'ASC')
                ->get($selectedColumns);
        }
        return $results;
    }

    public function getChatList($id)
    {
        $chatObj = new Chat();
        $chatTable = $chatObj->getTable();
        $selectedColumns = array($this->table . '.patients_id', $this->table . '.first_name', $this->table . '.last_name', $this->table . '.image', $this->table . '.email', $chatTable . '.content', $chatTable . '.chat_id', $chatTable . '.created_at');
        $results = $this->setSelect()->joinChat()
            ->addFieldToFilter($chatTable, 'patients_id', '=', $id)
            ->addOrderby($chatTable, 'created_at', 'ASC')
            ->get($selectedColumns);
        return $results;
    }

    public function getChatLatestList()
    {
        $chatObj = new Chat();
        $chatTable = $chatObj->getTable();
        $selectedColumns = array($this->table . '.patients_id', $this->table . '.first_name', $this->table . '.last_name', $this->table . '.image', $this->table . '.email', $chatTable . '.content', $chatTable . '.chat_id', $chatTable . '.created_at');
        $results = $this->setSelect()->joinChat()
            ->addOrderby($chatTable, 'created_at', 'DESC')
            ->get($selectedColumns);
        return $results;
    }

    public function getTimeLine($patient_id)
    {

        $tempArray = [];
        $timeLineObj = new TimeLine();
        $timeLineTable = $timeLineObj->getTable();
        $result = $timeLineObj->setSelect()
            ->addFieldToFilter($timeLineTable, 'patients_id', '=', $patient_id)
            ->addOrderby($timeLineTable, 'created_at', 'ASC')
            ->get();
        foreach ($result as $value) {
            array_push($tempArray, [
                'type' => $value->type,
                'notes' => $value->notes,
                'created_at' => $this->displayTimeStamp($value->created_at),
            ]);
        }
        return $tempArray;

    }

    public function getChatHistory($patient_id)
    {

        $tempArray = [];
        $chatObj = new Chat();
        $chatTable = $chatObj->getTable();
        $result = $chatObj->setSelect()
            ->addFieldToFilter($chatTable, 'patients_id', '=', $patient_id)
            ->addOrderby($chatTable, 'created_at', 'ASC')
            ->get();
        foreach ($result as $value) {
            array_push($tempArray, [
                'chat_id' => $value->chat_id,
                'user_id' => $value->user_id,
                'patients_id' => $value->patients_id,
                'content' => $value->content,
                'created_at' => $this->chatTimeStamp($value->created_at),
            ]);
        }
        return $tempArray;
    }

    public function getStateName($stateId)
    {
        $stateObj = new State();
        $stateTable = $stateObj->getTable();
        $stateName = $stateObj->setSelect()
            ->addFieldToFilter($stateTable, 'state_id', '=', $stateId)
            ->get()
            ->first();
        return $stateName;

    }

    public function getLabReport($patientsId)
    {
        $patientsLabReportObj = new PatientsLabReport();
        $result = $patientsLabReportObj->getLabReportHistroy($patientsId);
        return $result;
    }


}


