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
            return redirect('/')->with('info', 'Je hebt al Premium.');  // fix #1
        }
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
            return redirect('/');
        }

        $intent = PaymentIntent::retrieve($request->payment_intent);

        // fix #2: redirect bij mislukking, toon success alleen als alles klopt
        if ($intent->status !== 'succeeded') {
            return redirect('/checkout')->with('error', 'Betaling niet geslaagd.');
        }

        if ($intent->metadata->user_id != Auth::id()) {
            abort(403);
        }

        // fix #3: alleen updaten als nog niet premium
        if (!Auth::user()->is_premium) {
            Auth::user()->update(['is_premium' => true]);
        }

        return view('premium.success');
    }
}