<?php

namespace App\Models;

use App\Helpers\User\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends BaseModel
{
    use HasFactory;
    protected $table="school";
    protected $primaryKey="school_id";
    protected $fillable=['school_name','user_id'];

    protected $entity = 'school';
    public $filter;

    protected $_helper;
    public $_education;

    public function getDegreeDetails(){
        return $this->hasMany(Education::class,'school_id','school_id');
    }

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper;
        $this->_education = new Education;
    }

    public function createSchoolRecord($request){

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['education'] = $request['education'];
        $data['id'] = !empty($request['id']) ? $request['id'] : '';
        $response = $this->saveSchoolRecord($data);
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

    public function saveSchoolRecord($data){

        if (!empty($data['education']) && !empty($data['id'])) {
            $rules['education.*.school'] = 'required';
            $rules['education.*.degreeDetails.*.degree'] = 'required';
            $rules['education.*.degreeDetails.*.year'] = 'required|numeric';
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

        if (!empty($data['education'])) {
            $user_id = $data['id'];
            self::removeRelationData('user_id', $user_id);
            $education = $data['education'];
            $schoolArray = [];
            foreach ($education as $edu) {
                $schoolArray['school_name'] = !empty($edu['school']) ? $edu['school'] : '';
                $schoolArray['user_id'] = $user_id;
                $schoolResponse = self::create($schoolArray);

                if (!empty($schoolResponse['school_id'])) {
                    $schoolId = $schoolResponse['school_id'];
                    $this->_education->removeRelationData('school_id', $schoolId);
                }
                if (isset($edu['degreeDetails']) && $edu['degreeDetails'] != '') {
                    $degreeDetails = $edu['degreeDetails'];
                    foreach ($degreeDetails as $value) {
                        $this->_education->saveDegreeDetails([
                            'degree' => !empty($value['degree']) ? $value['degree'] : '',
                            'year' => !empty($value['year']) ? $value['year'] : '',
                            'school_id' => !empty($schoolId) ? $schoolId : '',
                        ]);
                    }
                }
            }
        }

        $response['success'] = true;
        $response['message'] = 'School has been updated successfully';
        $response['id'] = $user_id;
        return $response;

    }
}
