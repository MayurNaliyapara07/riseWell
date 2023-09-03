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
            'cold_chills' => 'required',
            'cold_hand_and_feet' => 'required',
            'decreased_sweating' => 'required',
            'thinning_skin' => 'required',
            'excessive_body_hair' => 'required',
            'nail_brittle' => 'required',
            'dry_brittle' => 'required',
            'hair_loss' => 'required',
            'dry_skin' => 'required',
            'thinning_public_hair' => 'required',
            'low_libido' => 'required',
            'memory_lapsed' => 'required',
            'difficulty_concentrating' => 'required',
            'deperssion' => 'required',
            'stress' => 'required',
            'anxiety' => 'required',
            'sleep_disturbances' => 'required',
            'aches_and_pains' => 'required',
            'headaches' => 'required',
            'tired' => 'required',
            'hoarseness' => 'required',
            'slowed_reflexes' => 'required',
            'constipation' => 'required',
            'hear_palpitation' => 'required',
            'fast_heart_rate' => 'required',
            'sugar_cravings' => 'required',
            'weight_gain' => 'required',
            'weight_loss_difficulty' => 'required',
            'decreased_muscle_mass' => 'required',
            'hot_flashes' => 'required',
            'excessive_sweating' => 'required',
            'excessive_facial_hair' => 'required',
            'increased_acne' => 'required',
            'oily_skin' => 'required',
            'irritability' => 'required',
            'mood_changes' => 'required',
            'incontinence' => 'required',
            'puffy_eyes' => 'required',
            'low_blood_pressure' => 'required',
            'slow_heart_rate' => 'required',
            'weight_loss' => 'required',
        ];
        $message['cold_chills.required'] = 'Cold Chills is required';
        $message['cold_hand_and_feet.required'] = 'Cold Hands and Feet is required';
        $message['decreased_sweating.required'] = 'Decreased Sweating  is required';
        $message['thinning_skin.required'] = 'Thinking Skin is required';
        $message['excessive_body_hair.required'] = 'Excessive Body Hair is required';
        $message['nail_brittle.required'] = 'Nail Brittle Or Breaking is required';
        $message['dry_brittle.required'] = 'Dry and Brittle Hair is required';
        $message['hair_loss.required'] = 'Hair Loss On Scalp is required';
        $message['dry_skin.required'] = 'Dry Skin is is required';
        $message['thinning_public_hair.required'] = 'Thinning Public Hair is required';
        $message['low_libido.required'] = 'Low Libido is required';
        $message['memory_lapsed.required'] = 'Memory Lapses is required';
        $message['difficulty_concentrating.required'] = 'Difficulty Concentratingn is required';
        $message['deperssion.required'] = 'Depression is required';
        $message['stress.required'] = 'Stress is required';
        $message['anxiety.required'] = 'Anxiety is required';
        $message['sleep_disturbances.required'] = 'Sleep Disturbances is required';
        $message['aches_and_pains.required'] = 'Aches and Pains is required';
        $message['headaches.required'] = 'Headaches is required';
        $message['tired.required'] = 'Tired Or Exhausted is required';
        $message['hoarseness.required'] = 'Hoarseness is required';
        $message['slowed_reflexes.required'] = 'Slowed Reflexes is required';
        $message['constipation.required'] = 'Constipation is required';
        $message['hear_palpitation.required'] = 'Heart Palpitations is required';
        $message['fast_heart_rate.required'] = 'Fast Heart Rate is required';
        $message['sugar_cravings.required'] = 'Sugar Cravings is required';
        $message['weight_gain.required'] = 'Weight Gain is required';
        $message['weight_loss_difficulty.required'] = 'Weight Loss Difficulty is required';
        $message['decreased_muscle_mass.required'] = 'Decreased Muscle Mass is required';
        $message['hot_flashes.required'] = 'Hot Flashes is required';
        $message['excessive_sweating.required'] = 'Excessive Sweating is required';
        $message['excessive_facial_hair.required'] = 'Excessive Facial Hair is required';
        $message['increased_acne.required'] = 'Increased Acne is required';
        $message['oily_skin.required'] = 'Oily Skin is required';
        $message['irritability.required'] = 'Irritability is required';
        $message['mood_changes.required'] = 'Mood Changes is required';
        $message['incontinence.required'] = 'Incontinence is required';
        $message['puffy_eyes.required'] = 'Puffy Eyes Or Swollen Face is required';
        $message['low_blood_pressure.required'] = 'Low Blood Pressure is required';
        $message['slow_heart_rate.required'] = 'Slow Heart Rate is required';
        $message['weight_loss.required'] = 'Weight Loss is required';


        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        else {
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

        $result = ['success' => false, 'message' => ''];
        $patientData = [];
        $trtFormData = [];

        $patientData['first_name'] = !empty($request['first_name']) ? $request['first_name'] : '';
        $patientData['last_name'] = !empty($request['last_name']) ? $request['last_name'] : '';
        $patientData['email'] = !empty($request['email']) ? $request['email'] : '';
        $patientData['phone_no'] = !empty($request['phone_no']) ? $request['phone_no'] : '';
        $patientData['country_code'] = !empty($request['country_code']) ? $request['country_code'] : '';
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
        }
        else {
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
        $trtFormData['energy'] = !empty($request['energy']) ? $request['energy'] : '';
        $trtFormData['sleep'] = !empty($request['sleep']) ? $request['sleep'] : '';
        $trtFormData['libido'] = !empty($request['libido']) ? $request['libido'] : '';
        $trtFormData['memory'] = !empty($request['memory']) ? $request['memory'] : '';
        $trtFormData['strength'] = !empty($request['strength']) ? $request['strength'] : '';
        $trtFormData['future_children'] = !empty($request['future_children']) && $request['future_children'] == 'Yes' ? 1 : null;
        $trtFormData['living_children'] = !empty($request['living_children']) && $request['living_children'] == 'Yes' ? 1 : null;
        $trtFormData['cream_and_gel'] = !empty($request['cream_and_gel']) && $request['cream_and_gel'] == 'Yes' ? 1 : null;
        $trtFormData['allergies'] = !empty($request['allergies']) && $request['allergies'] == 'Yes' ? 1 : null;
        $trtFormData['herbal_or_vitamin'] = !empty($request['herbal_or_vitamin']) && $request['herbal_or_vitamin'] == 'Yes' ? 1 : null;
        $trtFormData['medications_prescribed'] = !empty($request['medications_prescribed']) && $request['medications_prescribed'] == 'Yes' ? 1 : null;
        $trtFormData['cold_chills'] = !empty($request['cold_chills']) ? $request['cold_chills'] : '';
        $trtFormData['cold_hand_and_feet'] = !empty($request['cold_hand_and_feet']) ? $request['cold_hand_and_feet'] : '';
        $trtFormData['decreased_sweating'] = !empty($request['decreased_sweating']) ? $request['decreased_sweating'] : '';
        $trtFormData['thinning_skin'] = !empty($request['thinning_skin']) ? $request['thinning_skin'] : '';
        $trtFormData['excessive_body_hair'] = !empty($request['excessive_body_hair']) ? $request['excessive_body_hair'] : '';
        $trtFormData['nail_brittle'] = !empty($request['nail_brittle']) ? $request['nail_brittle'] : '';
        $trtFormData['dry_brittle'] = !empty($request['dry_brittle']) ? $request['dry_brittle'] : '';
        $trtFormData['hair_loss'] = !empty($request['hair_loss']) ? $request['hair_loss'] : '';
        $trtFormData['dry_skin'] = !empty($request['dry_skin']) ? $request['dry_skin'] : '';
        $trtFormData['thinning_public_hair'] = !empty($request['thinning_public_hair']) ? $request['thinning_public_hair'] : '';
        $trtFormData['low_libido'] = !empty($request['low_libido']) ? $request['low_libido'] : '';
        $trtFormData['memory_lapsed'] = !empty($request['memory_lapsed']) ? $request['memory_lapsed'] : '';
        $trtFormData['difficulty_concentrating'] = !empty($request['difficulty_concentrating']) ? $request['difficulty_concentrating'] : '';
        $trtFormData['deperssion'] = !empty($request['deperssion']) ? $request['deperssion'] : '';
        $trtFormData['stress'] = !empty($request['stress']) ? $request['stress'] : '';
        $trtFormData['anxiety'] = !empty($request['anxiety']) ? $request['anxiety'] : '';
        $trtFormData['sleep_disturbances'] = !empty($request['sleep_disturbances']) ? $request['sleep_disturbances'] : '';
        $trtFormData['aches_and_pains'] = !empty($request['aches_and_pains']) ? $request['aches_and_pains'] : '';
        $trtFormData['tired'] = !empty($request['tired']) ? $request['tired'] : '';
        $trtFormData['headaches'] = !empty($request['headaches']) ? $request['headaches'] : '';
        $trtFormData['slowed_reflexes'] = !empty($request['slowed_reflexes']) ? $request['slowed_reflexes'] : '';
        $trtFormData['constipation'] = !empty($request['constipation']) ? $request['constipation'] : '';
        $trtFormData['hear_palpitation'] = !empty($request['hear_palpitation']) ? $request['hear_palpitation'] : '';
        $trtFormData['fast_heart_rate'] = !empty($request['fast_heart_rate']) ? $request['fast_heart_rate'] : '';
        $trtFormData['sugar_cravings'] = !empty($request['sugar_cravings']) ? $request['sugar_cravings'] : '';
        $trtFormData['weight_gain'] = !empty($request['weight_gain']) ? $request['weight_gain'] : '';
        $trtFormData['weight_loss_difficulty'] = !empty($request['weight_loss_difficulty']) ? $request['weight_loss_difficulty'] : '';
        $trtFormData['decreased_muscle_mass'] = !empty($request['decreased_muscle_mass']) ? $request['decreased_muscle_mass'] : '';
        $trtFormData['hot_flashes'] = !empty($request['hot_flashes']) ? $request['hot_flashes'] : '';
        $trtFormData['excessive_sweating'] = !empty($request['excessive_sweating']) ? $request['excessive_sweating'] : '';
        $trtFormData['excessive_facial_hair'] = !empty($request['excessive_facial_hair']) ? $request['excessive_facial_hair'] : '';
        $trtFormData['increased_acne'] = !empty($request['increased_acne']) ? $request['increased_acne'] : '';
        $trtFormData['oily_skin'] = !empty($request['oily_skin']) ? $request['oily_skin'] : '';
        $trtFormData['irritability'] = !empty($request['irritability']) ? $request['irritability'] : '';
        $trtFormData['mood_changes'] = !empty($request['mood_changes']) ? $request['mood_changes'] : '';
        $trtFormData['incontinence'] = !empty($request['incontinence']) ? $request['incontinence'] : '';
        $trtFormData['puffy_eyes'] = !empty($request['puffy_eyes']) ? $request['puffy_eyes'] : '';
        $trtFormData['low_blood_pressure'] = !empty($request['low_blood_pressure']) ? $request['low_blood_pressure'] : '';
        $trtFormData['slow_heart_rate'] = !empty($request['slow_heart_rate']) ? $request['slow_heart_rate'] : '';
        $trtFormData['weight_loss'] = !empty($request['weight_loss']) ? $request['weight_loss'] : '';
        $trtFormData['same_shipping_as_billing'] = !empty($request['same_shipping_as_billing']) && $request['same_shipping_as_billing'] == 'Yes' ? 1 : 0;
        $trtFormData['same_as_credit_card'] = !empty($request['same_as_credit_card']) && $request['same_as_credit_card'] == 'Yes' ? 1 : 0;
        $trtFormData['acknowledge'] = !empty($request['acknowledge']) && $request['acknowledge'] == 'Yes' ? 1 : 0;

        $response = $this->saveTRTRecord($patientData, $trtFormData);

        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = $response['redirectUrl'];
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
                $patientData['trt_refill'] = $trtRillCount + 1;
                Patients::where('patients_id', $patientsId)->update($patientData);
                self::create($trtFormData);
                $redirectUrl = '/thank-you';
            }
        }

        else {
            $patients = Patients::create($patientData);
            $trtFormData['patients_id'] = $patients->patients_id;
            self::create($trtFormData);
            $redirectUrl = '/checkout/' . $patients->patients_id;
        }

        session()->forget('trt_flow.step1');
        session()->forget('trt_flow.step2');
        session()->forget('trt_flow.step3');
        session()->forget('trt_flow.step4');
        session()->forget('trt_flow.step5');

        $response['success'] = true;
        $response['message'] = 'TRT survey from saved successfully.';
        $response['redirectUrl'] = $redirectUrl;
        return $response;

    }

}
