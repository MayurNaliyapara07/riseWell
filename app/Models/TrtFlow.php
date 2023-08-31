<?php

namespace App\Models;

use App\Helpers\TRTFlow\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Converter\Time\PhpTimeConverter;

class TrtFlow extends BaseModel
{
    use HasFactory;

    protected $table = "trt_flow";

    protected $primaryKey = "trt_flow_id";

    protected $guarded;

    protected $entity = 'ed_flow';

    public $filter;

    protected $_helper;

    const STATUS_ACTIVE = 1;

    const STATUS_INCTIVE = 0;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function joinPatients()
    {
        $patientsObj = new Patients();
        $patientsTable = $patientsObj->getTable();
        $this->queryBuilder->join($patientsTable, function ($join) use ($patientsTable) {
            $join->on($this->table . '.patients_id', '=', $patientsTable . '.patients_id');
        });
        return $this;
    }

    public function loadByPatientsId($trt_flow_id)
    {
        $selectedColumns = [$this->table . '.patients_id AS patients_id', $this->table . '.trt_flow_id AS trt_flow_id', $this->table . '.unique_url AS unique_url'];
        $return = $this->setSelect()
            ->addFieldToFilter($this->table, 'trt_flow_id', '=', $trt_flow_id)
            ->get($selectedColumns)
            ->first();
        return $return;
    }

    public function checkUniqueUrlExit($trt_flow_id)
    {
        $randomString = $this->_helper->randomString(16);
        $selectedColumns = [$this->table . '.patients_id AS patients_id', $this->table . '.trt_flow_id AS trt_flow_id', $this->table . '.unique_url AS unique_url'];
        $trtFlowResult = $this->setSelect()->where('trt_flow_id', '=', $trt_flow_id)->get($selectedColumns)->first();
        if (empty($edFlowResult->unique_url)) {
            DB::table($this->table)->where('trt_flow_id', $trtFlowResult->trt_flow_id)->update(['unique_url' => $randomString]);
            return $randomString;
        }
    }

    public function getUniqueByUrl($uniqueUrl)
    {
        $result = $this->setSelect()
            ->joinPatients()
            ->addFieldToFilter($this->table, 'unique_url', '=', $uniqueUrl)
            ->get()
            ->first();
        return $result;
    }

    public function getStateList()
    {
        $stateObj = new State();
        $stateList = $stateObj->getStateList();
        return $stateList;
    }

    public function getMemberId()
    {
        $patientsObj = new Patients();
        $memberId = $patientsObj->getMemberId();
        return $memberId;
    }

    public function ValidateTRTStep1($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' =>  'required|unique:users,email,' . $data['patients_id'],
            'phone_no' => 'required|numeric',
            'dob' => 'required',
            'billing_address_1' => 'required',
            'billing_city_name' => 'required',
            'billing_state_id' => 'required|numeric',
            'billing_zipcode' => 'required',
            'apt' => 'required',
        ];
        $message['first_name.required'] = 'First Name is required';
        $message['last_name.required'] = 'Last Name is required';
        $message['email.required'] = 'Email Address is required';
        $message['phone_no.required'] = 'PhoneNo is required';
        $message['dob.required'] = 'DOB is required';
        $message['billing_address_1.required'] = 'Billing Address is required';
        $message['billing_city_name.required'] = 'Billing City is required';
        $message['billing_state_id.required'] = 'Billing State is required';
        $message['billing_zipcode.required'] = 'Billing Zip code is required';
        $message['apt.required'] = 'APT/Suite code is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {

