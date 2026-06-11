<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\SetupIntent;
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
            return redirect('/');
        }
        return view('premium.checkout');
    }

    public function intent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user();

        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
                'metadata' => ['user_id' => (string) $user->id],
            ]);
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        $setupIntent = SetupIntent::create([
            'customer' => $user->stripe_customer_id,
            'payment_method_types' => ['card'],
        ]);

        return response()->json(['clientSecret' => $setupIntent->client_secret]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user()->fresh();

        if (!$request->setup_intent) {
            return redirect()->route('premium.index')->with('error', 'Geen betaling gevonden.');
        }

        $setupIntent = SetupIntent::retrieve($request->setup_intent);

        if ($setupIntent->status !== 'succeeded') {
            return redirect()->route('premium.checkout')->with('error', 'Betaling niet geslaagd. Probeer het opnieuw.');
        }

        if ($setupIntent->metadata->user_id != $user->id) {
            abort(403);
        }

        if ($user->is_premium) {
            return view('premium.success');
        }

        //dd($user->stripe_customer_id, $setupIntent->customer, $user->getAttributes());

        \Stripe\PaymentMethod::retrieve($setupIntent->payment_method)->attach([
            'customer' => $user->stripe_customer_id,
        ]);
        $subscription = Subscription::create([
            'customer' => $user->stripe_customer_id,
            'items' => [['price' => config('services.stripe.monthly_price_id')]],
            'default_payment_method' => $setupIntent->payment_method,
        ]);

        $user->update([
            'is_premium' => true,
            'stripe_subscription_id' => $subscription->id,
            'premium_expires_at' => now()->addMonth(),
        ]);

        return view('premium.success');
    }

    public function cancel(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = Auth::user();

        if (!$user->is_premium || !$user->stripe_subscription_id) {
            return redirect()->route('premium.index');
        }

        $subscription = Subscription::retrieve($user->stripe_subscription_id);
        $subscription->update(['cancel_at_period_end' => true]);

        $user->update([
            'is_premium' => false,
            'stripe_subscription_id' => null,
            'premium_expires_at' => null,
        ]);

        return redirect()->route('premium.index')->with('success', 'Je abonnement is opgezegd.');
    }
}