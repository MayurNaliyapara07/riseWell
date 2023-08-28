<?php

namespace App\Models;

use App\Helpers\ProviderWorkingHours\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderWorkingHours extends BaseModel
{
    use HasFactory;

    protected $table = "provider_working_hours";
    protected $primaryKey = "provider_working_hours_id";
    protected $fillable = ['user_id', 'day', 'start_time', 'end_time'];
    protected $entity = 'working_hours';
    public $filter;
    protected $_helper;
    protected $_user_wise_working_hours;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper;
        $this->_user_wise_working_hours = new UserWiseWorkingHours;
    }

    public function createWorkingHours($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
//        $data['time_zone'] = $request['time_zone'];
        $data['checked_week_days'] = $request['checked_week_days'];
        $data['startTimes'] = $request['startTimes'];
        $data['endTimes'] = $request['endTimes'];
        $data['id'] = !empty($request['id']) ? $request['id'] : '';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
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

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        /* start working times save */
        $checked_week_days = $data['checked_week_days'];
        $startTimes = $data['startTimes'];
        $endTimes = $data['endTimes'];
        $user_id = $data['id'];
        $tempArray = [];

        self::removeRelationData('user_id', $user_id);
        $this->_user_wise_working_hours->removeRelationData('user_id',$user_id);
        foreach ($checked_week_days as $key => $value) {
            foreach ($startTimes[$value] as $key => $st) {
                array_push($tempArray, [
                    'user_id' => $user_id,
                    'day' => $value,
                    'start_time' => $st,
                    'end_time' => !empty($endTimes[$value][$key]) ? $endTimes[$value][$key] : '',
                    'created_at'=>now(),
                ]);
            }
        }
        self::insert($tempArray);
        $this->_user_wise_working_hours->insert($tempArray);
        $response['success'] = true;
        $response['message'] = 'Working Hours has been updated successfully';
        return $response;
    }


}
