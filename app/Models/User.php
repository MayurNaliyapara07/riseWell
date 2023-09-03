<?php

namespace App\Models;

use App\Helpers\User\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Yajra\DataTables\DataTables;


class User extends BaseModel implements
    AuthenticatableContract,
    MustVerifyEmail
{
    use Authenticatable, HasApiTokens, HasFactory, Notifiable, \Illuminate\Auth\MustVerifyEmail;

    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = [
        'avatar',
        'country_code',
        'time_zone',
        'user_type',
        'suffix',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_no',
        'designation',
        'dob',
        'gender',
        'state_id',
        'city_name',
        'zip',
        'address',
        'age',
        'bio',
        'ssn',
        'insurance_proof',
        'password',
        'status',
        'is_approve'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $entity = 'user';
    public $filter;
    protected $_helper;

    const DR = 'Dr';
    const MR = 'Mr';
    const MS = 'Ms';
    const MIIS = 'Miss';

    const STATUS_ACTIVE = 1;
    const STATUS_INCTIVE = 0;
    const USER_PROVIDER = 'Provider';

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper;
    }

    public function getPlaceholderForFile($files_type = 'images')
    {
        $return = asset('assets/media/users/default.jpg');
        return $return;
    }

    public function getSuffix()
    {
        return [
            ['key' => self::DR, 'value' => self::DR, 'label' => self::DR],
            ['key' => self::MR, 'value' => self::MR, 'label' => self::MR],
            ['key' => self::MS, 'value' => self::MS, 'label' => self::MS],
            ['key' => self::MIIS, 'value' => self::MIIS, 'label' => self::MIIS],
        ];
    }


    public function getGender()
    {
        return $this->_helper->gender();
    }

    public function getTimeZone()
    {
        return $this->_helper->timeZone();
    }

    public function getHoursList()
    {
        return $this->makeOpeningHoursOptions();
    }

    public function getStateList()
    {
        $stateObject = new State();
        $stateTableName = $stateObject->getTable();
        $selectColumns = [$stateTableName . '.state_id', $stateTableName . '.state_name'];
        $state = $stateObject->setSelect()
            ->addFieldToFilter($stateTableName, 'country_id', '=', 231)
            ->addOrderby($stateTableName, 'state_name', 'asc')
            ->get($selectColumns);
        return $state;
    }

    public function getUserList()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.avatar', $this->country_code . '.country_code', $this->table . '.first_name',$this->table . '.middle_name', $this->table . '.last_name', $this->table . '.email', $this->table . '.phone_no', $this->table . '.user_type', $this->table . '.status', $this->table . '.id']);
        $this->addFieldToFilter($this->table, 'user_type', 'notin', ['Provider', 'Admin']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = ' <a href="' . route('user.edit', $row->id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>
                        <a href="javascript:;"  onclick="deleteRecord(\'user\',' . $row->id . ')" class="ml-3 btn btn-sm btn-danger btn-clean btn-icon" title="Delete"><i class="la la-trash"></i></a>';
            return $action;

        })->editColumn('user_name', function ($row) {
            $firstName = !empty($row->first_name) ? $row->first_name : '';
            $lastName = !empty($row->last_name) ? $row->last_name : '';
            $middleName = !empty($row->middle_name) ? $row->middle_name : '';
            return $this->_helper->mb_ucfirst($firstName . " " . $middleName." ".$lastName);
        })->editColumn('phone_no', function ($row) {

            return "+" . $row->country_code . $row->phone_no;

        })->editColumn('status', function ($row) {
            if ($row->status == $this::STATUS_ACTIVE) {
                return '<span class="switch switch-sm switch-icon"><label><input type="checkbox" checked="checked" onclick="userChangeStatus(\'user-change-status\',' . $row->id . ')" name="select"/><span></span></label></span>';
            } else {
                return '<span class="switch switch-sm switch-icon"><label><input onclick="userChangeStatus(\'user-change-status\',' . $row->id . ')"  type="checkbox"  /><span></span></label></span>';
            }

        })
            ->addIndexColumn()
            ->rawColumns(['user_name', 'user_type', 'email', 'phone_no', 'status', 'action'])
            ->filter(function ($query) {

                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            if ($value['user_name'] == 'user_name') {
                                $query->orWhere('first_name', "LIKE", '%' . trim($search_value) . '%');
                                $query->orWhere('last_name', "LIKE", '%' . trim($search_value) . '%');
                            }
                            $query->orWhere('email', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('phone_no', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('user_type', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function createUserRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['suffix'] = $request['suffix'];
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['middle_name'] = $request['middle_name'];
        $data['email'] = $request['email'];
        $data['phone_no'] = $request['phone_no'];
        $data['gender'] = $request['gender'];
        $data['country_code'] = $request['country_code'];
        $data['user_type'] = 'User';
        $data['address'] = trim($request['address']);
        $data['password'] = bcrypt($request['password']);
        if ($request->hasFile('image')) {
            $logo = $request->file('image');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['image'] = $fileName;
            }
        }
        $data['id'] = !empty($request['id']) ? $request['id'] : '';
        $response = $this->saveUserRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['id'] = $response['id'];
            $result['redirectUrl'] = '/user';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveUserRecord($data)
    {

        if (!empty($data['id'])) {
            $rules['suffix'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['email'] = 'required|unique:' . $this->table . ',email,' . $data['id'];
            $rules['phone_no'] = 'required|numeric';
            $rules['gender'] = 'required|in:M,F';
        } else {
            $rules['suffix'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['email'] = 'required|unique:' . $this->table . ',email';
            $rules['phone_no'] = 'required|numeric';
            $rules['gender'] = 'required|in:M,F';
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
        if (isset($data['id']) && $data['id'] != '') {
            $user = self::findOrFail($data['id']);
            $user->update($data);
            $user_id = $user->id;
            $this->afterSave($data, $user);
        } else {
            $user = self::create($data);
            $this->afterSave($data, $user);
            $user_id = $user->id;
        }

        $response['success'] = true;
        $response['message'] = !empty($data['id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['id'] = $user_id;
        return $response;

    }

    public function getProviderList()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.avatar', $this->table . '.first_name',$this->table . '.last_name', $this->table . '.email', $this->table . '.phone_no', $this->table . '.user_type', $this->table . '.status', $this->table . '.id', $this->table . '.is_approve']);
        $this->addFieldToFilter($this->table, 'user_type', 'in', ['Provider', 'Admin']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);

        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-primary btn-clean btn-icon" data-toggle="dropdown">
                                <i class="la la-cog"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <ul class="nav nav-hoverable flex-column">
                                        <li class="nav-item"><a class="nav-link" href="' . route('provider.edit', $row->id) . '"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>
                                </ul>
                            </div>
                        </div>';
            return $action;
        })->editColumn('user_name', function ($row) {
            $firstName = !empty($row->first_name) ? $row->first_name : '';
            $lastName = !empty($row->last_name) ? $row->last_name : '';

            $image = $this->getFileUrl($row->avatar);
            $userName = '<span style="width: 250px;">
            <div class="d-flex align-items-center">
            <a href="' . $image . '"  class="symbol symbol-40 symbol-sm flex-shrink-0">
                <img class="" src="' . $image . '" alt="photo">
            </a><br>
            <div class="ml-4">
            <div class="text-dark-75 font-weight-bold line-height-sm">' . $firstName .  "" . $lastName . '</div>
            <a href="' . route('provider.edit', $row->id) . '"class="font-size-sm text-dark-50">' . $row->email . '</a>
            </div></div></span>';
            return $userName;
        })->editColumn('user_type', function ($row) {
            if ($row->user_type == $this::USER_PROVIDER) {
                return '<span class="label label-lg label-success label-inline">Provider</span>';
            } else {
                return '<span class="label label-lg label-primary label-inline">Admin</span>';
            }
        })->editColumn('is_approve', function ($row) {
            if ($row->is_approve == $this::STATUS_ACTIVE) {
                return '<button class="btn btn-success" type="button" onclick="userChangeStatus(\'provider-approval-status-update\', ' . $row->id . ')"><i class=" far fa-check-circle" aria-hidden="true"></i></button>';
            } else {
                return '<button class="btn btn-danger" type="button" onclick="userChangeStatus(\'provider-approval-status-update\', ' . $row->id . ')"><i class=" far fa-times-circle" aria-hidden="true"></i></button>';

            }
        })->editColumn('status', function ($row) {
            if ($row->status == $this::STATUS_ACTIVE) {
                return '<span class="switch switch-sm switch-icon"><label><input type="checkbox" checked="checked" onclick="userChangeStatus(\'user-change-status\',' . $row->id . ')" name="select"/><span></span></label></span>';
            } else {
                return '<span class="switch switch-sm switch-icon"><label><input onclick="userChangeStatus(\'user-change-status\',' . $row->id . ')"  type="checkbox"  /><span></span></label></span>';
            }
        })->addIndexColumn()
            ->rawColumns(['user_name', 'user_type', 'status', 'is_approve', 'action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            if ($value['name'] == 'name') {
                                $query->orWhere('first_name', "LIKE", '%' . trim($search_value) . '%');
                                $query->orWhere('last_name', "LIKE", '%' . trim($search_value) . '%');
                            } else {
                                $query->orWhere('email', "LIKE", '%' . trim($search_value) . '%');
                                $query->orWhere('user_type', "LIKE", '%' . trim($search_value) . '%');
                            }


                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function createProviderRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['user_type'] = $request['user_type'];
        $data['suffix'] = $request['suffix'];
        $data['first_name'] = $request['first_name'];
        $data['last_name'] = $request['last_name'];
        $data['middle_name'] = $request['middle_name'];
        $data['email'] = $request['email'];
        $data['phone_no'] = $request['phone_no'];
        $data['country_code'] = $request['country_code'];
        $data['designation'] = $request['designation'];
        $data['dob'] = $this->dateFormat($request['dob']);
        $data['gender'] = $request['gender'];
        $data['zip'] = $request['zip'];
        $data['ssn'] = $request['ssn'];
        $data['city_name'] = $request['city_name'];
        $data['state_id'] = $request['state_id'];
        $data['bio'] = trim($request['bio']);
        $data['address'] = trim($request['address']);
        $data['id'] = !empty($request['id']) ? $request['id'] : '';
        if ($request->hasFile('avatar')) {
            $logo = $request->file('avatar');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['avatar'] = $fileName;
            }
        }
        if ($request->hasFile('insurance_proof')) {
            $logo = $request->file('insurance_proof');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['insurance_proof'] = $fileName;
            }
        }
        $response = $this->saveProviderRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['id'] = $response['id'];
            $result['redirectUrl'] = ('edit');
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveProviderRecord($data)
    {

        if (!empty($data['id'])) {
            $rules['suffix'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['email'] = 'required|unique:' . $this->table . ',email,' . $data['id'];
            $rules['phone_no'] = 'required|numeric';
            $rules['gender'] = 'required|in:M,F';
        } else {
            $rules['suffix'] = 'required';
            $rules['first_name'] = 'required';
            $rules['last_name'] = 'required';
            $rules['email'] = 'required|unique:' . $this->table . ',email';
            $rules['phone_no'] = 'required|numeric';
            $rules['gender'] = 'required|in:M,F';
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
        if (isset($data['id']) && $data['id'] != '') {
            $user = self::findOrFail($data['id']);
            if (!empty($user->avatar) || !empty($user->insurance_proof)) {
                $old_image = $user->avatar;
                $old_insurance_proof = $user->insurance_proof;
            }
            $user->update($data);
            $user_id = $user->id;
            $this->afterSave($data, $user);
        } else {
            $user = self::create($data);
            $this->afterSave($data, $user);
            $user_id = $user->id;
        }

        $response['success'] = true;
        $response['message'] = !empty($data['id']) ? 'Provider has been updated successfully' : 'Provider has been created successfully';
        $response['id'] = $user_id;
        return $response;
    }

    public function getEducationDetails($providerId)
    {
        $schoolObject = new School();
        return $schoolObject->with('getDegreeDetails')->where('user_id', $providerId)->get();
    }

    public function getStateOfLicList($providerId)
    {
        $stateOfLicObject = new StateOfLic();
        $stateOfLicTableName = $stateOfLicObject->getTable();
        $result = $stateOfLicObject->setSelect()
            ->addFieldToFilter($stateOfLicTableName, 'user_id', '=', $providerId)
            ->get();
        return $result;
    }

    public function getAssignProgramList($providerId)
    {
        $assignProgramObject = new AssginProgram();
        $assignProgramTableName = $assignProgramObject->getTable();
        return $assignProgramObject->setSelect()
            ->addFieldToFilter($assignProgramTableName, 'user_id', '=', $providerId)
            ->get();
    }

    public function getSelectedAssginProgramList($userId)
    {
        $eventObj = new Event;
        $eventTable = $eventObj->getTable();
        $assignProgramObject = new AssginProgram();
        $assignProgramTableName = $assignProgramObject->getTable();
        $selectedColumns = array($assignProgramTableName . '.*', $eventTable . '.event_name', $eventTable . '.duration', $eventTable . '.custom_duration', $eventTable . '.custom_duration_type');
        $assignProgramList = $assignProgramObject->setSelect()->getEvent()
            ->addFieldToFilter($assignProgramTableName, 'user_id', '=', $userId)
            ->get($selectedColumns);
        $html = "";
        foreach ($assignProgramList as $value) {
            $eventName = !empty($value->event_name) ? $value->event_name : "";
            if ($value->duration == 'Custom') {
                $duration = $value->custom_duration . " " . $value->custom_duration_type;
            } else {
                $duration = $value->duration . " min";
            }
            $assignProgramId = !empty($value->assign_program_id) ? $value->assign_program_id : 0;
            $status = $value->status == true ? 'checked' : '';
            $image = asset("assets/media/svg/misc/015-telegram.svg");
            $html .= '<label class="d-flex flex-stack mb-5 cursor-pointer">
            <span class="d-flex align-items-center me-2">
            <div class="symbol symbol-40 symbol-light mr-4">
            <span class="symbol-label bg-hover-white">
            <img src=' . $image . ' class="h-50 align-self-center">
            </span>
            </div>
            <span class="d-flex flex-column">
            <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">' . $eventName . '
            </span>
            <div>
            <span class="font-weight-bolder">
            Time :
            <span class="fs-7 text-muted">' . $duration . '</span>
            </span></div>
            </span></span>
            <label class="checkbox">
            <input type="checkbox"  ' . $status . '  onclick=assignProgramStatusUpdate(' . $assignProgramId . ') />
            <span class="ml-5"></span></label></label>';
        }
        return $html;
    }

    public function deleteProviderWorkingHours($request)
    {
        $providerId = $request['id'];
        $providerWorkingHoursObject = new ProviderWorkingHours();
        $providerWorkingHoursTableName = $providerWorkingHoursObject->getTable();
        $providerWorkingHours = $providerWorkingHoursObject->setSelect()->addFieldToFilter($providerWorkingHoursTableName, 'provider_working_hours_id', '=', $providerId)->get()->first();
        if ($providerWorkingHours) {
            $providerWorkingHours->delete();
            return response()->json(['status' => true, 'id' => $providerId], 200);
        } else {
            return response()->json(['status' => false, 'id' => $providerId], 200);
        }
    }

    public function updateSchool($request)
    {

        $schoolObject = new School();
        return $schoolObject->createSchoolRecord($request->all());
    }

    public function updateProviderWorkingHours($request)
    {
        $providerWorkingHourObject = new ProviderWorkingHours();
        return $providerWorkingHourObject->createWorkingHours($request->all());
    }

    public function updatStateOfLic($request)
    {
        $stateOfLicObject = new StateOfLic();
        return $stateOfLicObject->createStateOfLic($request->all());
    }

    public function saveAssignProgram($request)
    {
        $assignProgramObject = new AssginProgram();
        return $assignProgramObject->createRecord($request->all());
    }

}
