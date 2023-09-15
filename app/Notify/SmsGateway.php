<?php

namespace App\Notify;

use App\Lib\CurlRequest;
use MessageBird\Client as MessageBirdClient;
use MessageBird\Objects\Message;
use Textmagic\Services\TextmagicRestClient;
use Twilio\Rest\Client;
use Vonage\Client as NexmoClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsGateway{

    /**
     * the number where the sms will send
     *
     * @var string
     */
    public $to;

    /**
     * the name where from the sms will send
     *
     * @var string
     */
    public $from;


    /**
     * the message which will be send
     *
     * @var string
     */
    public $message;


    /**
     * the configuration of sms gateway
     *
     * @var object
     */
    public $config;

	public function clickatell()
	{
		$message = urlencode($this->message);
		$api_key = $this->config->api_key;
		@file_get_contents("https://platform.clickatell.com/messages/http/send?apiKey=$api_key&to=$this->to&content=$message");
	}

	public function infobip(){
		$message = urlencode($this->message);
		@file_get_contents("https://api.infobip.com/api/v3/sendsms/plain?user=".$this->config->username."&password=".$this->config->password."&sender=$this->from&SMSText=$message&GSM=$this->to&type=longSMS");
	}

	public function messageBird(){
		$MessageBird = new MessageBirdClient($this->config->api_key);
	  	$Message = new Message();
	  	$Message->originator = $this->from;
	  	$Message->recipients = array($this->to);
	  	$Message->body = $this->message;
	  	$MessageBird->messages->create($Message);
	}

	public function nexmo(){
		$basic  = new Basic($this->config->api_key, $this->config->api_secret);
		$client = new NexmoClient($basic);
		$response = $client->sms()->send(
		    new SMS($this->to, $this->from, $this->message)
		);
		 $response->current();
	}

	public function smsBroadcast(){
		$message = urlencode($this->message);
		@file_get_contents("https://api.smsbroadcast.com.au/api-adv.php?username=".$this->config->username."&password=".$this->config->password."&to=$this->to&from=$this->fromName&message=$message&ref=112233&maxsplit=5&delay=15");
	}

	public function twilio(){
		$account_sid = $this->config->account_sid;
		$auth_token = $this->config->auth_token;
		$twilio_number = $this->config->from_number;
		$client = new Client($account_sid, $auth_token);
		$client->messages->create(
		    '+'.$this->to,
		    array(
		        'from' => $twilio_number,
		        'body' => $this->message
		    )
		);
	}

	public function textMagic(){
        $client = new TextmagicRestClient($this->config->username, $this->config->apiv2_key);
        $client->messages->create(
            array(
                'text' => $this->message,
                'phones' => $this->to
            )
        );
	}

	public function custom(){
		$credential = $this->config->custom;
		$method = $credential->method;
		$shortCodes = [
			'{{message}}'=>$this->message,
			'{{number}}'=>$this->to,
		];
		$body = array_combine($credential->body->name,$credential->body->value);
		foreach ($body as $key => $value) {
			$bodyData = str_replace($value,@$shortCodes[$value] ?? $value ,$value);
			$body[$key] = $bodyData;
		}
		$header = array_combine($credential->headers->name,$credential->headers->value);
		if ($method == 'get') {
			$credential->url.'?'.http_build_query($body);
			CurlRequest::curlContent($credential->url,$body,$header);
		}else{
			CurlRequest::curlPostContent($credential->url,$body,$header);
		}
	}
}
