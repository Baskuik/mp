<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Subscription;

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

        switch ($event->type) {

            // First-time subscription payment succeeded → activate premium
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                if ($invoice->billing_reason === 'subscription_create') {
                    $subscriptionId = $invoice->subscription;
                    User::where('stripe_subscription_id', $subscriptionId)
                        ->where('is_premium', false)
                        ->update(['is_premium' => true]);
                    Log::info("Premium activated via webhook for subscription {$subscriptionId}.");
                }
                break;

            // Renewal payment failed → cancel subscription and revoke premium
            case 'invoice.payment_failed':
                $invoice        = $event->data->object;
                $subscriptionId = $invoice->subscription;

                if ($subscriptionId) {
                    try {
                        $subscription = Subscription::retrieve($subscriptionId);
                        if (in_array($subscription->status, ['active', 'trialing', 'past_due'])) {
                            $subscription->cancel();
                        }
                    } catch (\Exception $e) {
                        Log::warning("Could not cancel subscription {$subscriptionId}: " . $e->getMessage());
                    }

                    User::where('stripe_subscription_id', $subscriptionId)
                        ->update([
                            'is_premium'             => false,
                            'stripe_subscription_id' => null,
                        ]);

                    Log::info("Premium revoked due to failed payment for subscription {$subscriptionId}.");
                }
                break;

            // Subscription cancelled/deleted (e.g. via Stripe dashboard or cancel())
            case 'customer.subscription.deleted':
                $subscription   = $event->data->object;
                $subscriptionId = $subscription->id;

                User::where('stripe_subscription_id', $subscriptionId)
                    ->update([
                        'is_premium'             => false,
                        'stripe_subscription_id' => null,
                    ]);

                Log::info("Premium revoked via subscription.deleted webhook for {$subscriptionId}.");
                break;
        }

        return response('OK', 200);
    }
}