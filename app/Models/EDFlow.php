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
            'phone_no' => 'required',
        ];

        $validationResult = $this->validateDataWithRules($rules, $data);

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
        ];

        $validationResult = $this->validateDataWithRules($rules, $data);

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
        ];

        $validationResult = $this->validateDataWithRules($rules, $data);

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

        $step1 = session()->get('ed_flow.step1');
        $step2 = session()->get('ed_flow.step2');
        $step3 = session()->get('ed_flow.step3');

        $patientsData = [];
        $edFormData = [];

        $result = ['success' => false, 'message' => ''];

        $patientsData['survey_form_type'] = 'ed';
        $patientsData['product_id'] = !empty($step1['product_id']) ? $step1['product_id'] : '';
        $patientsData['member_id'] = !empty($step1['member_id']) ? $step1['member_id'] : '';
        $patientsData['first_name'] = !empty($step1['first_name']) ? $step1['first_name'] : '';
        $patientsData['last_name'] = !empty($step1['last_name']) ? $step1['last_name'] : '';
        $patientsData['email'] = !empty($step1['email']) ? $step1['email'] : '';
        $patientsData['phone_no'] = !empty($step1['phone_no']) ? $step1['phone_no'] : '';
        $patientsData['gender'] = !empty($step1['gender']) ? $step1['gender'] : '';
        $patientsData['height'] = !empty($step1['height']) ? $step1['height'] : '';
        $patientsData['weight'] = !empty($step1) ? $step1['weight'] : '';
        $patientsData['dob'] = !empty($step1['weight']) ? $step1['dob'] : '';
        $patientsData['state_id'] = !empty($request['billing_state_id']) ? $request['billing_state_id'] : '';
        $patientsData['status'] = self::STATUS_ACTIVE;

        $edFormData['same_as_billing_address'] = !empty($request['billing_same_as_shipping']) && $request['billing_same_as_shipping'] == 'on' ? self::STATUS_ACTIVE : self::STATUS_INCTIVE;;

        $billing_address_1 = !empty($request['billing_address_1']) ? $request['billing_address_1'] : '';
        $billing_address_2 = !empty($request['billing_address_2']) ? $request['billing_address_2'] : '';
        $billing_state_id = !empty($request['billing_state_id']) ? $request['billing_state_id'] : '';
        $billing_city_name = !empty($request['billing_city_name']) ? $request['billing_city_name'] : '';
        $billing_zipcode = !empty($request['billing_zipcode']) ? $request['billing_zipcode'] : '';

        $shipping_address_1 = !empty($request['shipping_address_1']) ? $request['shipping_address_1'] : '';
        $shipping_address_2 = !empty($request['shipping_address_2']) ? $request['shipping_address_2'] : '';
        $shipping_state_id = !empty($request['shipping_state_id']) ? $request['shipping_state_id'] : '';
        $shipping_city_name = !empty($request['shipping_city_name']) ? $request['shipping_city_name'] : '';
        $shipping_zipcode = !empty($request['shipping_zipcode']) ? $request['shipping_zipcode'] : '';


        if (!empty($edFormData['same_as_billing_address'])) {
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
        } else {
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
        $edFormData['medication_conjunction'] = !empty($step2['medication_conjunction']) ? implode(',', $step2['medication_conjunction']) : '';
        $edFormData['recreational_drugs'] = !empty($step2['recreational_drugs']) ? implode(',', $step2['recreational_drugs']) : '';
        $edFormData['medication_prescription'] = !empty($step2['medication_prescription']) ? $step2['medication_prescription'] : '';
        $edFormData['other_conditions'] = !empty($step2['other_conditions']) ? $step2['other_conditions'] : '';
        $edFormData['cardiovascular'] = !empty($step2['cardiovascular']) ? $step2['cardiovascular'] : '';
        $edFormData['diabetes'] = !empty($step2['diabetes']) ? $step2['diabetes'] : '';
        $edFormData['thyroid'] = !empty($step2['thyroid']) ? $step2['thyroid'] : '';
        $edFormData['cholesterol'] = !empty($step2['cardiovascular']) ? $step2['cardiovascular'] : '';
        $edFormData['breathing'] = !empty($step2['breathing']) ? $step2['breathing'] : '';
        $edFormData['gastroesophageal'] = !empty($step2['gastroesophageal']) ? $step2['gastroesophageal'] : '';
        $edFormData['hyperactivity'] = !empty($step2['hyperactivity']) ? $step2['hyperactivity'] : '';
        $edFormData['allergies'] = !empty($step2['allergies']) ? $step2['allergies'] : '';
        $edFormData['allergies_list'] = !empty($step2['allergies_list']) ? $step2['allergies_list'] : '';
        $edFormData['pi'] = !empty($step2['pi']) ? $step2['pi'] : '';
        $edFormData['erectile_dysfunction'] = !empty($step3['erectile_dysfunction']) ? $step3['erectile_dysfunction'] : '';
        $edFormData['treat'] = !empty($step3['treat']) ? $step3['treat'] : '';
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
            $result['redirectUrl'] = '/checkout/'.$response['patients_id'];

        } else {

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

        $rules['shipping_address_1'] = 'required';
        $rules['shipping_zip'] = 'required|numeric';
        $rules['billing_address_1'] = 'required';
        $rules['billing_zip'] = 'required|numeric';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $patientsData);

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



//    public function savePayment()
//    {
//        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
//        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//
//        $token = \Stripe\Token::create([
//            'account' => [
//                'individual' => [
//                    'first_name' => 'Jane',
//                    'last_name' => 'Doe',
//                ],
//            ],
//        ]);
//
//        $tokenId = $token['id'];
//        if (isset($tokenId)) {
//
//            $customer = \Stripe\Customer::create([
//                'name' => "mayur",
//                'email' => "mayur@gmail.com",
//                'phone' => "8849166013",
//                'address' => [
//                    'line1' => "Test 1",
//                    'postal_code' => "360002",
//                    'state' => "California",
//                    'city' => "",
//                    'country' => "US",
//                ],
//                'shipping' => [
//                    'name' => "Test 1",
//                    'phone' => "8849166013",
//                    'address' => [
//                        'line1' => "Test 1",
//                        'postal_code' => "360002",
//                        'state' => "California",
//                        'city' => "",
//                        'country' => "US",
//                    ],
//                ],
//            ]);
//
//            $customerId = $customer['id'];
//
//            $paymentIntent = $stripe->paymentIntents->create([
//                'customer' => $customerId,
//                'payment_method_types' => ['card', 'bancontact', 'ideal'],
//            ]);
//
//            $client_secret = $paymentIntent['id'];
//            $productDetails = session()->get('product_details');
//            $subscription = \Stripe\Subscription::create([
//                'customer' => $customerId,
//                'items' => [[
//                    'price' => "plan_OOQ9LWKIO2ySmp",
//                ]],
//                'payment_behavior' => 'default_incomplete',
//                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
//                'expand' => ['latest_invoice.payment_intent'],
//            ]);
//
//            $subscriptionId = $subscription['id'];
//            $subscriptionClientSecret = $subscription['latest_invoice']['hosted_invoice_url'];
//
//            echo "<pre>";
//            print_r($subscriptionClientSecret);
//            exit();
//        }
//    }


}
