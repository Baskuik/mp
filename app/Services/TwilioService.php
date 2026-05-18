<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected ?Client $client;
    protected string $verifySid;
    protected array $mockCodes = []; // Voor mock mode

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        // Mock mode: detecteer placeholder credentials
        $hasValidCredentials = $sid && $token &&
            !str_contains($sid, 'your_') &&
            !str_contains($token, 'your_');

        if ($hasValidCredentials) {
            $this->client = new Client($sid, $token);
            Log::debug("Twilio: Real credentials detected, using actual API");
        } else {
            $this->client = null;
            Log::debug("Twilio: Mock mode enabled (placeholder credentials)");
        }

        $this->verifySid = config('services.twilio.verify_sid') ?? '';
    }

    public function sendVerificationCode(string $phoneNumber): void
    {
        if (!$this->client) {
            // Mock mode: genereer code en log het
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $this->mockCodes[$phoneNumber] = $code;
            Log::info("[MOCK SMS] Verificatiecode naar $phoneNumber: $code");
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
            // Mock mode: check tegen opgeslagen code
            $isValid = isset($this->mockCodes[$phoneNumber]) &&
                $this->mockCodes[$phoneNumber] === $code;
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