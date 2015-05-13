<?php

include '../vendor/playsms/webservices/src/Playsms/Webservices.php';

class SMSWebServices extends Playsms\Webservices {
	public $url = 'http://41.138.57.242:8001/itechsmsdev/index.php?app=ws';
	public $username = 'dossoagri';
	public $password = 'dossoagripass';

}


$ws = new SMSWebServices();


$ws->getToken();

if ($ws->getStatus()) {

	$ws->token = $ws->getData()->token;
	$ws->to = '93339999';
	$ws->msg = 'This is a test from webservices ' . time();
	$ws->sendSms();
	print_r($ws->getData());

} else {
	echo "Error code: " . $ws->getError() . "\n";
	echo "Error string: " . $ws->getErrorString() . "\n";
}

