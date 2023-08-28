<?php

namespace App\Models;

use App\Helpers\StateOfLic\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StateOfLic extends BaseModel
{
    use HasFactory;
    protected $table = "state_of_lic";
    protected $primaryKey = "state_of_lic_id";
    protected $fillable = ['user_id', 'state_id', 'lic_no'];

    protected $entity = 'state_of_lic';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function createStateOfLic($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['stateOfLic'] = $request['stateOfLic'];
        $data['id'] = !empty($request['id']) ? $request['id'] : '';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = ('edit');
        }
        else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveRecord($data){

        if (!empty($data['stateOfLic']) && !empty($data['id'])) {
            $rules['stateOfLic.*.state_id'] = 'required';
            $rules['stateOfLic.*.lic_no'] = 'required';
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

        $user_id = $data['id'];
        self::removeRelationData('user_id', $user_id);
        $stateOfLicDetails = $data['stateOfLic'];
        foreach ($stateOfLicDetails as $value) {
            $stateId = !empty($value['state_id']) ? $value['state_id'] : '';
            $licNo = !empty($value['lic_no']) ? $value['lic_no'] : '';
            $stateOfLic = self::create([
                    'user_id' => $user_id,
                    'state_id' => $stateId,
                    'lic_no' => $licNo,
            ]);
        }


        $response['success'] = true;
        $response['message'] = 'State Of Lic has been updated successfully';
        $response['id'] = $user_id;
        return $response;
    }
}
