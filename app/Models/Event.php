<?php

namespace App\Models;

use App\Helpers\Event\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;

class Event extends BaseModel
{
    use HasFactory;

    protected $table = "event";
    protected $primaryKey = "event_id";
    protected $fillable = [
        'event_name',
        'location_type',
        'location',
        'phone_no',
        'description',
        'event_link',
        'zoom_join_url',
        'color',
        'day_type',
        'duration',
        'days',
        'custom_duration',
        'custom_duration_type',
    ];

    protected $entity = 'event';
    public $filter;
    protected $_helper;
    protected $_event_available_times;

    const MEETING_TYPE_SCHEDULE = 2;
    const LOCATION_TYPE_IN_METTING = 'In-Metting';
    const LOCATION_TYPE_BY_CALL = 'Call';
    const LOCATION_TYPE_ZOOM_METTING = 'Zoom';
    const DURATiON_15 = '15';
    const DURATION_30 = '30';
    const DURATION_45 = '45';
    const DURATION_60 = '60';
    const DURATION_CUSTOM = 'Custom';

    public $client;
    public $jwt;
    public $headers;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
        $this->_event_available_times = new EventAvailableTimes;
        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accessToken(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

    }

    public function getLocationType()
    {
        return [
            ['key' => self::LOCATION_TYPE_IN_METTING, 'value' => self::LOCATION_TYPE_IN_METTING, 'label' => 'In-person Metting'],
            ['key' => self::LOCATION_TYPE_BY_CALL, 'value' => self::LOCATION_TYPE_BY_CALL, 'label' => 'Phone Call'],
            ['key' => self::LOCATION_TYPE_ZOOM_METTING, 'value' => self::LOCATION_TYPE_ZOOM_METTING, 'label' => 'Zoom'],

        ];
    }

    public function getDuration()
    {
        return [
            ['key' => self::DURATiON_15, 'value' => self::DURATiON_15, 'label' => '15 Min'],
            ['key' => self::DURATION_30, 'value' => self::DURATION_30, 'label' => '30 Min'],
            ['key' => self::DURATION_45, 'value' => self::DURATION_45, 'label' => '45 Min'],
            ['key' => self::DURATION_60, 'value' => self::DURATION_60, 'label' => '60 Min'],
            ['key' => self::DURATION_CUSTOM, 'value' => self::DURATION_CUSTOM, 'label' => 'Custom'],

        ];
    }

    public function getWorkingHours()
    {
        return $this->makeOpeningHoursOptions();
    }

    public function getWeekOfDay()
    {
        return $this->_helper->weekOfDay();
    }

    public function accessToken()
    {
        return env('ZOOM_ACCESS_TOKEN');
        $zoomAppToken = \session('zoom_app_token');
        if (!$zoomAppToken || Carbon::now() > $zoomAppToken->expires_at) {
            $zoomAccessToken = $this->newAccessToken();
        } else {
            $zoomAccessToken = $zoomAppToken->access_token;
        }
        return $zoomAccessToken;
    }

