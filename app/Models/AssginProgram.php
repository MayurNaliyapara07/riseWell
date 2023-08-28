<?php

namespace App\Models;

use App\Helpers\AssignProgram\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssginProgram extends BaseModel
{
    use HasFactory;

    protected $table = "assign_program";
    protected $primaryKey = "assign_program_id";
    protected $fillable = ['event_id', 'status', 'user_id'];
    protected $entity = 'assign_program';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getEvents()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function createRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['event_id'] = $request['event_id'];
        $data['user_id'] = $request['id'];
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['assign_program_id'] = $response['assign_program_id'];
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

    public function saveRecord($data){

        $rules['event_id'] = 'required';
        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }
        $this->beforeSave($data);
        $assignProgram = self::create($data);
        $this->afterSave($data, $assignProgram);
        $assign_program_id = $assignProgram->assign_program_id;
        $response['success'] = true;
        $response['message'] = 'Assign Program has been created successfully';
        $response['assign_program_id'] = $assign_program_id;
        return $response;
    }

    public function getEvent()
    {
        $eventObj = new Event;
        $eventTable = $eventObj->getTable();
        $this->queryBuilder->leftJoin($eventTable, function ($join) use ($eventTable) {
            $join->on($this->table . '.event_id', '=', $eventTable . '.event_id');
        });
        return $this;
    }

    public function getAssignProgramDetails($assignProgramId, $providerId, $dayName)
    {

        $day = $this->_helper->dayFormat($dayName);
        $assignProgramDetails = self::findOneWithId($assignProgramId);
        $event_id = !empty($assignProgramDetails) ? $assignProgramDetails->event_id : '';
        $eventObject = new Event();
        $providerWorkingHoursObject = new UserWiseWorkingHours();
        $eventDetails = $eventObject->getDayWiseEventAvailable($event_id, $day);
        $timeSlot = "";
        if (count($eventDetails) > 0) {
            $duration = $eventDetails[0]->duration;
            $custom_duration = $eventDetails[0]->custom_duration;
            $custom_duration_type = $eventDetails[0]->custom_duration_type;
            if ($duration == "Custom") {
                $gap = $custom_duration;
            } else {
                $gap = $duration;
            }
            $providerTimeSlot = $providerWorkingHoursObject->getAvailableTimesSlot($providerId, $day);
            $slot = [];
            foreach ($providerTimeSlot as $value) {
                $startTime = $value->start_time;
                $endTime = $value->end_time;
                $result = $this->_helper->convertSlot($startTime, $endTime, $gap);

                array_push($slot,$result);
            }

            return $slot;

        }
    }
}
