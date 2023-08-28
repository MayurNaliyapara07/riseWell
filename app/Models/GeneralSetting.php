<?php

namespace App\Models;

use App\Helpers\GeneralSetting\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralSetting extends BaseModel
{
    use HasFactory;

    protected $table = "general_setting";
    protected $primaryKey = "general_setting_id";
    protected $fillable = ['site_title', 'zoom_client_url', 'zoom_client_secret_key', 'zoom_account_no', 'zoom_access_token', 'sms_template', 'appointment_template', 'country_code', 'site_logo', 'site_logo_dark', 'mail_config', 'account_sid', 'auth_token', 'from_number', 'stripe_key', 'stripe_secret_key', 'stripe_webhook_key', 'stripe_webhook_url'];

    protected $entity = 'general_setting';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }


    public function createGeneralSetting($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['general_setting_id'] = !empty($request['general_setting_id']) ? $request['general_setting_id'] : '';
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['site_logo'] = $fileName;
            }
        }
        if ($request->hasFile('site_logo_dark')) {
            $logo = $request->file('site_logo_dark');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['site_logo_dark'] = $fileName;
            }
        }
        $data['sms_template'] = $request['sms_template'];
        $data['appointment_template'] = $request['appointment_template'];
        $data['site_title'] = $request['site_title'];
        $data['country_code'] = $request['country_code'];
        $mailConfig = [
            'name' => 'smtp',
            'host' => $request['host'],
            'port' => $request['port'],
            'encryption' => $request['encryption'],
            'username' => $request['username'],
            'password' => $request['password'],
        ];
        $data['mail_config'] = json_encode($mailConfig);
        $data['auth_token'] = $request['auth_token'];
        $data['from_number'] = $request['from_number'];
        $data['account_sid'] = $request['account_sid'];
        $data['stripe_key'] = $request['stripe_key'];
        $data['stripe_secret_key'] = $request['stripe_secret_key'];
        $data['stripe_webhook_key'] = $request['stripe_webhook_key'];
        $data['stripe_webhook_url'] = $request['stripe_webhook_url'];
        $data['zoom_client_url'] = $request['zoom_client_url'];
        $data['zoom_client_secret_key'] = $request['zoom_client_secret_key'];
        $data['zoom_account_no'] = $request['zoom_account_no'];
        $data['zoom_access_token'] = $request['zoom_access_token'];

        /* set webhook url */
        if (!empty($request['stripe_webhook_url'])) {
            $this->_helper->setWebhookUrl($request['stripe_webhook_url']);
        }

        $response = $this->saveGeneralSetting($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveGeneralSetting($data)
    {
        $rules = [];
        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (isset($data['general_setting_id']) && $data['general_setting_id'] != '') {
            $generalSetting = self::findOrFail($data['general_setting_id']);
            $generalSetting->update($data);
            $this->afterSave($data, $generalSetting);
        } else {
            $generalSetting = self::create($data);
            $this->afterSave($data, $generalSetting);

        }
        $response['success'] = true;
        $response['message'] = 'Setting has been updated successfully.';
        return $response;
    }

    public function sendTestMail($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['email'] = $request['email'];
        $response = $this->send($data);


        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function send($data)
    {

        $rules['email'] = 'required|email';
        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $gs = $this->_helper->gs();
        if ($gs->mail_config) {
            $siteName = !empty($gs->site_title) ? $gs->site_title : '';
            $receiverName = explode('@', $data['email'])[0];
            $subject = 'SMTP Configuration Success';
            $message = 'Your email notification setting is configured successfully for ' . $siteName;
            $user = [
                'username' => $data['email'],
                'email' => $data['email'],
                'fullname' => $receiverName,
            ];
            $this->_helper->notify($user, 'DEFAULT', [
                'subject' => $subject,
                'message' => $message,
            ], ['email']);
            $response['success'] = true;
            $response['message'] = 'Test Mail has been sending successfully.';
        }

        else{
            $response['success'] = false;
            $response['message'] = 'Please enable from general settings';
        }

        if (session('mail_error')){
            $response['success'] = false;
            $response['message'] = session('mail_error');
            return $response;
        }
        else{
            $response['success'] = true;
            $response['message'] = 'Email sent to ' . $data['email']. ' successfully';

        }
        return $response;
    }


}
