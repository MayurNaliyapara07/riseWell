<?php

namespace App\Notify;

use App\Helpers\BaseHelper;

class Notify
{
	public $templateName;

	public $shortCodes;

	public $sendVia;

	public $user;

	public $createLog;

	public $setting;

	public $userColumn;

	public function __construct($sendVia = null)
	{
        $this->helper = new BaseHelper();
		$this->sendVia = $sendVia;
		$this->setting = $this->helper->gs();
	}

	public function send(){

        $methods = [];

        //get the notification method classes which are selected

        if($this->sendVia){
            foreach ($this->sendVia as $sendVia) {
                $methods[$sendVia] = $this->notifyMethods($sendVia);
            }
        }else{
            $methods = $this->notifyMethods();
        }



        //send the notification via methods one by one
        foreach($methods as $method){

            echo "<pre>";
            print_r($this->templateName);exit();

            $notify = new $method;
            $notify->templateName = $this->templateName;
            $notify->shortCodes = $this->shortCodes;
            $notify->user = $this->user;
            $notify->setting = $this->setting;
            $notify->createLog = $this->createLog;
            $notify->userColumn = $this->userColumn;
            $notify->send();
        }
	}

	protected function notifyMethods($sendVia = null){
        $methods = [
            'email'=>Email::class,
            'sms'=>Sms::class
        ];
        if ($sendVia) {
            return $methods[$sendVia];
        }
        return $methods;
	}
}
