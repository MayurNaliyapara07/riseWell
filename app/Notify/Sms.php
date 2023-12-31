<?php

namespace App\Notify;

use App\Notify\NotifyProcess;
use App\Notify\SmsGateway;
use App\Notify\Notifiable;


class Sms extends NotifyProcess implements Notifiable{

    /**
    * Mobile number of receiver
    *
    * @var string
    */
	public $mobile;

    /**
    * Assign value to properties
    *
    * @return void
    */
	public function __construct(){
		$this->statusField = 'status';
		$this->body = 'sms_body';
		$this->globalTemplate = 'sms_body';
		$this->notifyConfig = 'sms_config';
	}


    /**
    * Send notification
    *
    * @return void|bool
    */
	public function send(){

		//get message from parent
		$message = $this->getMessage();
		if ($this->setting->sms_config && $message) {
			try {
                $sms_config = json_decode($this->setting->sms_config);
				$gateway = $sms_config->name;
                if($this->mobile){
                    $sendSms = new SmsGateway();
                    $sendSms->to = $this->mobile;
                    $sendSms->from = $this->setting->sms_from;
                    $sendSms->message = strip_tags($message);
                    $sendSms->config = $sms_config;
                    $sendSms->$gateway();
                    $this->createLog('sms');
                }
			} catch (\Exception $e) {
				$this->createErrorLog('SMS Error: '.$e->getMessage());
				session()->flash('sms_error','API Error: '.$e->getMessage());
			}
		}

	}

    public function prevConfiguration(){

    }
}
