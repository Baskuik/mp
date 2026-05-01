<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailVerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        ], [
            'email.required' => __('E-mailadres is verplicht.'),
            'email.string' => __('E-mailadres moet geldig zijn.'),
            'email.email' => __('Voer een geldig e-mailadres in.'),
            'password.required' => __('Wachtwoord is verplicht.'),
            'password.string' => __('Wachtwoord moet uit tekens bestaan.'),
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => __('E-mailadres of wachtwoord klopt niet.'),
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
            'terms' => 'accepted',
        ], [
            'name.required' => __('Volledige naam is verplicht.'),
            'name.string' => __('Volledige naam moet uit letters bestaan.'),
            'name.max' => __('Volledige naam mag niet langer zijn dan 255 tekens.'),
            'email.required' => __('E-mailadres is verplicht.'),
            'email.string' => __('E-mailadres moet geldig zijn.'),
            'email.email' => __('Voer een geldig e-mailadres in.'),
            'email.max' => __('E-mailadres mag niet langer zijn dan 255 tekens.'),
            'email.unique' => __('Dit e-mailadres is al in gebruik.'),
            'password.required' => __('Wachtwoord is verplicht.'),
            'password.string' => __('Wachtwoord moet uit tekens bestaan.'),
            'password.min' => __('Wachtwoord moet minimaal 8 tekens bevatten.'),
            'password.confirmed' => __('De wachtwoorden komen niet overeen.'),
            'terms.accepted' => __('U moet de algemene voorwaarden accepteren.'),
        ]);

        // Store step 1 data in session (DON'T create user yet)
        session([
            'registration_step1' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
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
            'username.required' => __('Gebruikersnaam is verplicht.'),
            'username.string' => __('Gebruikersnaam moet uit tekens bestaan.'),
            'username.max' => __('Gebruikersnaam mag niet langer zijn dan 255 tekens.'),
            'username.unique' => __('Deze gebruikersnaam is al in gebruik.'),
            'bio.string' => __('Bio moet uit tekens bestaan.'),
            'bio.max' => __('Bio mag niet langer zijn dan 500 tekens.'),
            'profile_photo.image' => __('Het bestand moet een afbeelding zijn.'),
            'profile_photo.mimes' => __('De afbeelding moet in PNG, JPG, GIF of JPEG formaat zijn.'),
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

        // Delete old verification codes for this email
        $email = session('registration_step1.email');
        EmailVerificationCode::where('email', $email)->delete();

        // Generate and save new verification code
        $verificationCode = $this->generateVerificationCode();
        EmailVerificationCode::create([
            'user_id' => null,
            'email' => $email,
            'code' => $verificationCode,
            'expires_at' => now()->addMinutes(15),
        ]);

        // Send verification email
        try {
            Mail::to($email)->send(
                new VerificationCodeMail($verificationCode, session('registration_step1.name'))
            );
        } catch (\Exception $e) {
            \Log::error('Verification email failed: ' . $e->getMessage());
        }

        return redirect()->route('register.step3');
    }

    /**
     * Show step 3 of registration form.
     * Creates the user (unverified) on first visit and sends the verification email.
     */
    public function showRegisterStep3()
    {
        // Allow access only if user has registration session data
        if (!session('registration_step1') || !session('registration_step2')) {
            return redirect()->route('register.step1');
        }

        $email = session('registration_step1.email');
        return view('auth.register-step3', ['email' => $email]);
    }



    /**
     * Verify email with code.
     */
    public function verifyEmailCode(Request $request)
    {
        $email = null;
        $validated = [];

        try {
            $validated = $request->validate([
                'code' => 'required|string|size:6',
            ], [
                'code.required' => __('Verificatiecode is verplicht.'),
                'code.string' => __('Verificatiecode moet uit cijfers bestaan.'),
                'code.size' => __('Verificatiecode moet 6 cijfers zijn.'),
            ]);

            // Ensure code contains only digits
            if (!ctype_digit($validated['code'])) {
                return redirect()->route('register.step3')->withErrors([
                    'code' => __('Verificatiecode moet uit 6 cijfers bestaan.'),
                ]);
            }

            // Determine if user is registering (session data) or already logged in
            $email = session('registration_step1.email');

            // If no session data, check if user is logged in
            if (!$email && !Auth::check()) {
                return redirect()->route('register.step3')->withErrors([
                    'code' => __('Registratiesessie is verlopen. Start opnieuw.'),
                ]);
            }

            // If no session email but user is logged in, use authenticated user's email
            if (!$email) {
                $email = Auth::user()->email;
            }

            \Log::info('Verifying email code', ['email' => $email, 'is_authenticated' => Auth::check()]);

            // Find the verification code
            $verificationCode = EmailVerificationCode::where('email', $email)
                ->where('code', $validated['code'])
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->first();

            if (!$verificationCode) {
                return redirect()->route('register.step3')->withErrors([
                    'code' => __('Verificatiecode is ongeldig of verlopen.'),
                ]);
            }

            // Mark code as verified first
            $verificationCode->update(['is_verified' => true]);

            // SCENARIO 1: User is registering (has session data)
            if (session('registration_step1') && session('registration_step2')) {
                $step1Data = session('registration_step1');
                $step2Data = session('registration_step2');

                // Merge data and create user
                $userData = array_merge($step1Data, $step2Data);
                $userData['email_verified_at'] = now();

                \Log::info('Creating user during registration', ['email' => $email]);

                $user = User::create($userData);

                \Log::info('User created successfully', ['user_id' => $user->id, 'email' => $user->email]);

                // Update verification code with user_id
                $verificationCode->update(['user_id' => $user->id]);

                // Delete all verification codes for this email
                EmailVerificationCode::where('email', $email)->delete();

                // Clear the registration session data
                $request->session()->forget(['registration_step1', 'registration_step2']);

                // Log the user in
                \Log::info('Logging in newly created user', ['user_id' => $user->id]);
                Auth::login($user);

                \Log::info('Redirecting to home after registration', ['authenticated' => Auth::check()]);
                return redirect('/')->with('success', __('Je account is succesvol aangemaakt en geverifiëerd!'));
            }

            // SCENARIO 2: User is already logged in and verifying their email
            elseif (Auth::check()) {
                $user = Auth::user();

                \Log::info('Verifying email for existing user', ['user_id' => $user->id]);

                // Verify user's email
                $user->update(['email_verified_at' => now()]);

                // Update verification code with user_id
                $verificationCode->update(['user_id' => $user->id]);

                // Delete all verification codes for this email
                EmailVerificationCode::where('email', $email)->delete();

                \Log::info('Email verified for existing user', ['user_id' => $user->id]);
                return redirect('/')->with('success', __('Je email is succesvol geverifiëerd!'));
            }

            // Should not reach here
            return redirect()->route('register.step3')->withErrors([
                'code' => __('Onbekende status. Start opnieuw.'),
            ]);

        } catch (\Exception $e) {
            \Log::error('Email verification failed: ' . $e->getMessage(), [
                'exception' => $e,
                'email' => $email ?? 'unknown',
                'code' => $validated['code'] ?? null,
            ]);

            return redirect()->route('register.step3')->withErrors([
                'code' => __('Er is een fout opgetreden bij het verifiëren van je email: ') . $e->getMessage(),
            ]);
        }
    }

    /**
     * Resend verification email.
     */
    public function resendVerificationEmail(Request $request)
    {
        try {
            // Scenario 1: User is registering (has session data)
            $email = session('registration_step1.email');
            $name = session('registration_step1.name');

            // Scenario 2: User is already logged in
            if (!$email) {
                if (!Auth::check()) {
                    return back()->withErrors([
                        'email' => __('Registratiesessie is verlopen. Start opnieuw.'),
                    ]);
                }
                $email = Auth::user()->email;
                $name = Auth::user()->name;
            }

            // Delete old verification codes
            EmailVerificationCode::where('email', $email)->delete();

            // Generate new verification code
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store new verification code
            $codeData = [
                'email' => $email,
                'code' => $verificationCode,
                'expires_at' => now()->addMinutes(15),
            ];

            // Only add user_id if user is already logged in
            if (Auth::check()) {
                $codeData['user_id'] = Auth::id();
            } else {
                $codeData['user_id'] = null;
            }

            EmailVerificationCode::create($codeData);

            // Send verification email
            Mail::to($email)->send(new VerificationCodeMail($verificationCode, $name));

            \Log::info('Verification email resent', ['email' => $email]);

            return back()->with('success', __('Verificatieemail opnieuw verzonden.'));
        } catch (\Exception $e) {
            \Log::error('Verification email resend failed: ' . $e->getMessage());
            return back()->withErrors([
                'email' => __('Er is een fout opgetreden bij het verzenden van de email.'),
            ]);
        }
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
