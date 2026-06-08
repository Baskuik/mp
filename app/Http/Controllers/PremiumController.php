<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PremiumController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_premium) {
            return redirect()->url('/')->with('info', 'Je hebt al Premium.');
        }
        return view('premium.index');
    }

    public function checkout()
    {
        if (Auth::user()->is_premium) {
            return redirect(url('/'));
        }
        return view('premium.checkout');
    }

    public function intent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount'   => 999,
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
            'receipt_email' => Auth::user()->email,
            'metadata' => [
                'user_id' => Auth::id(), // handig voor Stripe dashboard
            ],
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // payment_intent komt via URL parameter van Stripe
        if (!$request->payment_intent) {
            return redirect(url('/'));
        }

        $intent = PaymentIntent::retrieve($request->payment_intent);

        if ($intent->status === 'succeeded') {
            // Controleer of het écht voor deze user is
            if ($intent->metadata->user_id == Auth::id()) {
                Auth::user()->update(['is_premium' => true]);
            }
        }

        return view('premium.success');
    }
}