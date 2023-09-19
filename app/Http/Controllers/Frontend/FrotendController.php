<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\EDFlow;
use App\Models\ManageSection;
use App\Models\Product;
use App\Models\TrtFlow;
use Illuminate\Http\Request;

class FrotendController extends Controller
{

    public function thankYou()
    {
        return view('frontend.ed-form-survey.thank-you');
    }

    public function index(Request $request)
    {
        $flowType = !empty($request->flowType) ? $request->flowType : '';
        $uniqueUrl = !empty($request->uniqueID) ? $request->uniqueID : '';
        if ($flowType == 'ed') {
            $edFormDetails = $this->getUniqueByUrl($uniqueUrl,$flowType);
            session()->put('patient_data', $edFormDetails);
            return $this->step1();
        }

        else if ($flowType == 'trt') {
            $trtFlowDetails = $this->getUniqueByUrl($uniqueUrl,$flowType);
            session()->put('patient_data', $trtFlowDetails);
            $patient = session()->get('patient_data');
            $state = $trtFlowDetails->getStateList();
            return view('frontend.trt-form-survey.refill-assessment.step1')->with(compact('patient', 'state', 'flowType','uniqueUrl'));

        }
    }

    public function getStarted(Request $request)
    {
        $sku = $request->sku;

        $flow = $request->flow;

        session()->put('sku', $sku);

        session()->put('product_type', $flow);

        session()->forget('patient_data');

        $manageSectionObj = new ManageSection();

        $getContent = $manageSectionObj->getData();

        $productDetails = $this->getProductBySkU($sku,$flow);

        return view('frontend.get-started')->with(compact('getContent','productDetails'));
    }

    public function treatMeNow(){

        session()->put('product_type','TRT');
        return $this->step1();
    }

    public function step1()
    {
        $edFlowObj = new EDFlow();
        $memberId = $edFlowObj->getMemberId();
        $state = $edFlowObj->getStateList();

        $sku = session()->get('sku');
        $productType = session()->get('product_type');
        $patient = session()->get('patient_data');

        $productObj = new Product();
        $productDetails = $productObj->getProductBySkU($sku,$productType);
        session()->put('product_details', $productDetails);
        $productId = !empty($productDetails) ? $productDetails->product_id : '';

        if (!empty($productDetails)) {
            if ($productType == "ed") {
                return view('frontend.ed-form-survey.step1')->with(compact('productType', 'memberId', 'patient', 'productId', 'productDetails'));
            } else {
                return view('frontend.trt-form-survey.step1')->with(compact('productType', 'state', 'memberId', 'patient', 'productId', 'productDetails'));
            }
        } else {
            return redirect()->back()->with('alert', 'product not found');
        }


    }

    public function step2()
    {
        $patient = session()->get('patient_data');
        return view('frontend.ed-form-survey.step2')->with(compact('patient'));
    }

    public function step3()
    {
        $patient = session()->get('patient_data');
        return view('frontend.ed-form-survey.step3')->with(compact('patient'));
    }

    public function step4()
    {
        $edFlowObj = new EDFlow();
        $patient = session()->get('patient_data');
        $product = session()->get('product_details');
        $state = $edFlowObj->getStateList();
        return view('frontend.ed-form-survey.step4')->with(compact('patient', 'state', 'product'));
    }

    public function saveEdStepOne(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep1($data);
    }

    public function saveEdStepTwo(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep2($data);
    }

    public function saveEdStepThree(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep3($data);
    }

    public function saveEdStepFour(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->createEDFormRecord($data);
    }

    public function trtFormSurvey()
    {
        return view('frontend.trt-ed-form-survey.step1');
    }

    public function trtStep1()
    {
        $trtFlowObj = new TrtFlow();
        $state = $trtFlowObj->getStateList();
        $patient = session()->get('patient_data');
        if (!empty($patient)) {
            return view('frontend.trt-form-survey.refill-assessment.step1')->with(compact('state', 'patient'));
        } else {
            return view('frontend.trt-form-survey.step1')->with(compact('state'));
        }

    }

    public function trtStep2()
    {
        $patient = session()->get('patient_data');
        return view('frontend.trt-form-survey.refill-assessment.step2')->with(compact('patient'));
    }

    public function trtStep3()
    {
        $patient = session()->get('patient_data');

        return view('frontend.trt-form-survey.refill-assessment.step3')->with(compact('patient'));
    }

    public function trtStep4()
    {
        $patient = session()->get('patient_data');
        return view('frontend.trt-form-survey.refill-assessment.step4')->with(compact('patient'));
    }

    public function trtStep5()
    {
        $patient = session()->get('patient_data');
        return view('frontend.trt-form-survey.refill-assessment.step5')->with(compact('patient'));
    }

