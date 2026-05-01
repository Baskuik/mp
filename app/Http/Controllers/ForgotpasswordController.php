<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the given email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => __('E-mailadres is verplicht.'),
            'email.email'    => __('Voer een geldig e-mailadres in.'),
        ]);

        // We always show a success message, even if the email doesn't exist.
        // This prevents user enumeration attacks.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __('Als dit e-mailadres bij ons bekend is, ontvang je zo een resetlink.'));
    }

    /**
     * Show the reset password form (via the link in the email).
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle the new password submission.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'token.required'     => __('Reset token ontbreekt.'),
            'email.required'     => __('E-mailadres is verplicht.'),
            'email.email'        => __('Voer een geldig e-mailadres in.'),
            'password.required'  => __('Wachtwoord is verplicht.'),
            'password.min'       => __('Wachtwoord moet minimaal 8 tekens bevatten.'),
            'password.confirmed' => __('De wachtwoorden komen niet overeen.'),
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', __('Je wachtwoord is succesvol gewijzigd. Je kunt nu inloggen.'));
        }

        return back()->withErrors([
            'email' => __('De resetlink is ongeldig of verlopen. Vraag een nieuwe aan.'),
        ]);
    }
}