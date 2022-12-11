<?php

namespace App\Services\Providers;

use App\Interfaces\CarrierInterface;

class IMobile implements CarrierInterface
{
    public function dialContact(Contact $contact)
    {
        //dialContact for TMobile
    }

    public function makeCall()
    {
        //make a call for TMobile
    }

    public function sendSms(string $number, string $body)
    {
        //send sms for TMobile
    }
}