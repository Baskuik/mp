// app/Services/TwilioService.php
<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;
    protected string $verifySid;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        $this->verifySid = config('services.twilio.verify_sid');
    }

    public function sendVerificationCode(string $phoneNumber): void
    {
        $this->client->verify->v2->services($this->verifySid)
            ->verifications
            ->create($phoneNumber, 'sms');
    }

    public function checkVerificationCode(string $phoneNumber, string $code): bool
    {
        $result = $this->client->verify->v2->services($this->verifySid)
            ->verificationChecks
            ->create(['to' => $phoneNumber, 'code' => $code]);

        return $result->status === 'approved';
    }
}