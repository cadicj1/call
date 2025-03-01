<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CallController;
use App\Http\Middleware\TwilioWebhookMiddleware;

Route::get('/test', [CallController::class, 'test'])->name('test');
Route::middleware(['auth'])->group(function () {
    Route::get('/calls', [CallController::class, 'index'])->name('index.index');
    Route::post('/calls', [CallController::class, 'store'])->name('index.store');
    Route::put('/calls/{call}', [CallController::class, 'update'])->name('index.update');

    Route::post('/calls/initiate', [CallController::class, 'initiateCall'])->name('calls.initiate');
    Route::post('/calls/message', [CallController::class, 'sendMessage'])->name('calls.message');

});


Route::middleware('twilio.webhook')->prefix('twilio')->group(function () {
    Route::post('/status', [CallController::class, 'handleStatus'])->name('calls.webhook.status');
    Route::post('/incoming', [TwilioWebhookController::class, 'handleIncomingCall'])->name('twilio.incoming');
    Route::post('/menu', [TwilioWebhookController::class, 'handleMenu'])->name('twilio.menu.handle');
    Route::post('/call-ended', [TwilioWebhookController::class, 'handleCallEnded'])->name('twilio.call.ended');
});


//Route::post('/calls/initiate', [CallController::class, 'initiateCall'])->withoutMiddleware('web');
//Route::post('/calls/message', [CallController::class, 'sendMessage'])->withoutMiddleware('web');
//Route::post('/calls/test', [CallController::class, 'test'])->withoutMiddleware('web');




Route::post('/test',function(){
    return 'tests';
})->withoutMiddleware('web');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
