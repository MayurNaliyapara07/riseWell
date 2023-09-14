<?php

namespace App\Helpers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Mail\Notify;
use App\Models\GeneralSetting;
use App\Models\ManageSection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class BaseHelper
{

    const CLIENT_IMAGES_DIR_NAME = 'images';
    const CLIENT_DOCS_DIR_NAME = 'docs';
    const CLIENT_EXPORT_DIR_NAME = 'export';
    const CLIENT_IMPORT_DIR_NAME = 'import';
    const CLIENT_FAVICON_DIR_NAME = 'favicon';
    const CLIENT_WYSWYG_DIR_NAME = 'wyswyg';
    const CLIENT_SHCHEDULE_DIR_NAME = 'schedule';
    const EST = 'est';
    const TST = 'tst';
    const CST = 'cst';
    const MALE = 'M';
    const FEMALE = 'F';

    protected $syncEndPoint = '/sync/cms';

    protected $_helper;

    public function __construct()
    {
    }

    public function timeZone()
    {
        return [
            ['key' => self::EST, 'value' => self::EST, 'label' => 'EST/EDT'],
            ['key' => self::TST, 'value' => self::TST, 'label' => 'TST/TDT'],
            ['key' => self::CST, 'value' => self::CST, 'label' => 'CST/CDT'],
        ];
    }

    public function gender()
    {
        return [
            ['key' => self::MALE, 'value' => self::MALE, 'label' => 'Male'],
            ['key' => self::FEMALE, 'value' => self::FEMALE, 'label' => 'Female'],
        ];
    }

    public function weekOfDay()
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }

    public $openingHoursOptions = [];

    public function makeOpeningHoursOptions()
    {
        $baseTime = Carbon::parse('today at 12 AM');
        while ($baseTime->notEqualTo(Carbon::parse('today 11:45 PM'))) {
            $baseTime = $baseTime->addMinute(15);
            $this->openingHoursOptions[$baseTime->format('H:i')] = $baseTime->format('h:i: A');
        }
        return $this->openingHoursOptions;
    }

    function mb_ucfirst($string, $encoding = 'utf8')
    {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, null, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    function mb_ucwords($string, $encoding = 'utf8')
    {
        return mb_convert_case($string, MB_CASE_TITLE, $encoding);
    }

    function minute_to_hour($totalMinutes)
    {
        $timeLog = intdiv($totalMinutes, 60) . ' ' . __('app.hrs') . ' ';

        if ($totalMinutes % 60 > 0) {
            $timeLog .= $totalMinutes % 60 . ' ' . __('app.mins');
        }

        return $timeLog;
    }

    public function isLocalHost()
    {
        $is = env('FILES_LOAD_FROM_LOCAL');

        return ($is) ? true : false;
    }

    public function getArrayValueIfNotEmpty($array, $index)
    {
        if (isset($array[$index])) {
            $value = trim($array[$index]);
            if ($value) {
                return $value;
            }
        }

        return false;
    }

    public function makeUrlKey($string)
    {
        $string = preg_replace('/[^A-Za-z0-9 ]/', ' ', strtolower($string));
        $string = preg_replace('/\s+/', ' ', $string);
        $string = preg_replace('/[^A-Za-z0-9]/', '-', strtolower($string));

        return $string;
    }

    public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
    {
        $sort_col = [];
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);

        return $arr;
    }

    public function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = [];
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);

        return array_pop($args);
    }

    public function array_unique_multidimensional($input)
    {
        $serialized = array_map('serialize', $input);
        $unique = array_unique($serialized);

        return array_intersect_key($input, $unique);
    }

    public function getModulePublicFilesDirName()
    {
        return $this->_client_public_files_module_dir_name;
    }

    public function randomString($n)
    {
        $generated_string = '';
        $domain = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }

        return $generated_string;
    }

    private function getImageExtensions()
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'svg', 'webp'];

        return $imageExtensions;
    }

    public function isImageFile($fileName)
    {
        $return = false;
        $imageExtensions = $this->getImageExtensions();
        $info = pathinfo($fileName);
        if (!empty($info['extension'])) {
            if (in_array($info['extension'], $imageExtensions)) {
                $return = true;
            }
        }

        return $return;
    }

    public function formatFileName($fileName)
    {
        $isImageFile = $this->isImageFile($fileName);
        if ($isImageFile) {
            $info = pathinfo($fileName);
            if (!empty($info['filename'])) {
                $fileName = $info['filename'] . '.webp';
            }
        }
        return $fileName;
    }

    public function fileUploadDigitalOcen($file, $dir_name = self::CLIENT_IMAGES_DIR_NAME)
    {
        $path = $this->getModulePublicFilesDirName($dir_name);
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid() . '.' . $extension;
        $path .= '/' . $fileName;
        $uploadedFilePath = \Illuminate\Support\Facades\Storage::disk('spaces')->put($path, $file);
        return $fileName;
    }

    public function removeFileDigitalOcen($filePath)
    {

        // if (!file_exists($serverImageUrl)) {
        $uploadedFilePath = \Illuminate\Support\Facades\Storage::disk('spaces')->delete($filePath);
        // }
        return $uploadedFilePath;
    }

    public function addHttps($url)
    {
        if (!preg_match('~^(?:f|ht)tps?://~i', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }

    public function getFilesDirectory($files_type = 'images', $subdir = '')
    {
        $module_dir_name = '';
        if ($files_type !== 'favicon') {
            $module_dir_name = $this->getModulePublicFilesDirName();
        }
        $baseDir = $this->getClientFilesModuleBaseDir($files_type, $subdir);
        $baseDir = $baseDir . $module_dir_name;
        if ($files_type == 'import_result') {
            $baseDir = $baseDir . '/result';
        }
        if ($files_type == 'import' || $files_type == 'export' || $files_type == 'import_result') {
            if (!is_dir(public_path($baseDir))) {
                mkdir(public_path($baseDir), 0755, true);
            }
        }
        return $baseDir;
    }

    public function getClientFilesModuleBaseDir($files_type = 'images', $subdir = '')
    {
        $client_domain = env('DO_BASE_FOLDER_NAME');

        $storageRoot = 'storage';
        if ($files_type == 'images') {
            $dir_name = self::CLIENT_IMAGES_DIR_NAME;
        } elseif ($files_type == 'videos') {
            $dir_name = self::CLIENT_VIDEOS_DIR_NAME;
        } elseif ($files_type == 'docs') {
            $dir_name = self::CLIENT_DOCS_DIR_NAME;
        } elseif ($files_type == 'wyswyg') {
            $dir_name = self::CLIENT_WYSWYG_DIR_NAME;
        } elseif ($files_type == 'schedule') {
            $dir_name = self::CLIENT_SHCHEDULE_DIR_NAME;
        } elseif ($files_type == 'export') {
            $dir_name = self::CLIENT_EXPORT_DIR_NAME;
            $storageRoot = '';
        } elseif ($files_type == 'import' || $files_type == 'import_result') {
            $dir_name = self::CLIENT_IMPORT_DIR_NAME;
            $storageRoot = '';
        } elseif ($files_type == 'favicon') {
            $dir_name = self::CLIENT_FAVICON_DIR_NAME;
        }

        $baseDir = $client_domain . '/' . $dir_name . '/';

        if ($subdir) {
            $baseDir = $baseDir . $subdir . '/';
        }

        if ($storageRoot) {
            $storageDir = $storageRoot . '/' . $baseDir;
        } else {
            $storageDir = $baseDir;
        }

        if (!is_dir(public_path($storageDir))) {
            mkdir(public_path($storageDir), 0755, true);
        }
        return $baseDir;
    }

    public function dayFormat($day)
    {
        if ($day == "Monday") {
            return '1';
        } elseif ($day == "Tuesday") {
            return '2';
        } elseif ($day == "Wednesday") {
            return '3';
        } elseif ($day == "Thursday") {
            return '4';
        } elseif ($day == "Friday") {
            return '5';
        } elseif ($day == "Saturday") {
            return '6';
        } elseif ($day == "Sunday") {
            return '7';
        }
    }

    public function dateFormat($date, $date_formate)
    {
        if ($date != '' && strtotime($date)) {
            try {
                $parsed = date_parse($date);
                if ($parsed['error_count'] == 0 && ($parsed['warning_count'] == 0 || !in_array('The parsed date was invalid', $parsed['warnings']))) {
                    if ($date_formate == 'formate-1') {
                        return \Carbon\Carbon::parse($date)->format('d, F Y'); //20,December 2017
                    }
                    if ($date_formate == 'formate-2') {
                        return \Carbon\Carbon::parse($date)->format('d/m/Y h:i:s A'); //  19/05/2018 12:44:11 PM
                    }
                    if ($date_formate == 'formate-3') {
                        return \Carbon\Carbon::parse($date)->format('m/d/Y h:i:s A'); //  9/28/2017 7:18:39 AM
                    }
                    if ($date_formate == 'formate-4') {
                        return \Carbon\Carbon::parse($date)->format('m/d/Y'); //  9/30/2014
                    }
                    if ($date_formate == 'formate-5') {
                        return \Carbon\Carbon::parse($date)->format('Y-m-d'); //  9/30/2014
                    }
                    if ($date_formate == 'formate-6') {
                        return \Carbon\Carbon::parse($date)->format('m/d'); //  9/30/2014
                    }
                    if ($date_formate == 'formate-7') {
                        return \Carbon\Carbon::parse($date)->format('m-d-Y');
                    }
                    if ($date_formate == 'formate-8') {
                        return \Carbon\Carbon::parse($date)->format('Y-m-d G:i:s'); //  9/28/2017 7:18:39 AM
                    }
                    if ($date_formate == 'formate-9') {
                        return \Carbon\Carbon::parse($date)->format('l - F d, Y'); //  Friday - February 8, 2019
                    }
                    if ($date_formate == 'formate-10') {
                        return \Carbon\Carbon::parse($date)->format('h:i A'); //  08:10 AM
                    }
                    if ($date_formate == 'formate-11') {
                        return \Carbon\Carbon::parse($date)->format('m/d h:i A'); //  2/8 10:10 PM
                    }
                    if ($date_formate == 'formate-12') {
                        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s'); //  2/8 10:10 PM
                    }
                    if ($date_formate == 'formate-13') {
                        return \Carbon\Carbon::parse($date)->format('l, F d, Y'); //  Friday, February 8, 2019
                    }
                    if ($date_formate == 'formate-14') {
                        return \Carbon\Carbon::parse($date)->format('H:i'); //  08:10 AM
                    }
                    if ($date_formate == 'formate-15') {
                        return \Carbon\Carbon::parse($date)->format('D, m/d h:i A'); //  Friday, February 8, 2019
                    }
                    if ($date_formate == 'formate-16') {
                        return \Carbon\Carbon::parse($date)->format('D, m/d/Y'); //  Fri, 05/22/2019
                    }
                    if ($date_formate == 'formate-17') {
                        return \Carbon\Carbon::parse($date)->format('m/d/Y h:i A'); //  9/28/2017 7:18:39 AM
                    }
                    if ($date_formate == 'formate-18') {
                        return \Carbon\Carbon::parse($date)->format('F d, Y'); //  9/28/2017 7:18:39 AM
                    }
                    if ($date_formate == 'formate-19') {
                        return \Carbon\Carbon::parse($date)->format('F d, Y'); //  9/28/2017 7:18:39 AM
                    }
                    if ($date_formate == 'formate-20') {
                        return \Carbon\Carbon::parse($date)->format('m/d/y'); //  9/30/22
                    }
                    if ($date_formate == 'formate-21') {
                        return \Carbon\Carbon::parse($date)->format('M'); //  Jan
                    }
                    if ($date_formate == 'formate-22') {
                        return \Carbon\Carbon::parse($date)->format('d'); //  9
                    }
                    if ($date_formate == 'formate-23') {
                        return \Carbon\Carbon::parse($date)->format('M d'); //  9
                    }
                    if ($date_formate == 'formate-24') {
                        return \Carbon\Carbon::parse($date)->format('d, Y'); //  9
                    }
                }

                return $date;
            } catch (\Exception $e) {
                return $date;
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                return $date;
            }
        }

        return $date;
    }

    public function convertSlot($startTime, $endTime, $duration)
    {
        $cleanup = 0;
        $start = new \DateTime($startTime);
        $end = new \DateTime($endTime);
        $interval = new \DateInterval("PT" . $duration . "M");
        $cleanupInterval = new \DateInterval("PT" . $cleanup . "M");
        $periods = array();

        for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
            $endPeriod = clone $intStart;
            $endPeriod->add($interval);

            if ($endPeriod > $end) {
                break;
            }

            $periods[] = $intStart->format('h:i A');
        }


        return $periods;

    }

    public function getShortContent($content, $length = 100)
    {
        $content = strip_tags($content);
        if (strlen($content) > $length) {
            $content = substr($content, 0, $length);
        }
        return $content;
    }

    public function getDarkLogoUrl()
    {
        return asset('assets/media/logos/logo.png');
    }

    public function getLightLogoUrl()
    {
        return asset('assets/media/logos/logo.png');
    }

    function strLimit($title = null, $length = 100)
    {
        return Str::limit($title, $length);
    }

    function gs()
    {
        $general = GeneralSetting::first();
        return $general;
    }

    function default_country_code()
    {
        $general = $this->gs();
        if (!empty($general)) {
            $country_code = $general->country_code;
        }
        return strtolower($country_code);
    }

    function default_country_phonecode()
    {
        $general = $this->gs();
        if (!empty($general)) {
            $country_code = $general->country_code;
            $countryDetails = DB::table('country')->where('code', $country_code)->first();
        }
        return !empty($countryDetails) ? $countryDetails->phonecode : '';
    }

    function profileLogo()
    {
        $profileLogo = Auth::user()->avatar;
        if (!empty($profileLogo)) {
            $logo = asset('uploads/images/user/' . $profileLogo);
        } else {
            $logo = asset('assets/media/users/default.jpg');
        }
        return $logo;
    }

    function siteLogo()
    {
        $general = $this->gs();
        if (!empty($general->site_logo)) {
            $logo = asset('uploads/images/general_setting/' . $general->site_logo);
        } else {
            $logo = asset('assets/media/logos/light-logo-horizontal.png');
        }
        return $logo;
    }

    function siteDarkLogo()
    {
        $general = $this->gs();
        if (!empty($general->site_logo_dark)) {
            $logo = asset('uploads/images/general_setting/' . $general->site_logo_dark);
        } else {
            $logo = asset('assets/media/logos/logo-dark.png');
        }
        return $logo;
    }


    function twilio($phoneNo, $countryCode, $message)
    {
        $gs = $this->gs();
        $accountSid = !empty($gs->account_sid) ? $gs->account_sid : "";
        $authToken = !empty($gs->auth_token) ? $gs->auth_token : "";
        $formNumber = !empty($gs->from_number) ? $gs->from_number : "";
        if (!empty($accountSid) && !empty($authToken) && !empty($formNumber)) {
            $client = new Client($accountSid, $authToken);
            try {
                $client->messages->create(
                    "+" . $countryCode . $phoneNo,
                    array(
                        'from' => $formNumber,
                        'body' => $message,
                    )
                );
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    function setWebhookUrl($url)
    {
        $gs = $this->gs();
        $stripe = new \Stripe\StripeClient($gs->stripe_secret_key);
        $webhookKey = !empty($gs) ? $gs->stripe_webhook_key : '';
        $checkUrlExit = $stripe->webhookEndpoints->retrieve($webhookKey);
        if (!empty($checkUrlExit)) {
            $stripe->webhookEndpoints->update($checkUrlExit->id, ['url' => $url]);
        } else {
            $stripe->webhookEndpoints->create(['url' => $url]);
        }
    }

    function createdBy($userId)
    {
        $user = User::select('first_name', 'last_name')->where('id', $userId)->first();
        $providerName = !empty($user) ? $user->first_name . " " . $user->last_name : "";
        return $providerName;
    }

    function getAppointmentTemplate($patientName, $timeSlot)
    {
        $gs = $this->gs();
        $template = !empty($gs) ? $gs->appointment_template : "";
        if (!empty($template)) {
            $message = $this->replaceShortCode($template, $patientName, $timeSlot);
            return $message;
        }
    }

    function getSMSMessage($patientName, $timeSlot)
    {
        $gs = $this->gs();
        $template = !empty($gs) ? $gs->sms_template : "";
        if (!empty($template)) {
            $message = $this->replaceShortCode($template, $patientName, $timeSlot);
            return $message;
        }
    }

    function replaceShortCode($template, $patientName, $timeSlot)
    {
        $message = str_replace("{{patients_name}}", $patientName, $template);
        $message = str_replace("{{time_slot}}", $timeSlot, $message);
        return $message;
    }

    function getStripeProductDetails($product)
    {
        if (!empty($product)) {
            foreach ($product as $item) {
                $currency = strtoupper($item->currency);
                $unitAmount = new Money($item->unit_amount, new Currency($currency));
                $quantity = !empty($item->qty) ? $item->qty : "";
                $totalAmount = new Money($item->unit_amount * $quantity, new Currency($currency));;
                $productArray[] = [
                    'product_name' => !empty($item->product_name) ? $item->product_name : "",
                    'description' => !empty($item->description) ? $item->description : "",
                    'currency' => $currency,
                    'unit_cost' => $unitAmount,
                    'quantity' => $quantity,
                    'total' => $totalAmount,
                    'sub_total' => $item->unit_amount,
                    'discount_amount' => $item->discount,
                ];
            }

            return $productArray;
        }

    }

    function changeTimeZone($dateString, $timeZoneSource = null, $timeZoneTarget = null)
    {
        if (empty($timeZoneSource)) {
            $timeZoneSource = date_default_timezone_get();
        }
        if (empty($timeZoneTarget)) {
            $timeZoneTarget = date_default_timezone_get();
        }

        $dt = new \DateTime($dateString, new \DateTimeZone($timeZoneSource));
        $dt->setTimezone(new \DateTimeZone($timeZoneTarget));

        return $dt->format("Y-m-d H:i:s");
    }

    function notify($user, $templateName, $shortCodes = null, $sendVia = null, $createLog = true)
    {
        $globalShortCodes = [
            'site_name' => 'RiseWell',
        ];

        if (gettype($user) == 'array') {
            $user = (object)$user;
        }

        $shortCodes = array_merge($shortCodes ?? [], $globalShortCodes);

        $notify = new \App\Notify\Notify($sendVia);
        $notify->shortCodes = $shortCodes;
        $notify->templateName = $templateName;
        $notify->user = $user;
        $notify->createLog = $createLog;
        $notify->userColumn = isset($user->id) ? $user->getForeignKey() : 'user_id';
        $notify->send();
    }

    public function getManageSectionConfigValueByKey($key)
    {
        $manager_section_setting = ManageSection::where('name', $key)->first();
        if ($manager_section_setting !== null) {
            return $manager_section_setting->value;
        }
        return '';
    }

    public function getFrontendTopPhoneNo()
    {
        $phoneNo = $this->getManageSectionConfigValueByKey('phone_no');
        $phoneNo = trim($phoneNo);
        if ($phoneNo == '') {
            $phoneNo = '0000000000';
        }
        return $phoneNo;
    }

    public function getPrivacyPolicyUrl()
    {
        $privacy_policy = $this->getManageSectionConfigValueByKey('privacy_policy');
        $privacy_policy = trim($privacy_policy);
        if ($privacy_policy == '') {
            $privacy_policy = '#';
        }
        return $privacy_policy;
    }

    public function getRefundPolicyUrl()
    {
        $refund_policy = $this->getManageSectionConfigValueByKey('refund_policy');
        $refund_policy = trim($refund_policy);
        if ($refund_policy == '') {
            $refund_policy = '#';
        }
        return $refund_policy;
    }

    public function getBlogUrl()
    {
        $blog_url = $this->getManageSectionConfigValueByKey('blog_url');
        $blog_url = trim($blog_url);
        if ($blog_url == '') {
            $blog_url = '#';
        }
        return $blog_url;
    }

    public function getAboutUsUrl()
    {
        $about_us_url = $this->getManageSectionConfigValueByKey('about_us_url');
        $about_us_url = trim($about_us_url);
        if ($about_us_url == '') {
            $about_us_url = '#';
        }
        return $about_us_url;
    }

    public function getContactUsUrl()
    {
        $contact_us_url = $this->getManageSectionConfigValueByKey('contact_us_url');
        $contact_us_url = trim($contact_us_url);
        if ($contact_us_url == '') {
            $contact_us_url = '#';
        }
        return $contact_us_url;
    }

    public function getTermsAndConditionsUrl()
    {
        $terms_and_conditions = $this->getManageSectionConfigValueByKey('terms_and_conditions');
        $terms_and_conditions = trim($terms_and_conditions);
        if ($terms_and_conditions == '') {
            $terms_and_conditions = '#';
        }
        return $terms_and_conditions;
    }

    public function getConsentToTreatUrl()
    {
        $consent_to_treat = $this->getManageSectionConfigValueByKey('consent_to_treat');
        $consent_to_treat = trim($consent_to_treat);
        if ($consent_to_treat == '') {
            $consent_to_treat = '#';
        }
        return $consent_to_treat;
    }

    public function getStartedTitle($productName)
    {

        $title_one = $this->getManageSectionConfigValueByKey('title_one');
        $title_one = trim($title_one);
        if (!empty($productName)) {
            $title_one = str_replace("{{product_name}}", $productName, $title_one);
        } else {
            $title_one = str_replace("{{product_name}}", 'Test Product', $title_one);
        }
        return $title_one;

    }

    public function getNotificationTemplate($name)
    {
        return DB::table('notification_template')->where('name', $name)->first();
    }

    public function sendSMSNotification($phoneNo, $status = '')
    {

    }


    public function sendMailNotification($email, $status = '')
    {
        $response['status'] = false;
        $response['message'] = '';


        $gs = $this->gs();
        $config = $gs->mail_config;

        if (!empty($config)) {
            $receiverName = explode('@', $email)[0];
            $template = $this->getNotificationTemplate($status);
            $message = 'Your Order Is ' . $status;
            $subject = $template->subj;
            $details = [
                'username' => $email,
                'email' => $email,
                'fullname' => $receiverName,
            ];
            $this->notify($details, $status, [
                'subject' => $subject,
                'message' => $message,
            ], ['email']);
        } else {
            $response['status'] = false;
            $response['message'] = 'Email Configuration Setting is required !!';
        }

        if (session('mail_error')) {
            $response['status'] = false;
            $response['message'] = session('mail_error');
        }

        return $response;

    }


}


