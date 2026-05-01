<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailVerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
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
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required'    => __('E-mailadres is verplicht.'),
            'email.string'      => __('E-mailadres moet geldig zijn.'),
            'email.email'       => __('Voer een geldig e-mailadres in.'),
            'password.required' => __('Wachtwoord is verplicht.'),
            'password.string'   => __('Wachtwoord moet uit tekens bestaan.'),
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => __('E-mailadres of wachtwoord klopt niet.'),
        ])->onlyInput('email');
    }

    /**
     * Show step 1 of the registration form.
     */
    public function showRegisterStep1()
    {
        return view('auth.register-step1');
    }

    /**
     * Handle step 1 of registration (name, email, password).
     */
    public function registerStep1(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'accepted',
        ], [
            'name.required'      => __('Volledige naam is verplicht.'),
            'name.string'        => __('Volledige naam moet uit letters bestaan.'),
            'name.max'           => __('Volledige naam mag niet langer zijn dan 255 tekens.'),
            'email.required'     => __('E-mailadres is verplicht.'),
            'email.string'       => __('E-mailadres moet geldig zijn.'),
            'email.email'        => __('Voer een geldig e-mailadres in.'),
            'email.max'          => __('E-mailadres mag niet langer zijn dan 255 tekens.'),
            'email.unique'       => __('Dit e-mailadres is al in gebruik.'),
            'password.required'  => __('Wachtwoord is verplicht.'),
            'password.string'    => __('Wachtwoord moet uit tekens bestaan.'),
            'password.min'       => __('Wachtwoord moet minimaal 8 tekens bevatten.'),
            'password.confirmed' => __('De wachtwoorden komen niet overeen.'),
            'terms.accepted'     => __('U moet de algemene voorwaarden accepteren.'),
        ]);

        session([
            'registration_step1' => [
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => $validated['password'],
            ]
        ]);

        return redirect()->route('register.step2');
    }

    /**
     * Show step 2 of the registration form.
     */
    public function showRegisterStep2()
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step2');
    }

    /**
     * Handle step 2 of registration (username, bio, profile photo).
     */
    public function registerStep2(Request $request)
    {
        if (!session('registration_step1')) {
            return redirect()->route('register.step1');
        }

        $validated = $request->validate([
            'username'      => 'required|string|max:255|unique:users,username',
            'bio'           => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'username.required'   => __('Gebruikersnaam is verplicht.'),
            'username.string'     => __('Gebruikersnaam moet uit tekens bestaan.'),
            'username.max'        => __('Gebruikersnaam mag niet langer zijn dan 255 tekens.'),
            'username.unique'     => __('Deze gebruikersnaam is al in gebruik.'),
            'bio.string'          => __('Bio moet uit tekens bestaan.'),
            'bio.max'             => __('Bio mag niet langer zijn dan 500 tekens.'),
            'profile_photo.image' => __('Het bestand moet een afbeelding zijn.'),
            'profile_photo.mimes' => __('De afbeelding moet in PNG, JPG, GIF of JPEG formaat zijn.'),
            'profile_photo.max'   => __('De afbeelding mag niet groter zijn dan 2MB.'),
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo_path'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        unset($validated['profile_photo']);

        session(['registration_step2' => $validated]);

        $this->sendVerificationCode(
            session('registration_step1.email'),
            session('registration_step1.name')
        );

        return redirect()->route('register.step3');
    }

    /**
     * Show step 3 of the registration form (email verification).
     */
    public function showRegisterStep3()
    {
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }

        return view('auth.register-step3', [
            'email' => session('registration_step1.email'),
        ]);
    }

    /**
     * Verify email with the 6-digit code and finalize registration or verify existing user.
     */
    public function verifyEmailCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6',
        ], [
            'code.required' => __('Verificatiecode is verplicht.'),
            'code.string'   => __('Verificatiecode moet uit cijfers bestaan.'),
            'code.size'     => __('Verificatiecode moet 6 cijfers zijn.'),
        ]);

        if (!ctype_digit($validated['code'])) {
            return back()->withErrors([
                'code' => __('Verificatiecode moet uit 6 cijfers bestaan.'),
            ]);
        }

        $email = session('registration_step1.email') ?? (Auth::check() ? Auth::user()->email : null);

        if (!$email) {
            return redirect()->route('register.step1')->withErrors([
                'code' => __('Registratiesessie is verlopen. Start opnieuw.'),
            ]);
        }

        $verificationCode = EmailVerificationCode::where('email', $email)
            ->where('code', $validated['code'])
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationCode) {
            return back()->withErrors([
                'code' => __('Verificatiecode is ongeldig of verlopen.'),
            ]);
        }

        $verificationCode->update(['is_verified' => true]);

        // --- SCENARIO 1: New registration ---
        if (session('registration_step1') && session('registration_step2')) {
            $userData = array_merge(
                session('registration_step1'),
                session('registration_step2'),
                ['email_verified_at' => now()]
            );

            $user = User::create($userData);

            Log::info('User created during registration', [
                'user_id' => $user->user_id,
                'email'   => $user->email,
            ]);

            $verificationCode->update(['user_id' => $user->user_id]);
            EmailVerificationCode::where('email', $email)->delete();
            $request->session()->forget(['registration_step1', 'registration_step2']);

            Auth::login($user);

            return redirect('/')->with('success', __('Je account is succesvol aangemaakt en geverifiëerd!'));
        }

        // --- SCENARIO 2: Existing logged-in user verifying their email ---
        if (Auth::check()) {
            $user = Auth::user();

            $user->update(['email_verified_at' => now()]);
            $verificationCode->update(['user_id' => $user->user_id]);
            EmailVerificationCode::where('email', $email)->delete();

            Log::info('Email verified for existing user', ['user_id' => $user->user_id]);

            return redirect('/')->with('success', __('Je email is succesvol geverifiëerd!'));
        }

        return redirect()->route('register.step1')->withErrors([
            'code' => __('Onbekende status. Start opnieuw.'),
        ]);
    }

    /**
     * Resend the verification email.
     */
    public function resendVerificationEmail(Request $request)
    {
        $email = session('registration_step1.email');
        $name  = session('registration_step1.name');

        if (!$email) {
            if (!Auth::check()) {
                return back()->withErrors([
                    'email' => __('Registratiesessie is verlopen. Start opnieuw.'),
                ]);
            }
            $email = Auth::user()->email;
            $name  = Auth::user()->name;
        }

        $this->sendVerificationCode($email, $name);

        return back()->with('success', __('Verificatieemail opnieuw verzonden.'));
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

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Delete old codes, generate a new one and send the verification email.
     */
    private function sendVerificationCode(string $email, string $name): void
    {
        EmailVerificationCode::where('email', $email)->delete();

        $code = $this->generateVerificationCode();

        EmailVerificationCode::create([
            'user_id'     => Auth::check() ? Auth::id() : null,
            'email'       => $email,
            'code'        => $code,
            'is_verified' => false,
            'expires_at'  => now()->addMinutes(15),
        ]);

        try {
            Mail::to($email)->send(new VerificationCodeMail($code, $name));
            Log::info('Verification email sent', ['email' => $email]);
        } catch (\Exception $e) {
            Log::error('Verification email failed', ['email' => $email, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Generate a random zero-padded 6-digit numeric string.
     */
    private function generateVerificationCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}