<?php

namespace App\Notify;
use App\Notify\NotifyProcess;
use App\Notify\Notifiable;
use Mailjet\Client;
use Mailjet\Resources;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use SendGrid;
use SendGrid\Mail\Mail;

class Email extends NotifyProcess implements Notifiable{

	public $email;

	public function __construct(){

		$this->statusField = 'email_status';

		$this->body = 'email_body';

		$this->globalTemplate = 'email_template';

		$this->notifyConfig = 'mail_config';
	}

	public function send(){


		$message = $this->getMessage();

        if ($this->setting && $message) {

            $methodName = 'smtp';

            $method = $this->mailMethods($methodName);

            try{

				$this->$method();

				$this->createLog('email');

            }catch(\Exception $e){

				session()->flash('mail_error',$e->getMessage());

            }
		}

	}

	protected function mailMethods($name){

        $methods = [
			'php'=>'sendPhpMail',
			'smtp'=>'sendSmtpMail',
			'sendgrid'=>'sendSendGridMail',
			'mailjet'=>'sendMailjetMail',
		];

        return $methods[$name];
	}

	protected function sendSmtpMail(){

		$mail = new PHPMailer(true);

        $config = $this->setting->mail_config;

        $general = $this->setting;

        if (!empty($config)){

            $mailDetails = json_decode($config);

            //Server settings

            $mail->isSMTP();

            $mail->Host       = $mailDetails->host;

            $mail->SMTPAuth   = true;

            $mail->Username   = $mailDetails->username;

            $mail->Password   = $mailDetails->password;

            if ($mailDetails->encryption == 'ssl') {

                $mail->SMTPSecure = 'ssl';

            }else{

                $mail->SMTPSecure = 'tls';

            }
            $mail->Port       = $mailDetails->port;

            $mail->CharSet = 'UTF-8';

            //Recipients

            $mail->setFrom($mailDetails->username, $general->site_title);

            $mail->addAddress($this->email, $this->receiverName);

            $mail->addReplyTo($mailDetails->username, $general->site_title);

            // Content

            $mail->isHTML(true);

            $mail->Subject = $this->subject;

            $mail->Body    = $this->finalMessage;

            $mail->send();
        }

	}

	public function prevConfiguration(){
		if ($this->user) {
			$this->email = $this->user->email;
			$this->receiverName = $this->user->fullname;
		}
		$this->toAddress = $this->email;
	}
}