    public function trtStep6()
    {
        $patient = session()->get('patient_data');
        return view('frontend.trt-form-survey.refill-assessment.step6')->with(compact('patient'));
    }

    public function saveTRTStepOne(Request $request)
    {
        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->createTRTRecord($data);
    }

    public function saveTRTStepOneRefill(Request $request)
    {
        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->ValidateTRTStep1($data);
    }

    public function saveTRTStepTwoRefill(Request $request)
    {

        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->ValidateTRTStep2($data);
    }

    public function saveTRTStepThreeRefill(Request $request)
    {

        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->ValidateTRTStep3($data);
    }

    public function saveTRTStepFourRefill(Request $request)
    {

        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->ValidateTRTStep4($data);
    }

    public function saveTRTStepFiveRefill(Request $request)
    {
        $trtFlowObj = new TrtFlow();
        $data = $request->all();
        return $trtFlowObj->ValidateTRTStep5($data);
    }

    public function saveTRTStepSixRefill(Request $request)
    {
        $trtFlowObj = new TrtFlow();
        $step1 = session()->get('trt_flow.step1');
        $step2 = session()->get('trt_flow.step2');
        $step3 = session()->get('trt_flow.step3');
        $step4 = session()->get('trt_flow.step4');
        $step5 = session()->get('trt_flow.step5');
        $data = [
            'additional_information' => !empty($request->additional_information) ? $request->additional_information : '',
            'experience' => !empty($request->experience) ? $request->experience : '',
            'patients_id' => !empty($request->patients_id) ? $request->patients_id : '',
            'product_id' => !empty($step1['product_id']) ? $step1['product_id'] : '',
            'member_id' => !empty($step1['member_id']) ? $step1['member_id'] : '',
            'first_name' => !empty($step1['first_name']) ? $step1['first_name'] : '',
            'last_name' => !empty($step1['last_name']) ? $step1['last_name'] : '',
            'email' => !empty($step1['email']) ? $step1['email'] : '',
            'dob' => !empty($step1['dob']) ? $step1['dob'] : '',
            'phone_no' => !empty($step1['phone_no']) ? $step1['phone_no'] : '',
            'country_code' => !empty($step1['country_code']) ? $step1['country_code'] : '',
            'apt' => !empty($step1['apt']) ? $step1['apt'] : '',
            'billing_address_1' => !empty($step1['billing_address_1']) ? $step1['billing_address_1'] : '',
            'billing_city_name' => !empty($step1['billing_city_name']) ? $step1['billing_city_name'] : '',
            'billing_state_id' => !empty($step1['billing_state_id']) ? $step1['billing_state_id'] : '',
            'billing_zipcode' => !empty($step1['billing_zipcode']) ? $step1['billing_zipcode'] : '',
            'billing_same_as_shipping' => !empty($step1['billing_same_as_shipping']) ? $step1['billing_same_as_shipping'] : '',
            'energy' => !empty($step2['energy']) ? $step2['energy'] : '',
            'sleep' => !empty($step2['sleep']) ? $step2['sleep'] : '',
            'libido' => !empty($step2['libido']) ? $step2['libido'] : '',
            'memory' => !empty($step2['memory']) ? $step2['memory'] : '',
            'strength' => !empty($step2['strength']) ? $step2['strength'] : '',
            'future_children' => !empty($step3['future_children']) ? $step3['future_children'] : '',
            'living_children' => !empty($step3['living_children']) ? $step3['living_children'] : '',
            'cream_and_gel' => !empty($step3['cream_and_gel']) ? $step3['cream_and_gel'] : '',
            'allergies' => !empty($step3['allergies']) ? $step3['allergies'] : '',
            'herbal_or_vitamin' => !empty($step3['herbal_or_vitamin']) ? $step3['herbal_or_vitamin'] : '',
            'medications_prescribed' => !empty($step3['medications_prescribed']) ? $step3['medications_prescribed'] : '',
            'cold_chills' => !empty($step4['cold_chills']) ? $step4['cold_chills'] : '',
            'cold_hand_and_feet' => !empty($step4['cold_hand_and_feet']) ? $step4['cold_hand_and_feet'] : '',
            'decreased_sweating' => !empty($step4['decreased_sweating']) ? $step4['decreased_sweating'] : '',
            'thinning_skin' => !empty($step4['thinning_skin']) ? $step4['thinning_skin'] : '',
            'excessive_body_hair' => !empty($step4['excessive_body_hair']) ? $step4['excessive_body_hair'] : '',
            'nail_brittle' => !empty($step4['nail_brittle']) ? $step4['nail_brittle'] : '',
            'dry_brittle' => !empty($step4['dry_brittle']) ? $step4['dry_brittle'] : '',
            'hair_loss' => !empty($step4['hair_loss']) ? $step4['hair_loss'] : '',
            'dry_skin' => !empty($step4['dry_skin']) ? $step4['dry_skin'] : '',
            'thinning_public_hair' => !empty($step4['thinning_public_hair']) ? $step4['thinning_public_hair'] : '',
            'low_libido' => !empty($step4['low_libido']) ? $step4['low_libido'] : '',
            'memory_lapsed' => !empty($step4['memory_lapsed']) ? $step4['memory_lapsed'] : '',
            'difficulty_concentrating' => !empty($step4['difficulty_concentrating']) ? $step4['difficulty_concentrating'] : '',
            'deperssion' => !empty($step4['deperssion']) ? $step4['deperssion'] : '',
            'stress' => !empty($step4['stress']) ? $step4['stress'] : '',
            'anxiety' => !empty($step4['anxiety']) ? $step4['anxiety'] : '',
            'sleep_disturbances' => !empty($step4['sleep_disturbances']) ? $step4['sleep_disturbances'] : '',
            'aches_and_pains' => !empty($step4['aches_and_pains']) ? $step4['aches_and_pains'] : '',
            'headaches' => !empty($step4['headaches']) ? $step4['headaches'] : '',
            'tired' => !empty($step4['tired']) ? $step4['tired'] : '',
            'hoarseness' => !empty($step4['hoarseness']) ? $step4['hoarseness'] : '',
            'slowed_reflexes' => !empty($step4['slowed_reflexes']) ? $step4['slowed_reflexes'] : '',
            'constipation' => !empty($step4['constipation']) ? $step4['constipation'] : '',
            'hear_palpitation' => !empty($step4['hear_palpitation']) ? $step4['hear_palpitation'] : '',
            'fast_heart_rate' => !empty($step4['fast_heart_rate']) ? $step4['fast_heart_rate'] : '',
            'sugar_cravings' => !empty($step4['sugar_cravings']) ? $step4['sugar_cravings'] : '',
            'weight_gain' => !empty($step4['weight_gain']) ? $step4['weight_gain'] : '',
            'weight_loss_difficulty' => !empty($step4['weight_loss_difficulty']) ? $step4['weight_loss_difficulty'] : '',
            'decreased_muscle_mass' => !empty($step4['decreased_muscle_mass']) ? $step4['decreased_muscle_mass'] : '',
            'hot_flashes' => !empty($step4['hot_flashes']) ? $step4['hot_flashes'] : '',
            'excessive_sweating' => !empty($step4['excessive_sweating']) ? $step4['excessive_sweating'] : '',
            'excessive_facial_hair' => !empty($step4['excessive_facial_hair']) ? $step4['excessive_facial_hair'] : '',
            'increased_acne' => !empty($step4['increased_acne']) ? $step4['increased_acne'] : '',
            'oily_skin' => !empty($step4['oily_skin']) ? $step4['oily_skin'] : '',
            'irritability' => !empty($step4['irritability']) ? $step4['irritability'] : '',
            'mood_changes' => !empty($step4['mood_changes']) ? $step4['mood_changes'] : '',
            'incontinence' => !empty($step4['incontinence']) ? $step4['incontinence'] : '',
            'puffy_eyes' => !empty($step4['puffy_eyes']) ? $step4['puffy_eyes'] : '',
            'low_blood_pressure' => !empty($step4['low_blood_pressure']) ? $step4['low_blood_pressure'] : '',
            'slow_heart_rate' => !empty($step4['slow_heart_rate']) ? $step4['slow_heart_rate'] : '',
            'weight_loss' => !empty($step4['weight_loss']) ? $step4['weight_loss'] : '',
            'same_shipping_as_billing' => !empty($step5['same_shipping_as_billing']) ? $step5['same_shipping_as_billing'] : '',
            'same_as_credit_card' => !empty($step5['same_as_credit_card']) ? $step5['same_as_credit_card'] : '',
            'acknowledge' => !empty($step5['acknowledge']) ? $step5['acknowledge'] : '',
        ];
        return $trtFlowObj->createTRTRecord($data);
    }

    public function getProductBySkU($sku,$productType){
        $productObj = new Product();
        $result = $productObj->getProductBySkU($sku,$productType);
        return $result;
    }

    public function getUniqueByUrl($uniqueUrl,$flowType){
        if ($flowType == 'ed'){
            $edFlowObj = new EDFlow();
            $result = $edFlowObj->getUniqueByUrl($uniqueUrl);
        }
        else{
            $trtFlowObj = new TrtFlow();
            $result = $trtFlowObj->getUniqueByUrl($uniqueUrl);
        }

        return $result;
    }
}
