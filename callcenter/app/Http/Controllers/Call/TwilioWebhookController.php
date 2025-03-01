<?php

namespace App\Http\Controllers\Call;

use App\Http\Controllers\Controller;
use App\Models\Call;
use Illuminate\Http\Request;

class TwilioWebhookController extends Controller
{
   public function handleStatus(Request $request){


       $callSID = $request->input('CallSid');
       $status = $request->input('CallStatus');
       $duration = $request->input('CallDuration');


       $call = Call::where('twilio_call_sid' , $callSID)->first();

       if ($call) {
           switch ($status) {
               case 'in-progress':
                   $call->status = 'in-progress';
                   $call->started_at = now();
                   break;
               case 'completed':
                   $call->status = 'completed';
                   $call->ended_at = now();
                   $call->duration = $duration;
                   break;
               case 'busy':
               case 'failed':
               case 'no-answer':
                   $call->status = 'missed';
                   $call->ended_at = now();
                   break;
           }
           $call->save();
       }
       return $call;
   }
}