            session()->put('trt_flow.step1', $data);
            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/trt-step2';
        }

        return $response;
    }

    public function ValidateTRTStep2($data)
    {
        $rules = [
            'energy' => 'required',
            'sleep' => 'required',
            'libido' => 'required',
            'memory' => 'required',
            'strength' => 'required',
        ];
        $message['energy.required'] = 'Energy is required';
        $message['sleep.required'] = 'Sleep is required';
        $message['libido.required'] = 'Libido is required';
        $message['memory.required'] = 'Memory & Focus is required';
        $message['strength.required'] = 'Endurance & Strength is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        }
        else {
            session()->put('trt_flow.step2', $data);
            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/trt-step3';
        }
        return $response;
    }

    public function ValidateTRTStep3($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'future_children' => 'required',
            'living_children' => 'required',
            'cream_and_gel' => 'required',
            'allergies' => 'required',
            'herbal_or_vitamin' => 'required',
            'medications_prescribed' => 'required',
        ];
        $message['future_children.required'] = 'Future children is required';
        $message['living_children.required'] = 'Children under the age of 5 years living in the home is required';
        $message['cream_and_gel.required'] = 'Testosterone is required';
        $message['allergies.required'] = 'Allergies is required';
        $message['herbal_or_vitamin.required'] = 'Prescription is required';
        $message['medications_prescribed.required'] = 'Medications is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        }
        else {
            session()->put('trt_flow.step3', $data);
            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/trt-step4';

        }
        return $response;
    }

    public function ValidateTRTStep4($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [

        ];

        $validationResult = $this->validateDataWithRules($rules, $data);

        if ($validationResult['success'] == false) {

            $response['success'] = false;

            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }

            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {

            session()->put('trt_flow.step4', $data);

            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/trt-step5';

        }

        return $response;
    }

    public function ValidateTRTStep5($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [

        ];

        $validationResult = $this->validateDataWithRules($rules, $data);

        if ($validationResult['success'] == false) {

            $response['success'] = false;

            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }

            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {

            session()->put('trt_flow.step5', $data);

            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/trt-step6';

        }

        return $response;
    }

    public function createTRTRecord($request)
    {
        $step1 = session()->get('trt_flow.step1');
        $step2 = session()->get('trt_flow.step2');
        $step3 = session()->get('trt_flow.step3');
        $step4 = session()->get('trt_flow.step4');
        $step5 = session()->get('trt_flow.step5');

        $patientData = [];
        $trtFormData = [];
        $result = ['success' => false, 'message' => ''];

        $patientData['first_name'] = !empty($request['first_name']) ? $request['first_name'] : '';
        $patientData['last_name'] = !empty($request['last_name']) ? $request['last_name'] : '';
        $patientData['email'] = !empty($request['email']) ? $request['email'] : '';
        $patientData['phone_no'] = !empty($request['phone_no']) ? $request['phone_no'] : '';
        $patientData['dob'] = !empty($request['dob']) ? $request['dob'] : '';
        $patientData['state_id'] = !empty($request['billing_state_id']) ? $request['billing_state_id'] : 0;
        $patientData['trt_refill'] = !empty($request['trt_refill']) ? $request['trt_refill'] : '';
        $patientData['patients_id'] = !empty($request['patients_id']) ? $request['patients_id'] : '';
        $patientData['apt'] = !empty($request['apt']) ? $request['apt'] : '';
        $patientData['product_id'] = !empty($request['product_id']) ? $request['product_id'] : '';
        $patientData['member_id'] = !empty($request['member_id']) ? $request['member_id'] : '';
        $patientData['survey_form_type'] = 'trt';
        $patientData['status'] = self::STATUS_ACTIVE;

        $billing_address_1 = !empty($request['billing_address_1']) ? $request['billing_address_1'] : '';
        $billing_address_2 = !empty($request['billing_address_2']) ? $request['billing_address_2'] : '';
        $billing_state_id = !empty($request['billing_state_id']) ? $request['billing_state_id'] : 0;
        $billing_city_name = !empty($request['billing_city_name']) ? $request['billing_city_name'] : '';
        $billing_zipcode = !empty($request['billing_zipcode']) ? $request['billing_zipcode'] : '';
        $shipping_address_1 = !empty($request['shipping_address_1']) ? $request['shipping_address_1'] : '';
        $shipping_address_2 = !empty($request['shipping_address_2']) ? $request['shipping_address_2'] : '';
        $shipping_state_id = !empty($request['shipping_state_id']) ? $request['shipping_state_id'] : 0;
        $shipping_city_name = !empty($request['shipping_city_name']) ? $request['shipping_city_name'] : '';
        $shipping_zipcode = !empty($request['shipping_zipcode']) ? $request['shipping_zipcode'] : '';

        $sameAsShipping = !empty($request['billing_same_as_shipping']) && $request['billing_same_as_shipping'] == 'on' ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;


        if (!empty($sameAsShipping)) {
            $patientData['billing_address_1'] = $billing_address_1;
            $patientData['billing_address_2'] = $billing_address_2;
            $patientData['billing_state_id'] = $billing_state_id;
            $patientData['billing_city_name'] = $billing_city_name;
            $patientData['billing_zip'] = $billing_zipcode;
            $patientData['shipping_address_1'] = $billing_address_1;
            $patientData['shipping_address_2'] = $billing_address_2;
            $patientData['shipping_state_id'] = $billing_state_id;
            $patientData['shipping_city_name'] = $billing_city_name;
            $patientData['shipping_zip'] = $billing_zipcode;
        } else {
            $patientData['billing_address_1'] = $billing_address_1;
            $patientData['billing_address_2'] = $billing_address_2;
            $patientData['billing_state_id'] = $billing_state_id;
            $patientData['billing_city_name'] = $billing_city_name;
            $patientData['billing_zip'] = $billing_zipcode;
            $patientData['shipping_address_1'] = $shipping_address_1;
            $patientData['shipping_address_2'] = $shipping_address_2;
            $patientData['shipping_state_id'] = $shipping_state_id;
            $patientData['shipping_zip'] = $shipping_city_name;
            $patientData['shipping_city_name'] = $shipping_zipcode;
        }

        $trtFormData['additional_information'] = !empty($request['additional_information']) ? $request['additional_information'] : '';
        $trtFormData['experience'] = !empty($request['experience']) ? $request['experience'] : 0;
        $trtFormData['energy'] = !empty($step2['energy']) ? $step2['energy'] : '';
        $trtFormData['sleep'] = !empty($step2['sleep']) ? $step2['sleep'] : '';
        $trtFormData['libido'] = !empty($step2['libido']) ? $step2['libido'] : '';
        $trtFormData['memory'] = !empty($step2['memory']) ? $step2['memory'] : '';
        $trtFormData['strength'] = !empty($step2['strength']) ? $step2['strength'] : '';
        $trtFormData['future_children'] = !empty($step3['future_children']) && $step3['future_children'] == 'Yes' ? 1 : 0;
        $trtFormData['living_children'] = !empty($step3['living_children']) && $step3['living_children'] == 'Yes' ? 1 : 0;
        $trtFormData['cream_and_gel'] = !empty($step3['cream_and_gel']) && $step3['cream_and_gel'] == 'Yes' ? 1 : 0;
        $trtFormData['allergies'] = !empty($step3['allergies']) && $step3['allergies'] == 'Yes' ? 1 : 0;
        $trtFormData['herbal_or_vitamin'] = !empty($step3['herbal_or_vitamin']) && $step3['herbal_or_vitamin'] == 'Yes' ? 1 : 0;
        $trtFormData['medications_prescribed'] = !empty($step3['medications_prescribed']) && $step3['medications_prescribed'] == 'Yes' ? 1 : 0;
        $trtFormData['cold_chills'] = !empty($step4['cold_chills']) ? $step4['cold_chills'] : '';
        $trtFormData['cold_hand_and_feet'] = !empty($step4['cold_hand_and_feet']) ? $step4['cold_hand_and_feet'] : '';
        $trtFormData['decreased_sweating'] = !empty($step4['decreased_sweating']) ? $step4['decreased_sweating'] : '';
        $trtFormData['thinning_skin'] = !empty($step4['thinning_skin']) ? $step4['thinning_skin'] : '';
        $trtFormData['excessive_body_hair'] = !empty($step4['excessive_body_hair']) ? $step4['excessive_body_hair'] : '';
        $trtFormData['nail_brittle'] = !empty($step4['nail_brittle']) ? $step4['nail_brittle'] : '';
        $trtFormData['dry_brittle'] = !empty($step4['dry_brittle']) ? $step4['dry_brittle'] : '';
        $trtFormData['hair_loss'] = !empty($step4['hair_loss']) ? $step4['hair_loss'] : '';
        $trtFormData['dry_skin'] = !empty($step4['dry_skin']) ? $step4['dry_skin'] : '';
        $trtFormData['thinning_public_hair'] = !empty($step4['thinning_public_hair']) ? $step4['thinning_public_hair'] : '';
        $trtFormData['low_libido'] = !empty($step4['low_libido']) ? $step4['low_libido'] : '';
        $trtFormData['memory_lapsed'] = !empty($step4['memory_lapsed']) ? $step4['memory_lapsed'] : '';
        $trtFormData['difficulty_concentrating'] = !empty($step4['difficulty_concentrating']) ? $step4['difficulty_concentrating'] : '';
        $trtFormData['deperssion'] = !empty($step4['deperssion']) ? $step4['deperssion'] : '';
        $trtFormData['stress'] = !empty($step4['stress']) ? $step4['stress'] : '';
        $trtFormData['anxiety'] = !empty($step4['anxiety']) ? $step4['anxiety'] : '';
        $trtFormData['sleep_disturbances'] = !empty($step4['sleep_disturbances']) ? $step4['sleep_disturbances'] : '';
        $trtFormData['aches_and_pains'] = !empty($step4['aches_and_pains']) ? $step4['aches_and_pains'] : '';
        $trtFormData['tired'] = !empty($step4['tired']) ? $step4['tired'] : '';
        $trtFormData['headaches'] = !empty($step4['headaches']) ? $step4['headaches'] : '';
        $trtFormData['slowed_reflexes'] = !empty($step4['slowed_reflexes']) ? $step4['slowed_reflexes'] : '';
        $trtFormData['constipation'] = !empty($step4['constipation']) ? $step4['constipation'] : '';
        $trtFormData['hear_palpitation'] = !empty($step4['hear_palpitation']) ? $step4['hear_palpitation'] : '';
        $trtFormData['fast_heart_rate'] = !empty($step4['fast_heart_rate']) ? $step4['fast_heart_rate'] : '';
        $trtFormData['sugar_cravings'] = !empty($step4['sugar_cravings']) ? $step4['sugar_cravings'] : '';
        $trtFormData['weight_gain'] = !empty($step4['weight_gain']) ? $step4['weight_gain'] : '';
        $trtFormData['weight_loss_difficulty'] = !empty($step4['weight_loss_difficulty']) ? $step4['weight_loss_difficulty'] : '';
        $trtFormData['decreased_muscle_mass'] = !empty($step4['decreased_muscle_mass']) ? $step4['decreased_muscle_mass'] : '';
        $trtFormData['hot_flashes'] = !empty($step4['hot_flashes']) ? $step4['hot_flashes'] : '';
        $trtFormData['excessive_sweating'] = !empty($step4['excessive_sweating']) ? $step4['excessive_sweating'] : '';
        $trtFormData['excessive_facial_hair'] = !empty($step4['excessive_facial_hair']) ? $step4['excessive_facial_hair'] : '';
        $trtFormData['increased_acne'] = !empty($step4['increased_acne']) ? $step4['increased_acne'] : '';
        $trtFormData['oily_skin'] = !empty($step4['oily_skin']) ? $step4['oily_skin'] : '';
        $trtFormData['irritability'] = !empty($step4['irritability']) ? $step4['irritability'] : '';
        $trtFormData['mood_changes'] = !empty($step4['mood_changes']) ? $step4['mood_changes'] : '';
        $trtFormData['incontinence'] = !empty($step4['incontinence']) ? $step4['incontinence'] : '';
        $trtFormData['puffy_eyes'] = !empty($step4['puffy_eyes']) ? $step4['puffy_eyes'] : '';
        $trtFormData['low_blood_pressure'] = !empty($step4['low_blood_pressure']) ? $step4['low_blood_pressure'] : '';
        $trtFormData['slow_heart_rate'] = !empty($step4['slow_heart_rate']) ? $step4['slow_heart_rate'] : '';
        $trtFormData['weight_loss'] = !empty($step4['weight_loss']) ? $step4['weight_loss'] : '';
        $trtFormData['same_shipping_as_billing'] = !empty($step5['same_shipping_as_billing']) && $step5['same_shipping_as_billing'] == 'Yes' ? 1 : 0;
        $trtFormData['same_as_credit_card'] = !empty($step5['same_as_credit_card']) && $step5['same_as_credit_card'] == 'Yes' ? 1 : 0;
        $trtFormData['acknowledge'] = !empty($step5['acknowledge']) && $step5['acknowledge'] == 'Yes' ? 1 : 0;
        $trtFormData['same_shipping_as_billing'] = !empty($sameAsShiping) ? 1 : 0;

        $response = $this->saveTRTRecord($patientData, $trtFormData);

        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['patients_id'] = $response['patients_id'];
            $result['redirectUrl'] = '/thank-you';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        }
        return $result;
    }

    public function saveTRTRecord($patientData, $trtFormData)
    {

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|unique:users,email',
            'phone_no' => 'required|numeric',
            'dob' => 'required',
            'billing_address_1' => 'required',
            'billing_city_name' => 'required',
            'billing_state_id' => 'required|numeric',
            'billing_zip' => 'required',
            'apt' => 'required',
        ];
        $message['first_name.required'] = 'First Name is required';
        $message['last_name.required'] = 'Last Name is required';
        $message['email.required'] = 'Email Address is required';
        $message['phone_no.required'] = 'PhoneNo is required';
        $message['dob.required'] = 'DOB is required';
        $message['billing_address_1.required'] = 'Billing Address is required';
        $message['billing_city_name.required'] = 'Billing City is required';
        $message['billing_state_id.required'] = 'Billing State is required';
        $message['billing_zip.required'] = 'Billing Zip code is required';
        $message['apt.required'] = 'APT/Suite code is required';

        $validationResult = $this->validateDataWithMessage($rules, $patientData, $message);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (isset($patientData['patients_id']) && $patientData['patients_id'] != '') {
            $patientsId = $patientData['patients_id'];
            $patientsObj = new Patients();
            $patientsTable = $patientsObj->getTable();
            $selectedColumn = array($patientsTable . '.patients_id', $patientsTable . '.trt_refill');
            $patientsDetails = $patientsObj->setSelect()->addFieldToFilter($patientsTable, 'patients_id', '=', $patientData['patients_id'])->get($selectedColumn)->first();
            $trtRillCount = !empty($patientsDetails->trt_refill) ? $patientsDetails->trt_refill : "";
            if (!empty($trtRillCount) && $trtRillCount == 1) {
                $refillCount['trt_refill'] = $trtRillCount + 1;
                TrtFlow::where('patients_id', $patientsId)->update($trtFormData);
                Patients::where('patients_id', $patientsId)->update($refillCount);
            } else {
                $trtFormData['patients_id'] = $patientsId;
                Patients::where('patients_id', $patientsId)->update($patientData);
                self::create($trtFormData);
            }
        }

        else {
            $patients = Patients::create($patientData);
            $trtFormData['patients_id'] = $patients->patients_id;
            self::create($trtFormData);
        }

        session()->forget('trt_flow.step1');
        session()->forget('trt_flow.step2');
        session()->forget('trt_flow.step3');
        session()->forget('trt_flow.step4');
        session()->forget('trt_flow.step5');

        $response['success'] = true;
        $response['message'] = 'TRT survey from saved successfully.';
        $response['patients_id'] = '';
        return $response;

    }

}
