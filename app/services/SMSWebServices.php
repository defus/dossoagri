<?php

class SMSWebServices extends Playsms\Webservices {
	public $url = 'http://41.138.57.242:8001/itechsmsdev/index.php?app=ws';
	public $username = 'dossoagri';
	public $password = 'dossoagripass';
	public $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	}
	
	public function sendmsg($to, $msg) {

		$this->getToken();
		
		if ($this->getStatus()) {
		
			$this->token = $this->getData()->token;
			$this->to = $to;
			$this->msg = $msg;
			$this->sendSms();
			
			return array(
					'status' => $this->getStatus(),
					'return' => $this->getData()
			);
		
		} else {
			return array(
					'status' => false,
					'return' => array (
										'errorCode' => $this->getError(),
										'errorString' => $this->getErrorString()
								)
					);
		}
	}

}

