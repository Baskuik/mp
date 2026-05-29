<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Show the settings index page (Story 399, 400)
     */
    public function index()
    {
        $user = auth()->user();
        return view('settings.index', [
            'user' => $user,
            'languages' => [
                'nl' => 'Nederlands',
                'en' => 'English',
                'de' => 'Deutsch',
            ],
        ]);
    }

    /**
     * Update user language preference (Story 402)
     */
    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => 'required|in:nl,en,de',
        ]);

        $user = auth()->user();
        $user->update(['language' => $validated['language']]);

        session(['locale' => $validated['language']]);

        return redirect()->route('settings.index')
            ->with('success', __('messages.language_updated_successfully'));
    }

    /**
     * Update user password (Story 403)
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail(__('messages.current_password_incorrect'));
                    }
                },
            ],
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
            ],
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()->route('settings.index')
            ->with('success', __('messages.password_updated_successfully'));
    }

    /**
     * Update user phone number (Story 403)
     */
    public function updatePhone(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => [
                'nullable',
                'regex:/^(\+31|0)[1-9](\d{8}|\d{9})$/',
            ],
        ]);

        $user = auth()->user();
        $user->update(['phone_number' => $validated['phone_number'] ?: null]);

        return redirect()->route('settings.index')
            ->with('success', __('messages.phone_updated_successfully'));
    }

    /**
     * Update user email (Story 403)
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'unique:users,email,' . auth()->id() . ',user_id',
            ],
        ]);

        $user = auth()->user();
        $user->update([
            'email' => $validated['email'],
            'email_verified_at' => null, // Reset verification
        ]);

        return redirect()->route('settings.index')
            ->with('success', __('messages.email_updated_successfully'));
    }
}
