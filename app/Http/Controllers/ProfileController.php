<?php

namespace App\Http\Controllers;

use App\Models\EmailVerificationCode;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the user's profile page.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username,' . $user->user_id . ',user_id',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'bio' => 'nullable|string|max:500',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Controleer of email is gewijzigd
        $emailChanged = isset($validated['email']) && $validated['email'] !== $user->email;

        // Als email is gewijzigd, zet email_verified_at op null
        if ($emailChanged) {
            $validated['email_verified_at'] = null;
        }

        // Verwerk de profielfoto
        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request->file('profile_photo_path')
                ->store('profile-photos', 'public');
        }

        $user->update($validated);

        // Als email is gewijzigd, stuur verificatiecode
        if ($emailChanged) {
            $this->sendEmailVerificationCodeHelper($validated['email'], $user->name);
            return redirect()->route('profile.show')
                ->with('email_change_status', 'email_verification_sent');
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profiel succesvol bijgewerkt!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Het ingevulde wachtwoord is onjuist.');
                    }
                },
            ],
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'current_password.required' => 'Voer je huige wachtwoord in.',
            'password.required' => 'Voer een nieuw wachtwoord in.',
            'password.min' => 'Wachtwoord moet minimaal 8 tekens bevatten.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            'password.different' => 'Het nieuwe wachtwoord mag niet hetzelfde zijn als het huige wachtwoord.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Wachtwoord succesvol gewijzigd!');
    }

    /**
     * Send verification code to new email.
     */
    public function sendEmailVerificationCode(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        // Check if it's a different email
        if ($validated['email'] === $user->email) {
            return back()->withErrors([
                'email' => 'Dit is je huidge email adres. Voer een ander adres in.',
            ]);
        }

        $this->sendEmailVerificationCodeHelper($validated['email'], $user->name);

        return back()->with('email_change_status', 'email_verification_sent');
    }

    /**
     * Verify email with 6-digit code.
     */
    public function verifyEmailCode(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_code' => 'required|string|size:6',
        ], [
            'email_code.required' => 'Verificatiecode is verplicht.',
            'email_code.size' => 'Verificatiecode moet 6 cijfers zijn.',
        ]);

        if (!ctype_digit($validated['email_code'])) {
            return back()->withErrors([
                'email_code' => 'Verificatiecode moet uit 6 cijfers bestaan.',
            ]);
        }

        // Find the verification code - it should be for the new email (not current user email)
        $verificationCode = EmailVerificationCode::where('user_id', $user->user_id)
            ->where('code', $validated['email_code'])
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationCode) {
            return back()->withErrors([
                'email_code' => 'Verificatiecode is ongeldig of verlopen.',
            ]);
        }

        // Update user's email and mark as verified
        $user->update([
            'email' => $verificationCode->email,
            'email_verified_at' => now(),
        ]);

        $verificationCode->update(['is_verified' => true]);
        EmailVerificationCode::where('user_id', $user->user_id)->where('is_verified', false)->delete();

        Log::info('Email verified for user', ['user_id' => $user->user_id, 'email' => $verificationCode->email]);

        return redirect()->route('profile.show')
            ->with('success', 'Je email adres is succesvol geverifiëerd!');
    }

    /**
     * Helper: Send verification code email.
     */
    private function sendEmailVerificationCodeHelper(string $email, string $name): void
    {
        $user = Auth::user();

        // Delete old codes for this user
        EmailVerificationCode::where('user_id', $user->user_id)->delete();

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailVerificationCode::create([
            'user_id' => $user->user_id,
            'email' => $email,
            'code' => $code,
            'is_verified' => false,
            'expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::to($email)->send(new VerificationCodeMail($code, $name));
            Log::info('Email verification code sent', ['email' => $email, 'user_id' => $user->user_id]);
        } catch (\Exception $e) {
            Log::error('Email verification failed', ['email' => $email, 'error' => $e->getMessage()]);
        }
    }
    public function updateBadges(Request $request)
{
    $user = Auth::user();

    $user->update([
        'show_badge_premium' => $request->boolean('show_badge_premium'),
        'show_badge_email'   => $request->boolean('show_badge_email'),
        'show_badge_phone'   => $request->boolean('show_badge_phone'),
    ]);

    return redirect()->route('profile.show')
        ->with('success', 'Badge instellingen opgeslagen!');
}
public function showPublic(User $user)
{
    return view('profile.public', compact('user'));
}
}
