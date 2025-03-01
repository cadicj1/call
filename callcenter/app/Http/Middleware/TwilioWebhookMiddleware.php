<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Security\RequestValidator;

class TwilioWebhookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!app()->environment('local')){

            $validator = new RequestValidator(env('TWILIO_AUTH_TOKEN'));

            $signature = $request->header('X-Twilio-Signature');
            $url = $request->fullUrl();
            $params = $request->toArray();


            if (!$validator->validate($signature, $url, $params)) {
                return response('Invalid signature', 403);
            }
        }
        return $next($request);
    }
}
