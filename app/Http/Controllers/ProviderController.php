<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BaseController;
use App\Models\AssginProgram;
use App\Models\Day;
use App\Models\Education;
use App\Models\ProviderWorkingHours;
use App\Models\Schedule;
use App\Models\School;
use App\Models\State;
use App\Models\StateOfLic;
use App\Models\User;
use App\Models\UserWiseWorkingHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class ProviderController extends BaseController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new User;
    }

    public function index()
    {
        return view('master.provider.index')->with('AJAX_PATH', 'get-provider');
    }

    public function getProvider()
    {
        return $this->_model->getProviderList();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $provider = $this->_model->loadModel($id);
        $getTimeZone = $this->_model->getTimeZone();
        $getSuffix = $this->_model->getSuffix();
        $getState = $this->_model->getStateList();
        $educationDetails = $this->_model->getEducationDetails($id);
        $workingHours = $this->_model->getHoursList();
        $stateOfLic =  $this->_model->getStateOfLicList($id);
        $assignProgram = $this->_model->getAssignProgramList($id);
        return view('master.provider.edit')->with(compact('getSuffix', 'getState', 'provider', 'stateOfLic', 'educationDetails', 'assignProgram', 'workingHours','getTimeZone'));
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->_model->createProviderRecord($request);
    }

    public function schoolUpdate(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->_model->updateSchool($request);
    }

    public function workingHoursUpdate(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->_model->updateProviderWorkingHours($request);
    }

    public function stateOfLicUpdate(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->_model->updatStateOfLic($request);
    }

    public function saveAssignProgram(Request $request)
    {
        return $this->_model->saveAssignProgram($request);
    }

    public function destroy($id)
    {
        //
    }

    public function getAssignProgram($userId)
    {
        $result = $this->_model->getSelectedAssginProgramList($userId);
        return response()->json($result, 200);

    }

    public function deleteWorkingHours(Request $request)
    {
        return $this->_model->deleteProviderWorkingHours($request->all());
    }

    public function assignProgramChangeStatus(Request $request)
    {
        $assignProgramObject = new AssginProgram();
        $assignProgramTableName = $assignProgramObject->getTable();
        $assignProgramId = !empty($request->assign_program_id) ? $request->assign_program_id : '';
        $assignProgramDetails = $assignProgramObject->setSelect()->addFieldToFilter($assignProgramTableName, 'assign_program_id', '=', $assignProgramId)->get()->first();
        if (!empty($assignProgramDetails->status) && $assignProgramDetails->status == 1) {
            $assignProgramDetails->update(['status' => 0]);
            return $this->webResponse('Assign program in-active successfully.');
        } else {
            $assignProgramDetails->update(['status' => 1]);
            return $this->webResponse('Assign program active successfully.');
        }
    }

}
