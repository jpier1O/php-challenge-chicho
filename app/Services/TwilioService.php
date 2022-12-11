<?php

namespace App\Services;

use App\Contact;
use App\Sms;
use GuzzleHttp;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;


class TwilioService
{
	
	public static function sendSmsAction($number, $message)
	{
		$client = new Client(['base_uri' => "http://demo1469828.mockable.io/"
    ]);
        $response = $client->request('POST', 'send-sms', ['json' => ['number' => $number, 'message' => $message]]);

        $response = $response->getBody();
        $response = json_decode($response->getContents(), true);

        $sms = new SMS();
        $sms->code = $response['code'];
        $sms->details = $response['msg'];

        return $sms;
	}

}