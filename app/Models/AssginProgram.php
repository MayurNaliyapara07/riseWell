<?php

namespace App\Models;

use App\Helpers\AssignProgram\Helper;
use App\Helpers\ZoomApi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function saveRecord($data)
    {

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
            $eventName = $eventDetails[0]->event_name;
            $duration = $eventDetails[0]->duration;
            $custom_duration = $eventDetails[0]->custom_duration;
            $custom_duration_type = $eventDetails[0]->custom_duration_type;
            if ($duration == "Custom") {
                $gap = $custom_duration;
            } else {
                $gap = $duration;
            }
            $createMettings = $this->createZoomMettings($eventName, $duration);
            $providerTimeSlot = $providerWorkingHoursObject->getAvailableTimesSlot($providerId, $day);
            $slot = [];
            foreach ($providerTimeSlot as $value) {
                $startTime = $value->start_time;
                $endTime = $value->end_time;
                $result = $this->_helper->convertSlot($startTime, $endTime, $gap);

                array_push($slot, $result);
            }
            $response['slot'] = $slot;
            $response['is_zoom_mettings'] = !empty($eventDetails[0]) ? $eventDetails[0]['location_type'] == 'Zoom' : '';
            $response['zoom_join_url'] = !empty($createMettings['data'])?$createMettings['data']['join_url']:'';
            return $response;
        }
    }

    function accessToken()
    {
        session()->remove('zoom_app_token');
        $zoom_app_token = \session('zoom_app_token');
        if (!$zoom_app_token || Carbon::now() > $zoom_app_token->expires_in) {
            $zoom_access_token = $this->newAccessToken();
        } else {
            $zoom_access_token = $zoom_app_token->access_token;
        }
        return $zoom_access_token;
    }

    function newAccessToken()
    {
        $gs = $this->_helper->gs();
        $zoom_account_id = $gs->zoom_account_id;
        $zoom_client_secret_key = $gs->zoom_client_secret_key;
        $zoom_client_id = $gs->zoom_client_url;
        $base64Credentials = base64_encode("$zoom_client_id:$zoom_client_secret_key");
        $url = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $zoom_account_id;
        $response = Http::withHeaders([
            'Authorization' => "Basic $base64Credentials",
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($url);
        $res = $response->object();
        $res->expires_in = Carbon::now()->addMinutes(58);
        \session()->put('zoom_app_token', $res);
         return $res->access_token;
    }

    public function createZoomMettings($eventName, $time)
    {
        $zoom_access_token = $this->accessToken();
        $url = 'https://api.zoom.us/v2/users/me/meetings';
        $response = Http::withToken($zoom_access_token)->post($url, [
            'topic' => $eventName,
            'type' => 2,
            'start_time' => now(),
            'duration' => $time,
            'agenda' => 'Meeting for Patient',
            'timezone' => 'Asia/Kolkata',
        ]);
        if ($response->successful()) {
            return [
                'success' => $response->getStatusCode() === 201,
                'data'    => json_decode($response->getBody(), true),
            ];
        }
        else {
            return [
                'success' => $response->getStatusCode() === 201,
                'data'    => json_decode($response->getBody(), true),
            ];
            return response()->json(['error' => 'Failed to create a Zoom meeting'], 500);
        }
    }


}
