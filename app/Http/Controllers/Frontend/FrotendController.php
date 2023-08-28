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
        $trtFlowObj = new TrtFlow();
        $flowType = !empty($request->flowType) ? $request->flowType : '';
        $uniqueUrl = !empty($request->uniqueID) ? $request->uniqueID : '';
        if ($flowType == 'ed') {
            $edFlowObj = new EDFlow();
            $edFormDetails = $edFlowObj->getUniqueByUrl($uniqueUrl);
            session()->put('patient_data', $edFormDetails);
            return $this->step1();
        } else if ($flowType == 'trt') {
            $trtFlowDetails = $trtFlowObj->getUniqueByUrl($uniqueUrl);
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
        session()->put('flow', $flow);
        $manageSectionObj = new ManageSection();
        $getContent = $manageSectionObj->getData();
        return view('frontend.ed-form-survey.get-started')->with(compact('getContent'));
    }

    public function step1()
    {
        $edFlowObj = new EDFlow();
        $memberId = $edFlowObj->getMemberId();
        $state = $edFlowObj->getStateList();
        $sku = session()->get('sku');
        $flow = session()->get('flow');
        $patient = session()->get('patient_data');
        $productObj = new Product();
        $productDetails = $productObj->getProductBySkU($sku);
        session()->put('product_details', $productDetails);

        $productId = !empty($productDetails) ? $productDetails->product_id : '';

        if (!empty($productDetails)) {
            if ($flow == "ed") {
                return view('frontend.ed-form-survey.step1')->with(compact('flow', 'memberId', 'patient', 'productId', 'productDetails'));
            } else {
                return view('frontend.trt-form-survey.step1')->with(compact('flow', 'state', 'memberId', 'patient', 'productId', 'productDetails'));
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

    public function saveStepOne(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep1($data);
    }

    public function saveStepTwo(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep2($data);
    }

    public function saveStepThree(Request $request)
    {
        $edFlowObj = new EDFlow();
        $data = $request->all();
        return $edFlowObj->ValidateStep3($data);
    }

    public function saveStepFour(Request $request)
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
        $data = $request->all();
        return $trtFlowObj->createTRTRecord($data);
    }
}
