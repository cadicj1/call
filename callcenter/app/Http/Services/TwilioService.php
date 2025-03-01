<?php

namespace App\Http\Services;
use Twilio\Rest\Client;
class TwilioService
{

    private $sid;
    private $token;
    private $twilio;

    public function __construct(){
        $this->twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    public function makeCall($to , $message){
        try {

            $call = $this->twilio->calls->create($to , env('TWILIO_PHONE_NUMBER'),[
                'twiml' => '<Response><Say>' . $message . '</Say></Response>'
            ]);

            return [
                'success' => true,
                'call_sid' => $call->sid
            ];
        }catch (\Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    public function sendMessage($to , $message){
        try{
            $message = $this->twilio->messages->create($to,[
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message
            ]);
            return [
                'success' => true,
                'message' => 'message sent succesfully from Service'
            ];
        }catch (\Exception $e){
           return $e->getMessage();
        }
    }

}
