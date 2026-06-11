<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;

class PremiumController extends Controller
{
    public function index()
    {
        return view('premium.index');
    }

    public function checkout()
    {
        if (Auth::user()->is_premium) {
            return redirect()->route('premium.index');
        }
        return view('premium.checkout');
    }

    /**
     * Create (or retrieve) a Stripe Customer and start a Subscription.
     * Returns the clientSecret of the first invoice's PaymentIntent so
     * Stripe Elements can confirm the payment on the frontend.
     */
    public function subscribe(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        // Reuse or create a Stripe Customer
        if ($user->stripe_customer_id) {
            $customer = Customer::retrieve($user->stripe_customer_id);
        } else {
            $customer = Customer::create([
                'email'    => $user->email,
                'metadata' => ['user_id' => $user->user_id],
            ]);
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        // Create the subscription with an incomplete first payment
        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items'    => [['price' => config('services.stripe.price_id')]],
            'payment_behavior'       => 'default_incomplete',
            'payment_settings'       => ['save_default_payment_method' => 'on_subscription'],
            'expand'                 => ['latest_invoice.payment_intent'],
        ]);

        $user->update(['stripe_subscription_id' => $subscription->id]);

        return response()->json([
            'clientSecret'   => $subscription->latest_invoice->payment_intent->client_secret,
            'subscriptionId' => $subscription->id,
        ]);
    }

    /**
     * Called after Stripe redirects back following payment confirmation.
     * Verifies the subscription is active and marks the user as premium.
     */
    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        if (!$user->stripe_subscription_id) {
            return redirect()->route('premium.index')->with('error', 'Geen abonnement gevonden.');
        }

        $subscription = Subscription::retrieve($user->stripe_subscription_id);

        if (!in_array($subscription->status, ['active', 'trialing'])) {
            return redirect()->route('premium.index')
                ->with('error', 'Betaling niet geslaagd. Probeer het opnieuw.');
        }

        if (!$user->is_premium) {
            $user->update(['is_premium' => true]);
        }

        return view('premium.success');
    }

    /**
     * Cancel the user's active Stripe subscription immediately and
     * revoke premium access.
     */
    public function cancel(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        if (!$user->is_premium || !$user->stripe_subscription_id) {
            return redirect()->route('premium.index')
                ->with('error', 'Je hebt geen actief abonnement.');
        }

        $subscription = Subscription::retrieve($user->stripe_subscription_id);

        if (!in_array($subscription->status, ['active', 'trialing', 'past_due'])) {
            $user->update([
                'is_premium'              => false,
                'stripe_subscription_id'  => null,
            ]);
            return redirect()->route('premium.index')
                ->with('success', 'Je abonnement is al beëindigd.');
        }

        $subscription->cancel();

        $user->update([
            'is_premium'             => false,
            'stripe_subscription_id' => null,
        ]);

        return redirect()->route('premium.index')
            ->with('success', 'Je Premium abonnement is succesvol opgezegd.');
    }
}