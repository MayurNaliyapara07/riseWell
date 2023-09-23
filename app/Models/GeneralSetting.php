<?php

namespace App\Models;

use App\Helpers\GeneralSetting\Helper;
use App\Notify\Sms;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralSetting extends BaseModel
{
    use HasFactory;

    protected $table = "general_setting";

    protected $primaryKey = "general_setting_id";

    protected $fillable = ['email_from', 'site_title', 'site_logo','site_logo_dark','country_code','mail_config','sms_config','stripe_key','stripe_secret_key','stripe_webhook_key','zoom_client_url','zoom_client_secret_key','zoom_account_no','zoom_access_token'];

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

    public function createEmailSetting($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['general_setting_id'] = !empty($request['general_setting_id']) ? $request['general_setting_id'] : '';
        $data['email_method'] = $request['email_method'];

        /* mail config */
        if ($request['email_method'] == 'php') {
            $data['name'] = 'php';
        } elseif ($request['email_method'] == 'smtp') {
            $data['name'] = 'smtp';
            $data['host'] = $request['host'];
            $data['port'] = $request['port'];
            $data['encryption'] = $request['encryption'];
            $data['username'] = $request['username'];
            $data['password'] = $request['password'];
        } elseif ($request['email_method'] == 'sendgrid') {
            $data['name'] = 'sendgrid';
            $data['app_key'] = $request['app_key'];
        } elseif ($request['email_method'] == 'mailjet') {
            $data['name'] = 'mailjet';
            $data['public_key'] = $request['public_key'];
            $data['secret_key'] = $request['secret_key'];
        }

        $response = $this->saveEmailSetting($data);
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

    public function saveEmailSetting($data)
    {


        $rules['email_method'] = 'required|in:php,smtp,sendgrid,mailjet';
        $rules['host'] = 'required_if:email_method,smtp';
        $rules['port'] = 'required_if:email_method,smtp';
        $rules['encryption'] = 'required_if:email_method,smtp';
        $rules['username'] = 'required_if:email_method,smtp';
        $rules['password'] = 'required_if:email_method,smtp';
        $rules['app_key'] = 'required_if:email_method,sendgrid';
        $rules['public_key'] = 'required_if:email_method,mailjet';
        $rules['secret_key'] = 'required_if:email_method,mailjet';
        $message['host.required_if'] = ':attribute is required for SMTP configuration';
        $message['port.required_if'] = ':attribute is required for SMTP configuration';
        $message['encryption.required_if'] = ':attribute is required for SMTP configuration';
        $message['username.required_if'] = ':attribute is required for SMTP configuration';
        $message['password.required_if'] = ':attribute is required for SMTP configuration';
        $message['app_key.required_if'] = ':attribute is required for SendGrid configuration';
        $message['public_key.required_if'] = ':attribute is required for Mailjet configuration';
        $message['secret_key.required_if'] = ':attribute is required for Mailjet configuration';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (isset($data['general_setting_id']) && $data['general_setting_id'] != '') {
            $generalSetting = self::findOrFail($data['general_setting_id']);
            $mailConfig['mail_config'] = $data;
            $generalSetting->update($mailConfig);
        } else {
            $mailConfig['mail_config'] = $data;
            self::create($mailConfig);

        }
        $response['success'] = true;
        $response['message'] = 'Setting has been updated successfully.';
        return $response;
    }

    public function createSMSSetting($request)
    {

        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['general_setting_id'] = !empty($request['general_setting_id']) ? $request['general_setting_id'] : '';
        $data['sms_method'] = $request['sms_method'];

        /* sms config */
        if ($request['sms_method'] == 'twilio') {
            $data['name'] = 'twilio';
            $data['account_sid'] = $request['account_sid'];
            $data['auth_token'] = $request['auth_token'];
            $data['from_number'] = $request['from_number'];
        } elseif ($request['sms_method'] == 'clickatell') {
            $data['name'] = 'clickatell';
            $data['clickatell_api_key'] = $request['clickatell_api_key'];
        } elseif ($request['sms_method'] == 'infobip') {
            $data['name'] = 'infobip';
            $data['infobip_username'] = $request['infobip_username'];
            $data['infobip_password'] = $request['infobip_password'];
        } elseif ($request['sms_method'] == 'messageBird') {
            $data['name'] = 'messageBird';
            $data['message_bird_api_key'] = $request['message_bird_api_key'];
        } elseif ($request['sms_method'] == 'nexmo') {
            $data['name'] = 'nexmo';
            $data['nexmo_api_key'] = $request['nexmo_api_key'];
            $data['nexmo_api_secret'] = $request['nexmo_api_secret'];
        } elseif ($request['sms_method'] == 'smsBroadcast') {
            $data['name'] = 'smsBroadcast';
            $data['sms_broadcast_username'] = $request['sms_broadcast_username'];
            $data['sms_broadcast_password'] = $request['sms_broadcast_password'];
        } elseif ($request['sms_method'] == 'textMagic') {
            $data['name'] = 'textMagic';
            $data['text_magic_username'] = $request['text_magic_username'];
            $data['apiv2_key'] = $request['apiv2_key'];
        }


        $response = $this->saveSMSSetting($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/sms-setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveSMSSetting($data)
    {
        $rules['sms_method'] = 'required|in:clickatell,infobip,messageBird,nexmo,smsBroadcast,twilio,textMagic';
        $rules['clickatell_api_key'] = 'required_if:sms_method,clickatell';
        $rules['message_bird_api_key'] = 'required_if:sms_method,messageBird';
        $rules['nexmo_api_key'] = 'required_if:sms_method,nexmo';
        $rules['nexmo_api_secret'] = 'required_if:sms_method,nexmo';
        $rules['infobip_username'] = 'required_if:sms_method,infobip';
        $rules['infobip_password'] = 'required_if:sms_method,infobip';
        $rules['sms_broadcast_username'] = 'required_if:sms_method,smsBroadcast';
        $rules['sms_broadcast_password'] = 'required_if:sms_method,smsBroadcast';
        $rules['text_magic_username'] = 'required_if:sms_method,textMagic';
        $rules['apiv2_key'] = 'required_if:sms_method,textMagic';
        $rules['account_sid'] = 'required_if:sms_method,twilio';
        $rules['auth_token'] = 'required_if:sms_method,twilio';
        $rules['from_number'] = 'required_if:sms_method,twilio';
        $message['clickatell_api_key.required_if'] = ':attribute is required for Clickatelll configuration';
        $message['message_bird_api_key.required_if'] = ':attribute is required for Message bird configuration';
        $message['nexmo_api_key.required_if'] = ':attribute is required for Nexmo configuration';
        $message['nexmo_api_secret.required_if'] = ':attribute is required for Nexmo configuration';
        $message['infobip_username.required_if'] = ':attribute is required for Infobip configuration';
        $message['infobip_password.required_if'] = ':attribute is required for Infobip configuration';
        $message['sms_broadcast_username.required_if'] = ':attribute is required for SMS Broadcase configuration';
        $message['sms_broadcast_password.required_if'] = ':attribute is required for SMS Broadcase configuration';
        $message['text_magic_username.required_if'] = ':attribute is required for Text Magic configuration';
        $message['apiv2_key.required_if'] = ':attribute is required for Text Magic configuration';
        $message['account_sid.required_if'] = ':attribute is required for Twilio configuration';
        $message['auth_token.required_if'] = ':attribute is required for Twilio configuration';
        $message['from_number.required_if'] = ':attribute is required for Twilio configuration';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        if (isset($data['general_setting_id']) && $data['general_setting_id'] != '') {
            $generalSetting = self::findOrFail($data['general_setting_id']);
            $mailConfig['sms_config'] = $data;
            $generalSetting->update($mailConfig);
        } else {
            $mailConfig['sms_config'] = $data;
            self::create($mailConfig);

        }
        $response['success'] = true;
        $response['message'] = 'SMS Configuration has been updated successfully.';
        return $response;
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
        $data['test_email_template'] = $request['test_email_template'];
        $data['sms_template'] = $request['sms_template'];
        $data['appointment_template'] = $request['appointment_template'];
        $data['site_title'] = $request['site_title'];
        $data['email_from'] = $request['email_from'];
        $data['country_code'] = $request['country_code'];
        $data['order_placed'] = $request['order_placed'];
        $data['order_approved'] = $request['order_approved'];
        $data['order_shipped'] = $request['order_shipped'];
        $data['order_arrived'] = $request['order_arrived'];
        $data['order_fulfilled'] = $request['order_fulfilled'];
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

        $rules[''] = '';
        $message[''] = '';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
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
        $response = $this->sendMail($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/email-setting';
        } else if ($response['warning']) {
            $result['success'] = false;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/email-setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function sendMail($data)
    {
        $response = [];

        $response['success'] = false;
        $response['warning'] = false;
        $response['message'] = '';

        $rules['email'] = 'required|email';
        $validationResult = $this->validateDataWithRules($rules, $data);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $general = $this->_helper->gs();
        $config = $general->mail_config;
        if (!empty($config)) {
            $this->_helper->sendMailNotification($data['email'], 'DEFAULT', 'TestMail');
        } else {
            $response['warning'] = true;
            $response['message'] = 'Email Configuration Setting is required !!';
        }


        if (session('mail_error')) {
            $response['warning'] = true;
            $response['message'] = session('mail_error');
        } else {
            $response['success'] = true;
            $response['message'] = 'Email sent to ' . $data['email'] . ' successfully';
        }


        return $response;
    }

    public function sendTestSMS($request){
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['phone_no'] = $request['phone_no'];
        $response = $this->sendSMS($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/sms-setting';
        } else if ($response['warning']) {
            $result['success'] = false;
            $result['message'] = $response['message'];
            $result['redirectUrl'] = '/sms-setting';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function sendSMS($data){
        $response = [];
        $response['success'] = false;
        $response['warning'] = false;
        $response['message'] = '';

        $rules['phone_no'] = 'required';
        $validationResult = $this->validateDataWithRules($rules, $data);

        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $general = $this->_helper->gs();
        $config = $general->sms_config;
        if (!empty($config)) {
            $sendSms = new Sms;
            $sendSms->mobile = $data['phone_no'];
            $sendSms->receiverName = ' ';
            $sendSms->templateName = 'DEFAULT';
            $sendSms->message = 'Your sms notification setting is configured successfully for '.$general->site_title;
            $sendSms->subject = ' ';
            $sendSms->send();

        }
        else {
            $response['warning'] = true;
            $response['message'] = 'SMS Configuration Setting is required !!';
        }

        if (session('sms_error')) {
            $response['warning'] = true;
            $response['message'] = session('sms_error');
        } else {
            $response['success'] = true;
            $response['message'] = 'SMS sent to ' . $data['phone_no'] . ' successfully';
        }

        return $response;

    }


}
