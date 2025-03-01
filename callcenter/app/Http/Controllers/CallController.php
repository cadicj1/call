<?php

namespace App\Http\Controllers;

use App\Http\Services\TwilioService;
use Illuminate\Http\Request;
use App\Models\Call;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use Twilio\Rest\Client;



class CallController extends Controller
{
    private TwilioService $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }
    public function index()
    {
        $calls = Call::with('agent')
            ->latest()
            ->paginate(10);

        return Inertia::render('Calls/Dashboard', [
            'calls' => $calls
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'caller_number' => 'required|string',
            'call_type' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $call = Call::create([
            ...$validated,
            'agent_id' => auth()->id(),
            'status' => 'in-progress'
        ]);

        return redirect()->back()->with('success', 'Call logged successfully');
    }
    public function sendMessage(Request $request)
    {

            $valdate = $request->validate([
                'phone_number' => 'required|string',
                'message' => 'required|string'
            ]);

            return $message = $this->twilioService->sendMessage($valdate['phone_number'], $valdate['message']);


    }
    public function test(){
       $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
            '+358417455724',
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => 'kingpinngg'
            ]
        );

    }

    public function initiateCall(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'message' => 'required|string'
        ]);

        $call = $this->twilioService->makeCall($validated['phone_number'], $validated['message']);

        if ($call['success']) {
            $call = Call::create([
                'caller_number' => $validated['phone_number'],
                'agent_id' => auth()->id(),
                'status' => 'in-progress',
                'call_type' => 'outgoing',
                'notes' => $validated['message'],
                'started_at' => now(),
            ]);
            return back()->with('success', 'Call initiated successfully');
        }

        return back()->with('error', 'Call unsuccessfully');

    }



    public function update(Request $request, Call $call)
    {
        $validated = $request->validate([
            'status' => 'required|in:queued,in-progress,completed,missed',
            'notes' => 'nullable|string',
            'duration' => 'nullable|integer'
        ]);

        $call->update($validated);

        return redirect()->back()->with('success', 'Call updated successfully');
    }
}