    public function newAccessToken()
    {
        \session()->remove('zoom_app_token');
        $url = config('services.zoom.access_token_url') . "?grant_type=client_credentials&account_id=" . config('services.zoom.account_id');
        $response = Http::withBasicAuth(config('services.zoom.client_id'), config('services.zoom.client_secret'))->post($url);
        $res = $response->object();
        $res->expires_at = Carbon::now()->addMinute(58);
        \session()->put('zoom_app_token', $res);
        \session()->save();
        return $res->access_token;
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createMetting($data)
    {
        $url = config('services.zoom.api_url');
        $path = 'users/me/meetings';
        $body = [
            'headers' => $this->headers,
            'body' => json_encode([
                'topic' => $data['topic'],
                'type' => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration' => $data['duration'],
                'agenda' => (!empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone' => 'Asia/Kolkata',
                'settings' => [
                    'host_video' => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room' => true,
                ],
            ]),
        ];
        $response = $this->client->post($url . "" . $path, $body);
        $data = json_decode($response->getBody(), true);
        $url = !empty($data['join_url']) ? $data['join_url'] : '';
        return $url;
    }

    public function getEventList()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.event_name', $this->table . '.location_type', $this->table . '.event_id']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<a href="' . route('event.edit', $row->event_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>
             <a href="javascript:;"  onclick="deleteRecord(\'event\',' . $row->event_id . ')" class="ml-3 btn btn-sm btn-danger btn-clean btn-icon" title="Delete"><i class="la la-trash"></i></a>';
            return $action;
        })->editColumn('location_type', function ($row) {
            if ($row->location_type == self::LOCATION_TYPE_BY_CALL) {
                return '<span class="label label-lg label-primary label-inline">' . self::LOCATION_TYPE_BY_CALL . '</span>';
            } else if ($row->location_type == self::LOCATION_TYPE_IN_METTING) {
                return '<span class="label label-lg label-warning label-inline">' . self::LOCATION_TYPE_IN_METTING . '</span>';
            } else {
                return '<span class="label label-lg label-info label-inline">' . self::LOCATION_TYPE_ZOOM_METTING . '</span>';

            }
        })->addIndexColumn()
            ->rawColumns(['event_name', 'location_type', 'action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->orWhere('event_name', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));

    }

    public function createRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $locationType = $request['location_type'];
        if ($locationType == 'In-Metting') {
            $data['location'] = $request['location'];
            $data['phone_no'] = "";
        } else if ($locationType == 'Call') {
            $data['phone_no'] = $request['phone_no'];
            $data['location'] = "";
        } else if ($locationType == 'Zoom') {
            $data['phone_no'] = "";
            $data['location'] = $request['location'];
        }
        if (empty($request['event_id'])) {
            $eventLink = $this->_helper->randomString(16);
            $data['event_link'] = $eventLink;
        }

        $data['checked_week_days'] = $request['checked_week_days'];
        $data['startTimes'] = $request['startTimes'];
        $data['endTimes'] = $request['endTimes'];
        $data['event_name'] = $request['event_name'];
        $data['location_type'] = $locationType;
        $data['description'] = $request['description'];
        $data['color'] = $request['color'];
        $data['day'] = $request['day'];
        $data['day_type'] = $request['day_type'];
        $data['duration'] = $request['duration'];
        $data['custom_duration'] = $request['custom_duration'];
        $data['custom_duration_type'] = $request['custom_duration_type'];
        $data['event_id'] = $request['event_id'];
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['event_id'] = $response['event_id'];
            $result['redirectUrl'] = '/event';
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

        if (!empty($data['event_id'])) {
            $rules['event_name'] = 'required';
            $rules['location_type'] = 'required';
        } else {
            $rules['event_name'] = 'required';
            $rules['location_type'] = 'required';
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
        if (isset($data['event_id']) && $data['event_id'] != '') {
            $event = self::findOrFail($data['event_id']);
            $event->update($data);
            $event_id = $event->event_id;
            $this->afterSave($data, $event);
        } else {
            $event = self::create($data);
            $this->afterSave($data, $event);
            $event_id = $event->event_id;
        }

        /* start working times save */
        $checked_week_days = $data['checked_week_days'];
        $tempArray = [];
        $this->_event_available_times->removeRelationData('event_id', $event_id);
        foreach ($checked_week_days as $key => $value) {
            foreach ($data['startTimes'][$value] as $key => $st) {
                array_push($tempArray, [
                    'event_id' => $event_id,
                    'day' => $value,
                    'start_time' => $st,
                    'end_time' => $data['endTimes'][$value][$key],
                ]);
            }
        }
        $this->_event_available_times->insert($tempArray);
        /* end working times save */
        $response['success'] = true;
        $response['message'] = !empty($data['event_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['event_id'] = $event_id;
        return $response;
    }

    public function deleteWorkingHours($request)
    {
        $eventWorkingHoursId = $request['id'];
        $eventWorkingHours = $this->_event_available_times->loadModel($eventWorkingHoursId);
        if (!empty($eventWorkingHours)) {
            $eventWorkingHours->delete();
            return response()->json(['status' => true, 'id' => $eventWorkingHoursId], 200);
        } else {
            return response()->json(['status' => false, 'id' => $eventWorkingHoursId], 200);
        }

    }

    public function joinEventAvailable()
    {
        $eventAvailable = new EventAvailableTimes();
        $eventAvailableTable = $eventAvailable->getTable();
        $this->queryBuilder->leftJoin($eventAvailableTable, function ($join) use ($eventAvailableTable) {
            $join->on($this->table . '.event_id', '=', $eventAvailableTable . '.event_id');
        });
        return $this;
    }

    public function getDayWiseEventAvailable($eventId, $day)
    {
        $eventAvailable = new EventAvailableTimes();
        $eventAvailableTable = $eventAvailable->getTable();
        $selectedColumn = array($this->table . '.event_id',$this->table . '.location_type', $this->table . '.event_name', $this->table . '.duration', $this->table . '.custom_duration', $this->table . '.custom_duration_type', $eventAvailableTable . '.*');
        $result = $this->setSelect()
                ->joinEventAvailable()
                ->addFieldToFilter($this->table, 'event_id', '=', $eventId)
                ->addFieldToFilter($eventAvailableTable, 'day', '=', $day)
                ->addLimit(1)
                ->get($selectedColumn);
        return $result;
    }

}
