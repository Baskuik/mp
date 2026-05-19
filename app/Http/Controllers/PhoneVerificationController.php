<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class PhoneVerificationController extends Controller
{
    public function __construct(protected TwilioService $twilio)
    {
    }

    // Stap 1: Telefoonnummer opslaan & code versturen
    // Stap 1: verstuur code
    public function send(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^\+[1-9]\d{7,14}$/'],
        ], [
            'phone_number.regex' => 'Gebruik internationaal formaat, bijv. +31612345678',
        ]);

        $user = Auth::user();

        $key = 'phone-verify:' . $user->getKey();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'phone_number' => "Te veel pogingen. Probeer het over {$seconds} seconden opnieuw.",
            ]);
        }
        RateLimiter::hit($key, 600);

        try {
            $this->twilio->sendVerificationCode($request->phone_number);
        } catch (\Exception $e) {
            Log::error('SMS verification error', ['exception' => $e]);
            return back()->withErrors(['phone_number' => 'SMS verzenden mislukt, probeer later opnieuw.']);
        }

        $user->update([
            'phone_number' => $request->phone_number,
            'phone_verified' => false,
            'phone_verification_sent_at' => now(),
        ]);

        return back()->with('status', 'sms_sent');
    }

    // Stap 2: controleer code
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = Auth::user();

        if (!$user->phone_number) {
            return back()->withErrors(['code' => 'Geen telefoonnummer gevonden voor verificatie.']);
        }

        $key = 'phone-verify-code:' . $user->getKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['code' => "Te veel pogingen. Probeer opnieuw over {$seconds} seconden."]);
        }
        RateLimiter::hit($key, 600);

        try {
            $valid = $this->twilio->checkVerificationCode($user->phone_number, $request->code);
        } catch (\Exception $e) {
            Log::error('SMS verification check error', ['exception' => $e]);
            return back()->withErrors(['code' => 'Verificatie mislukt, probeer later opnieuw.']);
        }

        if (!$valid) {
            return back()->withErrors(['code' => 'Ongeldige verificatiecode.']);
        }

        RateLimiter::clear($key);

        $user->update([
            'phone_verified' => true,
            'phone_verification_code' => null,
        ]);

        return back()->with('status', 'phone_verified');
    }
}
