<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    /**
     * Toon de premium marketing pagina.
     */
    public function index()
    {
        // Als gebruiker al premium is, redirect naar dashboard
        if (Auth::user()->premium) {
            return redirect()->route('profile.show')->with('info', 'Je hebt al een premium account!');
        }

        return view('premium.index');
    }

    /**
     * Toon de checkout pagina.
     */
    public function checkout()
    {
        if (Auth::user()->premium) {
            return redirect()->route('profile.show')->with('info', 'Je hebt al een premium account!');
        }

        return view('premium.checkout');
    }

    /**
     * Verwerk de betaling (Stripe).
     * Installeer Stripe via: composer require stripe/stripe-php
     * Voeg toe aan .env: STRIPE_KEY, STRIPE_SECRET, STRIPE_WEBHOOK_SECRET
     */
    public function process(Request $request)
    {
        $request->validate([
            'stripeToken' => 'required|string',
        ]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = \Stripe\Charge::create([
                'amount'      => 999, // €9,99 in centen
                'currency'    => 'eur',
                'description' => 'Premium lidmaatschap',
                'source'      => $request->stripeToken,
                'metadata'    => [
                    'user_id' => Auth::id(),
                    'email'   => Auth::user()->email,
                ],
            ]);

            // Betaling geslaagd — zet premium op true
            Auth::user()->update(['premium' => true]);

            return redirect()->route('profile.show')
                ->with('success', '🎉 Welkom bij Premium! Geniet van alle voordelen.');
        } catch (\Stripe\Exception\CardException $e) {
            return back()->with('error', 'Betaling mislukt: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Er is iets misgegaan. Probeer het opnieuw.');
        }
    }
}