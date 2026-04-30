<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        return redirect()->route('register.step3');
    }

    /**
     * Show step 3 of registration form.
     */
    public function showRegisterStep3()
    {
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }
        return view('auth.register-step3');
    }

    /**
     * Handle step 3 of registration - Email verification.
     */
    public function registerStep3(Request $request)
    {
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }

        // Get all data from session
        $step1Data = session('registration_step1');
        $step2Data = session('registration_step2');

        // Merge all data and create user
        $userData = array_merge($step1Data, $step2Data);
        $userData['email_verified_at'] = now();

        $user = User::create($userData);

        // Log the user in
        Auth::login($user);

        // Clear the registration session data
        $request->session()->forget(['registration_step1', 'registration_step2']);

        return redirect('/');
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
}
