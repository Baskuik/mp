<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            Log::warning('Stripe webhook signature invalid: ' . $e->getMessage());
            return response('Invalid signature', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $userId = $intent->metadata->user_id ?? null;

            if ($userId) {
                User::where('id', $userId)
                    ->where('is_premium', false)
                    ->update(['is_premium' => true]);

                Log::info("User {$userId} upgraded to premium via webhook.");
            }
        }

        return response('OK', 200);
    }
}