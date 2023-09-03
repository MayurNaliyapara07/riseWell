<?php

namespace App\Models;

use App\Helpers\EDFlow\Helper;
use AWS\CRT\HTTP\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class EDFlow extends BaseModel
{
    use HasFactory;

    protected $table = "ed_flow";

    protected $primaryKey = "ed_flow_id";

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

    public function loadByPatientsId($ed_flow_id)
    {
        $selectedColumns = [$this->table . '.patients_id AS patients_id', $this->table . '.ed_flow_id AS ed_flow_id', $this->table . '.unique_url AS unique_url'];
        $return = $this->setSelect()
            ->addFieldToFilter($this->table, 'ed_flow_id', '=', $ed_flow_id)
            ->get($selectedColumns)
            ->first();

        return $return;
    }

    public function checkUniqueUrlExit($ed_flow_id)
    {
        $randomString = $this->_helper->randomString(16);
        $selectedColumns = [$this->table . '.patients_id AS patients_id', $this->table . '.ed_flow_id AS ed_flow_id', $this->table . '.unique_url AS unique_url'];
        $edFlowResult = $this->setSelect()->where('ed_flow_id', '=', $ed_flow_id)->get($selectedColumns)->first();
        if (empty($edFlowResult->unique_url)) {
            DB::table($this->table)->where('ed_flow_id', $edFlowResult->ed_flow_id)->update(['unique_url' => $randomString]);
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

    public function ValidateStep1($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone_no' => 'required|numeric',
            'weekday' => 'required',
            'weekend' => 'required',
            'gender' => 'required',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'dob' => 'required',
            'policy' => 'required',
//            'terms' => 'required',
        ];
        $message['first_name.required'] = 'First Name is required';
        $message['last_name.required'] = 'Last Name is required';
        $message['email.required'] = 'Email Address is required';
        $message['phone_no.required'] = 'PhoneNo is required';
        $message['weekday.required'] = 'Weekday is required';
        $message['weekend.required'] = 'Weekend is required';
        $message['gender.required'] = 'Biological sex is required';
        $message['height.required'] = 'Height is required';
        $message['weight.required'] = 'Weight is required';
        $message['dob.required'] = 'DOB is required';
        $message['policy.required'] = 'Privacy Policy is required';
//        $message['terms.required'] = 'Terms is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);

        if ($validationResult['success'] == false) {

            $response['success'] = false;

            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }

            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {

            session()->put('ed_flow.step1', $data);

            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/step2';

        }

        return $response;
    }

    public function ValidateStep2($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'vitals' => 'required',
            'medical_problems' => 'required',
            'medical_problem' => 'required',
            'blood_pressure' => 'required',
            'blood_pressure_medication' => 'required',
            'medication_conjunction' => 'required',
            'recreational_drugs' => 'required',
            'medication_prescription' => 'required',
            'treat' => 'required',
            'cardiovascular' => 'required',
            'diabetes' => 'required',
            'diabetes_level' => 'required',
            'thyroid' => 'required',
            'cholesterol' => 'required',
            'breathing' => 'required',
            'gastroesophageal' => 'required',
            'hyperactivity' => 'required',
            'allergies' => 'required',
        ];
        $message['vitals.required'] = 'Vitas Tested is required';
        $message['medical_problems.required'] = 'Medical Problems is required';
        $message['medical_problem.required'] = 'Medical Problem(s) is required';
        $message['blood_pressure.required'] = 'Blood Pressure is required';
        $message['blood_pressure_medication.required'] = 'Blood Pressure Medication is required';
        $message['medication_conjunction.required'] = 'Nitrates Medication is required';
        $message['recreational_drugs.required'] = 'Recreational Medication is required';
        $message['medication_prescription.required'] = 'Prescription Medications is required';
        $message['treat.required'] = 'Treat Conditions is required';
        $message['cardiovascular.required'] = 'Cardiovascular Disease is required';
        $message['diabetes.required'] = 'Diabetes Medication is required';
        $message['diabetes_level.required'] = 'Diabetes Level is required';
        $message['thyroid.required'] = 'Thyroid Medication is required';
        $message['cholesterol.required'] = 'Cholesterol Medication is required';
        $message['breathing.required'] = 'Breathing Medication is required';
        $message['gastroesophageal.required'] = 'Gastroesophageal Reflux Medication is required';
        $message['hyperactivity.required'] = 'ADHD Medication is required';
        $message['allergies.required'] = 'Medication Allergies is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {
            session()->put('ed_flow.step2', $data);
            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/step3';
        }
        return $response;
    }

    public function ValidateStep3($data)
    {
        $response = array();
        $response['success'] = false;
        $response['message'] = '';

        $rules = [
            'erectile_dysfunction' => 'required',
            'treated_with' => 'required',
            'confidence_rate' => 'required',
            'sexual_stimulation' => 'required',
            'sexual_stimulation_1' => 'required',
            'sexual_stimulation_2' => 'required',
            'sexual_dificult' => 'required',
        ];
        $message['erectile_dysfunction.required'] = 'Erectile Dysfunction Medications is required';
        $message['treated_with.required'] = 'Treated Medications is required';
        $message['confidence_rate.required'] = 'Confidence Rate is required';
        $message['sexual_stimulation.required'] = 'Sexual Stimulation is required';
        $message['sexual_stimulation_1.required'] = 'Sexual Intercourse is required';
        $message['sexual_stimulation_2.required'] = 'Sexual Satisfactory is required';
        $message['sexual_dificult.required'] = 'Sexual Intercourse is required';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            foreach ($validationResult['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $response['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;

        } else {
            session()->put('ed_flow.step3', $data);
            $response['success'] = true;
            $response['message'] = '';
            $response['redirectUrl'] = '/step4';
        }

        return $response;
    }

    public function createEDFormRecord($request)
    {
        $patientsData = [];
        $edFormData = [];
        $result = [
            'success' => false,
            'message' => ''
        ];

        $step1 = session()->get('ed_flow.step1');
        $step2 = session()->get('ed_flow.step2');
        $step3 = session()->get('ed_flow.step3');

        $patientsData['survey_form_type'] = 'ed';
        $patientsData['product_id'] = !empty($step1['product_id']) ? $step1['product_id'] : '';
        $patientsData['member_id'] = !empty($step1['member_id']) ? $step1['member_id'] : '';
        $patientsData['first_name'] = !empty($step1['first_name']) ? $step1['first_name'] : '';
        $patientsData['last_name'] = !empty($step1['last_name']) ? $step1['last_name'] : '';
        $patientsData['email'] = !empty($step1['email']) ? $step1['email'] : '';
        $patientsData['phone_no'] = !empty($step1['phone_no']) ? $step1['phone_no'] : '';
        $patientsData['country_code'] = !empty($step1['country_code']) ? $step1['country_code'] : '';
        $patientsData['gender'] = !empty($step1['gender']) ? $step1['gender'] : '';
        $patientsData['height'] = !empty($step1['height']) ? $step1['height'] : '';
        $patientsData['weight'] = !empty($step1) ? $step1['weight'] : '';
        $patientsData['dob'] = !empty($step1['weight']) ? $step1['dob'] : '';
        $patientsData['state_id'] = !empty($request['billing_state_id']) ? $request['billing_state_id'] : null;
        $patientsData['status'] = self::STATUS_ACTIVE;

        $billing_address_1 = !empty($request['billing_address_1']) ? $request['billing_address_1'] : '';
        $billing_address_2 = !empty($request['billing_address_2']) ? $request['billing_address_2'] : '';
        $billing_state_id = !empty($request['billing_state_id']) ? $request['billing_state_id'] : null;
        $billing_city_name = !empty($request['billing_city_name']) ? $request['billing_city_name'] : '';
        $billing_zipcode = !empty($request['billing_zipcode']) ? $request['billing_zipcode'] : '';
        $shipping_address_1 = !empty($request['shipping_address_1']) ? $request['shipping_address_1'] : '';
        $shipping_address_2 = !empty($request['shipping_address_2']) ? $request['shipping_address_2'] : '';
        $shipping_state_id = !empty($request['shipping_state_id']) ? $request['shipping_state_id'] : null;
        $shipping_city_name = !empty($request['shipping_city_name']) ? $request['shipping_city_name'] : '';
        $shipping_zipcode = !empty($request['shipping_zipcode']) ? $request['shipping_zipcode'] : '';
        $edFormData['billing_same_as_shipping'] = !empty($request['billing_same_as_shipping']) && $request['billing_same_as_shipping'] == 'on' ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;;
        if (!empty($edFormData['billing_same_as_shipping'])) {
            $patientsData['billing_address_1'] = $billing_address_1;
            $patientsData['billing_address_2'] = $billing_address_2;
            $patientsData['billing_state_id'] = $billing_state_id;
            $patientsData['billing_city_name'] = $billing_city_name;
            $patientsData['billing_zip'] = $billing_zipcode;
            $patientsData['shipping_address_1'] = $billing_address_1;
            $patientsData['shipping_address_2'] = $billing_address_2;
            $patientsData['shipping_state_id'] = $billing_state_id;
            $patientsData['shipping_city_name'] = $billing_city_name;
            $patientsData['shipping_zip'] = $billing_zipcode;
        }
        else {
            $patientsData['billing_address_1'] = $billing_address_1;
            $patientsData['billing_address_2'] = $billing_address_2;
            $patientsData['billing_state_id'] = $billing_state_id;
            $patientsData['billing_city_name'] = $billing_city_name;
            $patientsData['billing_zip'] = $billing_zipcode;
            $patientsData['shipping_address_1'] = $shipping_address_1;
            $patientsData['shipping_address_2'] = $shipping_address_2;
            $patientsData['shipping_state_id'] = $shipping_state_id;
            $patientsData['shipping_city_name'] = $shipping_city_name;
            $patientsData['shipping_zip'] = $shipping_zipcode;
        }

        $edFormData['weekday'] = !empty($step1['weekday']) ? implode(',', $step1['weekday']) : '';
        $edFormData['weekend'] = !empty($step1['weekend']) ? implode(',', $step1['weekend']) : '';
        $edFormData['policy'] = !empty($step1['policy']) && $step1['policy'] == "on" ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;;
        $edFormData['terms'] = !empty($step1['terms']) && $step1['terms'] == "on" ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;;
        $edFormData['vitals'] = !empty($step2['vitals']) ? $step2['vitals'] : '';
        $edFormData['medical_problems'] = !empty($step2['medical_problems']) ? $step2['medical_problems'] : '';
        $edFormData['medical_problem'] = !empty($step2['medical_problem']) ? $step2['medical_problem'] : '';
        $edFormData['blood_pressure'] = !empty($step2['blood_pressure']) ? $step2['blood_pressure'] : '';
        $edFormData['blood_pressure_medication'] = !empty($step2['blood_pressure_medication']) ? $step2['blood_pressure_medication'] : '';
        $edFormData['medications'] = !empty($step2['medications']) ? $step2['medications'] : '';
        if (!empty($step2['medication_conjunction']) && count($step2['medication_conjunction']) > 0){
            $edFormData['medication_conjunction'] =  implode(',', $step2['medication_conjunction']);
        }
        if (!empty($step2['recreational_drugs']) && count($step2['recreational_drugs']) > 0){
            $edFormData['recreational_drugs'] =  implode(',', $step2['recreational_drugs']);
        }
        $edFormData['medication_prescription'] = !empty($step2['medication_prescription']) ? $step2['medication_prescription'] : '';
        $edFormData['treat'] = !empty($step2['treat']) ? $step2['treat'] : '';
        $edFormData['diabetes_level'] = !empty($step2['diabetes_level']) ? $step2['diabetes_level'] : '';
        $edFormData['cholesterol'] = !empty($step2['cholesterol']) ? $step2['cholesterol'] : '';
        $edFormData['other_conditions'] = !empty($step2['other_conditions']) ? $step2['other_conditions'] : '';
        $edFormData['cardiovascular'] = !empty($step2['cardiovascular']) ? $step2['cardiovascular'] : '';
        $edFormData['diabetes'] = !empty($step2['diabetes']) ? $step2['diabetes'] : '';
        $edFormData['thyroid'] = !empty($step2['thyroid']) ? $step2['thyroid'] : '-';
        $edFormData['cholesterol'] = !empty($step2['cardiovascular']) ? $step2['cardiovascular'] : '';
        $edFormData['breathing'] = !empty($step2['breathing']) ? $step2['breathing'] : '';
        $edFormData['gastroesophageal'] = !empty($step2['gastroesophageal']) ? $step2['gastroesophageal'] : '';
        $edFormData['hyperactivity'] = !empty($step2['hyperactivity']) ? $step2['hyperactivity'] : '';
        $edFormData['allergies'] = !empty($step2['allergies']) ? $step2['allergies'] : '';
        $edFormData['allergies_list'] = !empty($step2['allergies_list']) ? $step2['allergies_list'] : '';
        $edFormData['pi'] = !empty($step2['pi']) ? $step2['pi'] : '';
        $edFormData['erectile_dysfunction'] = !empty($step3['erectile_dysfunction']) && $step3['erectile_dysfunction'] == "on" ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;
        $edFormData['treated_with'] = !empty($step3['treated_with']) ? $step3['treated_with'] : '';
        $edFormData['confidence_rate'] = !empty($step3['confidence_rate']) ? $step3['confidence_rate'] : '';
        $edFormData['sexual_stimulation'] = !empty($step3['sexual_stimulation']) ? $step3['sexual_stimulation'] : '';
        $edFormData['sexual_stimulation_1'] = !empty($step3['sexual_stimulation_1']) ? $step3['sexual_stimulation_1'] : '';
        $edFormData['sexual_stimulation_2'] = !empty($step3['sexual_stimulation_2']) ? $step3['sexual_stimulation_2'] : '';
        $edFormData['sexual_dificult'] = !empty($step3['sexual_dificult']) ? $step3['sexual_dificult'] : '';
        $edFormData['card_no'] = !empty($request['card_no']) ? $request['card_no'] : '';
        $edFormData['expire_date'] = !empty($request['expire_date']) ? $request['expire_date'] : '';
        $edFormData['card_cvv'] = !empty($request['card_cvv']) ? $request['card_cvv'] : '';
        $edFormData['patients_id'] = !empty($request['patients_id']) ? $request['patients_id'] : '';

        $response = $this->saveEDFormRecord($patientsData, $edFormData);

        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['patients_id'] = $response['patients_id'];
            $result['redirectUrl'] = '/checkout/' . $response['patients_id'];

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

    public function saveEDFormRecord($patientsData, $edFormData)
    {

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $rules['billing_address_1'] = 'required';
        $rules['billing_state_id'] = 'required|numeric';
        $rules['billing_city_name'] = 'required';
        $rules['billing_zip'] = 'required';
        $message['billing_address_1.required'] = 'Billing Address is required';
        $message['billing_city_name.required'] = 'Billing City is required';
        $message['billing_state_id.required'] = 'Billing State is required';
        $message['billing_zip.required'] = 'Billing ZipCode is required';

        $validationResult = $this->validateDataWithMessage($rules, $patientsData, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (isset($edFormData['patients_id']) && $edFormData['patients_id'] != '') {
            self::create($edFormData);
            $patient_id = $edFormData['patients_id'];

        } else {
            $patients = Patients::create($patientsData);
            $productId = $patients->product_id;
            $edFormData['patients_id'] = $patients->patients_id;
            self::create($edFormData);
            $patient_id = $patients->patients_id;
        }

        /* destroy session record */
        session()->forget('ed_flow.step1');
        session()->forget('ed_flow.step2');
        session()->forget('ed_flow.step3');
        session()->forget('product_details');

        $response['success'] = true;
        $response['message'] = 'From survey saved succeessfully ';
        $response['patients_id'] = $patient_id;
        return $response;

    }


}
