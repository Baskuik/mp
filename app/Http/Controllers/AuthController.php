<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => __('Email of wachtwoord klopt niet.'),
        ])->onlyInput('email');
    }

    /**
     * Show step 1 of registration form.
     */
    public function showRegisterStep1()
    {
        return view('auth.register-step1');
    }

    /**
     * Handle step 1 of registration.
     */
    public function registerStep1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'terms' => 'accepted',
        ], [
            'email.unique' => __('Deze email is al in gebruik.'),
            'password.min' => __('Wachtwoord moet minimaal 8 tekens bevatten.'),
            'password.confirmed' => __('De wachtwoorden komen niet overeen.'),
            'email.email' => __('Voer een geldig emailadres in.'),
            'name.required' => __('Naam is verplicht.'),
            'terms.accepted' => __('U moet de algemene voorwaarden accepteren.'),
        ]);

        // Store step 1 data in session (DON'T create user yet)
        session([
            'registration_step1' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]
        ]);

        return redirect()->route('register.step2');
    }

    /**
     * Show step 2 of registration form.
     */
    public function showRegisterStep2()
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }
        return view('auth.register-step2');
    }

    /**
     * Handle step 2 of registration.
     */
    public function registerStep2(Request $request)
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.unique' => __('Deze gebruikersnaam is al in gebruik.'),
            'profile_photo.image' => __('Het bestand moet een afbeelding zijn.'),
            'profile_photo.max' => __('De afbeelding mag niet groter zijn dan 2MB.'),
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo_path'] = $path;
        }

        // Remove the UploadedFile object before storing in session
        unset($validated['profile_photo']);

        // Store step 2 data in session
        session(['registration_step2' => $validated]);

        // Clear any previously created (unverified) user so a fresh one gets created on step 3
        session()->forget('registration_user_id');

        return redirect()->route('register.step3');
    }

    /**
     * Show step 3 of registration form.
     * Creates the user (unverified) on first visit and sends the verification email.
     */
    public function showRegisterStep3()
    {
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }

        // Create the user (unverified) if not already done in this registration flow
        $userId = session('registration_user_id');

        if (!$userId || !User::find($userId)) {
            $step1Data = session('registration_step1');
            $step2Data = session('registration_step2');

            $userData = array_merge($step1Data, $step2Data);
            // Do NOT set email_verified_at — the user is unverified
            $userData['email_verified_at'] = null;

            $code = $this->generateVerificationCode();
            $userData['email_verification_code'] = $code;
            $userData['email_verification_expires_at'] = now()->addMinutes(15);

            $user = User::create($userData);
            session(['registration_user_id' => $user->id]);

            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));
        }

        return view('auth.register-step3');
    }

    /**
     * Handle step 3 of registration - validate the email verification code.
     */
    public function registerStep3(Request $request)
    {
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }

        $request->validate([
            'verification_code' => 'required|string|size:6',
        ], [
            'verification_code.required' => __('Voer je verificatiecode in.'),
            'verification_code.size' => __('De verificatiecode moet 6 cijfers bevatten.'),
        ]);

        $userId = session('registration_user_id');
        $user = $userId ? User::find($userId) : null;

        if (!$user) {
            return redirect()->route('register.step3')
                ->withErrors(['verification_code' => __('Er is iets misgegaan. Probeer het opnieuw.')]);
        }

        // Check if the code has expired
        if ($user->email_verification_expires_at && $user->email_verification_expires_at->isPast()) {
            return back()->withErrors([
                'verification_code' => __('De verificatiecode is verlopen. Klik op "Opnieuw versturen" om een nieuwe code te ontvangen.'),
            ]);
        }

        // Check if the code matches
        if ($request->verification_code !== $user->email_verification_code) {
            return back()->withErrors([
                'verification_code' => __('De verificatiecode is onjuist. Controleer je email en probeer het opnieuw.'),
            ]);
        }

        // Mark email as verified and clear the code
        $user->email_verified_at = now();
        $user->email_verification_code = null;
        $user->email_verification_expires_at = null;
        $user->save();

        // Log the user in
        Auth::login($user);

        // Clear the registration session data
        $request->session()->forget(['registration_step1', 'registration_step2', 'registration_user_id']);

        return redirect('/');
    }

    /**
     * Resend the verification code email.
     */
    public function resendVerificationCode(Request $request)
    {
        $userId = session('registration_user_id');
        $user = $userId ? User::find($userId) : null;

        if (!$user) {
            return redirect()->route('register.step3')
                ->withErrors(['verification_code' => __('Er is iets misgegaan. Probeer het opnieuw.')]);
        }

        $code = $this->generateVerificationCode();
        $user->email_verification_code = $code;
        $user->email_verification_expires_at = now()->addMinutes(15);
        $user->save();

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        return redirect()->route('register.step3')
            ->with('resent', __('Een nieuwe verificatiecode is naar je email verstuurd.'));
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the forgot password form.
     */
    public function showForgotPassword()
    {
        // Forgot password form will go here
    }

    /**
     * Generate a random 6-digit numeric verification code.
     */
    private function generateVerificationCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
