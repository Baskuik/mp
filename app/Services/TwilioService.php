<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TwilioService
{
    protected ?Client $client;
    protected string $verifySid;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $verifySid = config('services.twilio.verify_sid');

        // Mock mode: detecteer placeholder credentials
        $hasValidCredentials = $sid && $token && $verifySid &&
            !str_contains($sid, 'your_') &&
            !str_contains($token, 'your_') &&
            !str_contains($verifySid, 'your_');

        if ($hasValidCredentials) {
            $this->client = new Client($sid, $token);
            Log::debug("Twilio: Real credentials detected, using actual API");
        } else {
            $this->client = null;
            Log::debug("Twilio: Mock mode enabled (placeholder credentials)");
        }

        $this->verifySid = $verifySid ?? '';
    }

    public function sendVerificationCode(string $phoneNumber): void
    {
        if (!$this->client) {
            // Mock mode: genereer code en sla op in cache
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            Cache::put("phone:mock:otp:{$phoneNumber}", $code, now()->addMinutes(10));
            $maskedPhone = substr($phoneNumber, 0, -4) . '****';
            Log::info("[MOCK SMS] Verificatiecode verstuurd naar {$maskedPhone}");
            return;
        }

        // Real mode: gebruik Twilio Verify
        $this->client->verify->v2->services($this->verifySid)
            ->verifications
            ->create($phoneNumber, 'sms');
    }

    public function checkVerificationCode(string $phoneNumber, string $code): bool
    {
        if (!$this->client) {
            // Mock mode: check tegen opgeslagen code in cache
            $stored = (string) Cache::get("phone:mock:otp:{$phoneNumber}", '');
            $isValid = $stored !== '' && hash_equals($stored, $code);
            if ($isValid) {
                Cache::forget("phone:mock:otp:{$phoneNumber}");
            }
            Log::info("[MOCK] Code verificatie: " . ($isValid ? "geslaagd" : "gefaald"));
            return $isValid;
        }

        // Real mode: Twilio check
        $result = $this->client->verify->v2->services($this->verifySid)
            ->verificationChecks
            ->create(['to' => $phoneNumber, 'code' => $code]);

        return $result->status === 'approved';
    }
}