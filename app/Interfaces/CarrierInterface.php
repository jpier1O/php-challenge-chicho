<?php

namespace App\Interfaces;

use App\Contact;
use App\Sms;
use App\Call;

interface CarrierInterface
{
	
	public function dialContact(Contact $contact);

	public function makeCall(): Call;

  public function sendSms(string $number, string $body): Sms;

}