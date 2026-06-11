<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig     = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig, config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        match ($event->type) {
            'invoice.payment_failed'         => $this->handlePaymentFailed($event->data->object),
            'customer.subscription.deleted'  => $this->handleSubscriptionDeleted($event->data->object),
            'invoice.payment_succeeded'      => $this->handlePaymentSucceeded($event->data->object),
            default                          => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentFailed($invoice): void
    {
        $user = User::where('stripe_customer_id', $invoice->customer)->first();
        if ($user && $invoice->attempt_count >= 3) {
            $user->update([
                'is_premium'             => false,
                'stripe_subscription_id' => null,
                'premium_expires_at'     => null,
            ]);
        }
    }

    private function handleSubscriptionDeleted($subscription): void
    {
        User::where('stripe_subscription_id', $subscription->id)
            ->update([
                'is_premium'             => false,
                'stripe_subscription_id' => null,
                'premium_expires_at'     => null,
            ]);
    }

    private function handlePaymentSucceeded($invoice): void
    {
        // Verleng premium_expires_at bij elke succesvolle maandelijkse betaling
        $user = User::where('stripe_customer_id', $invoice->customer)->first();
        if ($user && $user->stripe_subscription_id) {
            $user->update([
                'is_premium'         => true,
                'premium_expires_at' => now()->addMonth(),
            ]);
        }
    }
}