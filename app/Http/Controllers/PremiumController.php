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

        $intent = PaymentIntent::create([
            'amount'   => 999,
            'currency' => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
            'receipt_email' => Auth::user()->email,
            'metadata'  => [
                'user_id' => Auth::id(),
            ],
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

public function success(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    if (!$request->payment_intent) {
        return redirect()->route('premium.index')->with('error', 'Geen betaling gevonden.');
    }

    $intent = PaymentIntent::retrieve($request->payment_intent);

    if ($intent->status !== 'succeeded') {
        return redirect()->route('premium.index')->with('error', 'Betaling niet geslaagd. Probeer het opnieuw.');
    }

    if ($intent->metadata->user_id != Auth::id()) {
        abort(403);
    }

    if (!Auth::user()->is_premium) {
        Auth::user()->update(['is_premium' => true]);
    }

    return view('premium.success');
}
}