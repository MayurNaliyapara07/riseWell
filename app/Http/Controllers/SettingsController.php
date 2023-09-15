<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    protected $_model;

    public function __construct()
    {
        $this->_model = new Settings();
    }

    public function index()
    {
        return view('master.setting.index');
    }

    public function userChangePassword(){
        return view('master.setting.change-password');
    }

    public function generalSetting(){
        return view('master.setting.general-setting');
    }

    public function emailSetting(){
        return view('master.setting.email-setting');
    }

    public function smsSetting(){
        return view('master.setting.sms-setting');
    }

    public function paymentGateWaySetting(){
        return view('master.setting.payment-gateway-setting');
    }

    public function zoomSetting(){
        return view('master.setting.zoom-setting');
    }
    public function orderSetting(){
        return view('master.setting.order-setting');
    }

    public function orderShippingSetting(){
        return view('master.setting.order-shipping-setting');
    }

    public function userUpdate(Request $request,$id){
        $request->merge(['id' => $id]);
        return $this->_model->userUpdate($request);
    }

    public function updatePassword(Request $request){
        return $this->_model->updatePassword($request);
    }

    public function saveGeneralSetting(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->createGeneralSetting($request);
    }
    public function saveEmailSetting(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->createEmailSetting($request);
    }
    public function saveSMSSetting(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->createSMSSetting($request);
    }
    public function savePaymentGateWaySetting(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->createGeneralSetting($request);
    }

    public function saveZoomSetting(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->createGeneralSetting($request);
    }

    public function sendTestMail(Request $request){
        $generalSetting = new GeneralSetting();
        return $generalSetting->sendTestMail($request);
    }

}
