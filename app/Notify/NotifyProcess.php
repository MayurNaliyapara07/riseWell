<?php

namespace App\Notify;

use App\Constants\Status;
use App\Helpers\BaseHelper;
use App\Models\AdminNotification;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;

class NotifyProcess{


    public $templateName;

    public $shortCodes;

    public $user;

    public $setting;

    protected $statusField;

    protected $globalTemplate;

    protected $body;

    public $template;

    public $message;

    public $createLog;

    public $notifyConfig;

    public $subject;

    public $receiverName;

    public $userColumn;

    protected $toAddress;

    protected $finalMessage;

    protected function getMessage(){

        $this->prevConfiguration();

        $this->setSetting();

        $body = $this->body;

        $user = $this->user;

        $globalTemplate = $this->globalTemplate;

        //finding the notification template

        $template = NotificationTemplate::where('act', $this->templateName)->where($this->statusField, 1)->first();

        $this->template = $template;

        //Getting the notification message from database if use and template exist

        //If not exist, get the message which have sent via method

        if ($user && $template) {

            $message = $this->replaceShortCode($user->fullname,$user->username,$this->setting->$globalTemplate,$template->$body);

            if (empty($message)) {

                $message = $template->$body;

            }

        }else{

            $message = $this->replaceShortCode($this->receiverName,$this->toAddress,$this->setting->$globalTemplate,$this->message);

        }

        //replace the all short cod of template
        if ($this->shortCodes) {

            foreach ($this->shortCodes as $code => $value) {

                $message = str_replace('{{' . $code . '}}', $value, $message);

            }

        }

        //Check email enable
        if (!$this->template && $this->templateName) return false;

        //set subject to property
        $this->getSubject();

        $this->finalMessage = $message;

        //return the final message
        return $message;
    }

    protected function replaceShortCode($name,$username,$template,$body){

        $message = str_replace("{{fullname}}", $name, $template);

        $message = str_replace("{{username}}", $username, $message);

        $message = str_replace("{{message}}", $body, $message);

        return $message;
    }

    protected function getSubject(){

        if ($this->template) {

            $subject = $this->template->subj;

            if ($this->shortCodes) {

                foreach ($this->shortCodes as $code => $value) {

                    $subject = str_replace('{{' . $code . '}}', $value, $subject);

                }

            }

            $this->subject = $subject;

        }
    }

    protected function setSetting(){
        if (!$this->setting) {
            $helper = new BaseHelper();
            $this->setting = $helper->gs();
        }
    }

    public function createLog($type){
        $userColumn = $this->userColumn;
        if ($this->user && $this->createLog) {
            $notifyConfig = $this->notifyConfig;
            $config = $this->setting->$notifyConfig;
            $notificationLog = new NotificationLog();
            if (@$this->user->id) {
                $notificationLog->$userColumn = $this->user->id;
            }
            $notificationLog->notification_type = $type;
            $notificationLog->sender = @$config->name;
            $notificationLog->sent_from = $this->setting->email_from;
            $notificationLog->sent_to = $this->toAddress;
            $notificationLog->subject = $this->subject;
            $notificationLog->message = $type == 'email' ? $this->finalMessage : strip_tags($this->finalMessage);
            $notificationLog->save();
        }
    }

}
