@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('profile.title') }}</h1>
                <p class="text-gray-600 mt-2">
                    {{ __('profile.subtitle') ?? 'Beheer je persoonlijke gegevens en accountinstellingen' }}</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                    <p class="text-green-600 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Email Change Status -->
            @if (session('email_change_status') === 'email_verification_sent')
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                    <p class="text-blue-600 text-sm font-medium">{{ __('profile.alert_email_change_status') }}: We hebben
                        een verificatiecode naar je email adres verstuurd.</p>
                </div>
            @endif

            <!-- Profile Container with Sidebar Navigation -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <nav class="space-y-2 bg-white rounded-xl p-4 border border-gray-200">
                        <a href="#edit-profile"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#edit-profile')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('profile.nav_edit_profile') }}
                            </span>
                        </a>
                        <a href="#change-password"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#change-password')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ __('profile.nav_change_password') }}
                            </span>
                        </a>
                        <a href="#change-email"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#change-email')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ __('profile.nav_change_email') }}
                            </span>
                        </a>
                        <a href="#verify-phone"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#verify-phone')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ __('profile.nav_phone_verification') }}
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- SECTION: Edit Profile -->
                    <div id="edit-profile" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.edit_profile_title') }}</h2>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                            class="p-6 space-y-6">
                            @csrf

                            <!-- Name & Username Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('profile.edit_profile_name') }}
                                    </label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" placeholder="Jan de Vries"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror" />
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('profile.edit_profile_username') }}
                                    </label>
                                    <input type="text" name="username" id="username"
                                        value="{{ old('username', $user->username) }}" placeholder="@jandevries"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('username') border-red-500 @enderror" />
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ __('profile.edit_profile_username_hint') ?? 'Alleen letters, cijfers, koppeltekens en underscores.' }}
                                    </p>
                                    @error('username')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('profile.edit_profile_email') }}
                                </label>
                                <div class="flex gap-2 items-start">
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" placeholder="jan@voorbeeld.nl"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror" />
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-3 py-2 rounded-lg bg-green-100 text-green-700 text-xs font-medium whitespace-nowrap">
                                            ✓ {{ __('profile.badge_verified') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 text-xs font-medium whitespace-nowrap">
                                            ⚠ {{ __('profile.badge_unverified') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ __('profile.edit_profile_email_hint') ?? 'Als je dit wijzigt, moet je het adres opnieuw verifiëren.' }}
                                </p>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('profile.edit_profile_bio') }}
                                </label>
                                <textarea name="bio" id="bio" rows="4" placeholder="Vertel iets over jezelf…"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ __('profile.edit_profile_bio_hint') ?? 'Maximaal 500 tekens.' }}</p>
                                @error('bio')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Profile Photo -->
                            <div>
                                <label for="profile_photo_path" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('profile.edit_profile_photo') }}
                                </label>
                                <div class="flex gap-4 items-start">
                                    @if ($user->profile_photo_path)
                                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profielfoto"
                                            class="w-16 h-16 rounded-lg object-cover border border-gray-300" />
                                    @endif
                                    <label for="profile_photo_path"
                                        class="flex-1 px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer hover:border-green-500 hover:bg-green-50 transition-colors">
                                        <svg class="w-6 h-6 mx-auto text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs text-gray-600">
                                            {{ __('profile.edit_profile_photo_hint') ?? 'JPG, PNG or GIF (max 2MB)' }}</p>
                                        <input type="file" name="profile_photo_path" id="profile_photo_path"
                                            accept="image/*"
                                            class="hidden @error('profile_photo_path') border-red-500 @enderror" />
                                    </label>
                                </div>
                                @error('profile_photo_path')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                    {{ __('profile.edit_profile_button') ?? 'Opslaan' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- SECTION: Change Password -->
                    <div id="change-password" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.password_title') }}</h2>
                        </div>

                        <form action="{{ route('profile.update-password') }}" method="POST" class="p-6 space-y-6">
                            @csrf

                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('profile.password_current') }}
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password"
                                        placeholder="••••••••"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('current_password') border-red-500 @enderror" />
                                    <button type="button"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                        onclick="togglePasswordVisibility('current_password')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password & Confirm -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('profile.password_new') }}
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password"
                                            placeholder="Minimaal 8 tekens"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror" />
                                        <button type="button"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePasswordVisibility('password')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ __('profile.password_hint') ?? 'Minimaal 8 tekens.' }}</p>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('profile.password_confirm') }}
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Herhaal nieuw wachtwoord"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
                                        <button type="button"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePasswordVisibility('password_confirmation')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Update Button -->
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit"
                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                    {{ __('profile.password_button') ?? 'Wachtwoord Bijwerken' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- SECTION: Change Email -->
                    <div id="change-email" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.email_title') }}</h2>
                        </div>

                        <div class="p-6 space-y-6">
                            @if ($user->email_verified_at)
                                <!-- Verified Email -->
                                <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                                    @csrf

                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <p class="text-sm text-green-700">
                                            <strong>{{ __('profile.email_current') }}:</strong> {{ $user->email }}</p>
                                        <p class="text-xs text-green-600 mt-2">{{ __('profile.badge_verified') }} ✓</p>
                                    </div>

                                    <div>
                                        <label for="new_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('profile.email_new') }}
                                        </label>
                                        <input type="email" name="email" id="new_email"
                                            placeholder="nieuw@voorbeeld.nl"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror" />
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ __('profile.email_change_hint') ?? 'Na het wijzigen ontvang je een verificatiecode op je nieuwe adres.' }}
                                        </p>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end pt-4 border-t border-gray-200">
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                            {{ __('profile.email_change') ?? 'Wijzigen' }}
                                        </button>
                                    </div>
                                </form>

                                @if (session('email_change_status') === 'email_verification_sent')
                                    <!-- Verification Code Form -->
                                    <form action="{{ route('profile.email.verify') }}" method="POST"
                                        class="space-y-4 pt-6 border-t border-gray-200">
                                        @csrf

                                        <div>
                                            <label for="email_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('profile.email_verification_code') }}
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" name="email_code" id="email_code" maxlength="6"
                                                    placeholder="000000"
                                                    class="flex-1 px-4 py-2 text-center text-2xl tracking-widest border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email_code') border-red-500 @enderror" />
                                                <button type="submit"
                                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                                    {{ __('profile.email_verify') ?? 'Verifiëren' }}
                                                </button>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ __('profile.email_verification_hint') ?? 'De code is 15 minuten geldig.' }}
                                            </p>
                                            @error('email_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </form>
                                @endif
                            @else
                                <!-- Not Verified Yet -->
                                @if (session('email_change_status') === 'email_verification_sent')
                                    <form action="{{ route('profile.email.verify') }}" method="POST" class="space-y-4">
                                        @csrf

                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                            <p class="text-sm text-blue-700">
                                                {{ __('profile.email_verification_pending') ?? 'We hebben een verificatiecode naar je email adres verstuurd.' }}
                                            </p>
                                        </div>

                                        <div>
                                            <label for="email_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('profile.email_verification_code') }}
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" name="email_code" id="email_code" maxlength="6"
                                                    placeholder="000000"
                                                    class="flex-1 px-4 py-2 text-center text-2xl tracking-widest border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email_code') border-red-500 @enderror" />
                                                <button type="submit"
                                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                                    {{ __('profile.email_verify') ?? 'Verifiëren' }}
                                                </button>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ __('profile.email_verification_hint') ?? 'De code is 15 minuten geldig.' }}
                                            </p>
                                            @error('email_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <a href="{{ route('profile.show') }}"
                                                class="text-sm text-gray-600 hover:text-gray-900">← Annuleren</a>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                                        @csrf

                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                            <p class="text-sm text-yellow-700">
                                                <strong>{{ __('profile.alert_email_change_status') }}:</strong>
                                                {{ __('profile.email_not_verified') ?? 'Je email adres is nog niet geverifieerd.' }}
                                            </p>
                                        </div>

                                        <div>
                                            <label for="email_input" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('profile.edit_profile_email') }}
                                            </label>
                                            <input type="email" name="email" id="email_input"
                                                placeholder="jan@voorbeeld.nl" value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror" />
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end pt-4 border-t border-gray-200">
                                            <button type="submit"
                                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                                {{ __('profile.email_change') ?? 'Wijzigen' }}
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- SECTION: Phone Verification -->
                    <div id="verify-phone" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">{{ __('profile.phone_title') }}</h2>
                        </div>

                        <div class="p-6 space-y-6">
                            @if (session('status') === 'sms_sent')
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm text-blue-700">
                                        {{ __('profile.phone_sms_sent') ?? 'We hebben een SMS naar je telefoon verstuurd.' }}
                                    </p>
                                </div>
                            @elseif (session('status') === 'phone_verified')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm text-green-700">
                                        {{ __('profile.phone_verified') ?? 'Je telefoon is geverifieerd!' }}</p>
                                </div>
                            @endif

                            @if ($user->phone_verified)
                                <!-- Phone Verified -->
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm text-green-700"><strong>{{ __('profile.phone_number') }}:</strong>
                                        {{ $user->phone_number }}</p>
                                    <p class="text-xs text-green-600 mt-2">{{ __('profile.phone_verified') }} ✓</p>
                                </div>
                            @else
                                <!-- Phone Not Verified -->
                                @if ($user->phone_number)
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-sm text-yellow-700">
                                            <strong>{{ __('profile.phone_number') }}:</strong> {{ $user->phone_number }}
                                        </p>
                                        <p class="text-xs text-yellow-600 mt-2">
                                            {{ __('profile.phone_not_verified') ?? 'Nog niet geverifieerd' }}</p>
                                    </div>
                                @endif

                                <!-- Request SMS Verification -->
                                <form action="{{ route('phone.send') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('profile.phone_number') }}
                                        </label>
                                        <input type="tel" name="phone_number" id="phone_number"
                                            value="{{ old('phone_number', $user->phone_number) }}"
                                            placeholder="+31 6 12 34 56 78"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('phone_number') border-red-500 @enderror" />
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ __('profile.phone_format_help') ?? 'Bijvoorbeeld: +31 6 12 34 56 78 of 06 12 34 56 78' }}
                                        </p>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end pt-4 border-t border-gray-200">
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                            {{ __('profile.phone_send_code') ?? 'Stuur code' }}
                                        </button>
                                    </div>
                                </form>

                                @if (session('status') === 'sms_sent')
                                    <!-- Verify SMS Code -->
                                    <form action="{{ route('phone.verify') }}" method="POST"
                                        class="space-y-4 pt-6 border-t border-gray-200">
                                        @csrf
                                        <div>
                                            <label for="sms_code" class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ __('profile.phone_verification_code') ?? 'Verificatiecode' }}
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" name="sms_code" id="sms_code" maxlength="6"
                                                    placeholder="000000"
                                                    class="flex-1 px-4 py-2 text-center text-2xl tracking-widest border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('sms_code') border-red-500 @enderror" />
                                                <button type="submit"
                                                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                                    {{ __('profile.phone_verify') ?? 'Verifiëren' }}
                                                </button>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ __('profile.phone_verification_hint') ?? 'De code is 10 minuten geldig.' }}
                                            </p>
                                            @error('sms_code')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function scrollToSection(selector) {
            const element = document.querySelector(selector);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            return false;
        }

        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>
@endsection
{{ __('profile.edit_profile_title') }}
</div>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="card-body">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label for="name">{{ __('profile.edit_profile_name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                placeholder="Jan de Vries" class="@error('name') is-error @enderror" />
            @error('name')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="username">{{ __('profile.edit_profile_username') }}</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                placeholder="@jandevries" class="@error('username') is-error @enderror" />
            <p class="field-hint">Alleen letters, cijfers, koppeltekens en underscores.</p>
            @error('username')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="email">{{ __('profile.edit_profile_email') }}</label>
        <div class="input-with-badge">
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                placeholder="jan@voorbeeld.nl" class="@error('email') is-error @enderror" />
            @if ($user->email_verified_at)
                <span class="input-badge verified">{{ __('profile.badge_verified') }}</span>
            @else
                <span class="input-badge unverified">{{ __('profile.badge_unverified') }}</span>
            @endif
        </div>
        <p class="field-hint">Als je dit wijzigt, moet je het adres opnieuw verifiëren.</p>
        @error('email')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="bio">{{ __('profile.edit_profile_bio') }}</label>
        <textarea name="bio" id="bio" rows="4" placeholder="Vertel iets over jezelf…"
            class="@error('bio') is-error @enderror">{{ old('bio', $user->bio) }}</textarea>
        <p class="field-hint">Maximaal 500 tekens.</p>
        @error('bio')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="profile_photo_path">{{ __('profile.edit_profile_photo') }}</label>
        <div class="file-upload-area">
            @if ($user->profile_photo_path)
                <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profielfoto"
                    class="current-avatar" />
            @endif
            <label for="profile_photo_path" class="file-upload-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z" />
                </svg>
                {{ __('profile.edit_profile_photo_hint') }}
                <input type="file" name="profile_photo_path" id="profile_photo_path" accept="image/*"
                    class="@error('profile_photo_path') is-error @enderror" />
            </label>
        </div>
        @error('profile_photo_path')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z" />
            </svg>
            {{ __('profile.edit_profile_button') }}
        </button>
    </div>
</form>
</section>

<!-- ===== SECTION: Wachtwoord ===== -->
<section id="section-wachtwoord" class="card section-panel">
    <div class="card-header">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM12 17c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2z" />
        </svg>
        {{ __('profile.password_title') }}
    </div>

    <form action="{{ route('profile.update-password') }}" method="POST" class="card-body">
        @csrf

        <div class="form-group">
            <label for="current_password">{{ __('profile.password_current') }}</label>
            <div class="input-password-wrap">
                <input type="password" name="current_password" id="current_password" placeholder="••••••••"
                    class="@error('current_password') is-error @enderror" />
                <button type="button" class="toggle-pw" onclick="togglePasswordVisibility('current_password')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                    </svg>
                </button>
            </div>
            @error('current_password')
                <p class="field-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">{{ __('profile.password_new') }}</label>
                <div class="input-password-wrap">
                    <input type="password" name="password" id="password" placeholder="Minimaal 8 tekens"
                        class="@error('password') is-error @enderror" />
                    <button type="button" class="toggle-pw" onclick="togglePasswordVisibility('password')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                        </svg>
                    </button>
                </div>
                <p class="field-hint">Minimaal 8 tekens.</p>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{ __('profile.password_confirm') }}</label>
                <div class="input-password-wrap">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Herhaal nieuw wachtwoord" />
                    <button type="button" class="toggle-pw"
                        onclick="togglePasswordVisibility('password_confirmation')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z" />
                </svg>
                {{ __('profile.password_button') }}
            </button>
        </div>
    </form>
</section>

<!-- ===== SECTION: E-mail wijzigen ===== -->
<section id="section-email" class="card section-panel">
    <div class="card-header">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
        </svg>
        {{ __('profile.email_title') }}
    </div>

    <div class="card-body">
        @if (session('email_change_status') === 'email_verification_sent')
            <div class="alert alert-info mb-4">{{ __('profile.email_verification_sent') }}</div>
        @endif

        @if ($user->email_verified_at)
            <!-- Verified: show change form -->
            <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                @csrf
                <div class="info-row">
                    <div>
                        <p class="label-small">{{ __('profile.email_current') }}</p>
                        <p class="value-text">{{ $user->email }}</p>
                    </div>
                    <span class="input-badge verified">{{ __('profile.badge_verified') }}</span>
                </div>

                <div class="alert alert-info">
                    Na het wijzigen ontvang je een verificatiecode op je nieuwe adres.
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex:1">
                        <label for="new_email">{{ __('profile.email_new') }}</label>
                        <input type="email" name="email" id="new_email" placeholder="nieuw@voorbeeld.nl"
                            class="@error('email') is-error @enderror" />
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group align-end">
                        <button type="submit" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                            </svg>
                            Stuur code
                        </button>
                    </div>
                </div>
            </form>

            @if (session('email_change_status') === 'email_verification_sent')
                <form action="{{ route('profile.email.verify') }}" method="POST" class="space-y-4 mt-4">
                    @csrf
                    <div class="form-group">
                        <label for="email_code">{{ __('profile.email_verification_code') }}</label>
                        <div class="otp-row">
                            <input type="text" name="email_code" id="email_code" maxlength="6"
                                placeholder="_ _ _ _ _ _" value="{{ old('email_code') }}"
                                class="otp-input @error('email_code') is-error @enderror" />
                            <button type="submit" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                </svg>
                                {{ __('profile.email_verify') }}
                            </button>
                        </div>
                        <p class="field-hint">De code is 15 minuten geldig.</p>
                        @error('email_code')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            @endif
        @else
            <!-- Not verified yet -->
            @if (session('email_change_status') === 'email_verification_sent')
                <form action="{{ route('profile.email.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    <p class="text-muted">We hebben een verificatiecode naar je nieuwe email adres verstuurd.</p>
                    <div class="form-group">
                        <label for="email_code">{{ __('profile.email_verification_code') }}</label>
                        <div class="otp-row">
                            <input type="text" name="email_code" id="email_code" maxlength="6"
                                placeholder="_ _ _ _ _ _" value="{{ old('email_code') }}"
                                class="otp-input @error('email_code') is-error @enderror" />
                            <button type="submit" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                </svg>
                                {{ __('profile.email_verify') }}
                            </button>
                        </div>
                        <p class="field-hint">De code is 15 minuten geldig.</p>
                        @error('email_code')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <a href="{{ route('profile.show') }}" class="btn btn-ghost">Annuleren</a>
                </form>
            @else
                <div class="alert alert-warning mb-4">
                    <strong>{{ __('profile.alert_email_change_status') }}:</strong> Je email adres is nog niet
                    geverifieerd.
                </div>
                <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="form-row">
                        <div class="form-group" style="flex:1">
                            <label for="email_input">{{ __('profile.edit_profile_email') }}</label>
                            <input type="email" name="email" id="email_input" placeholder="jan@voorbeeld.nl"
                                value="{{ old('email', $user->email) }}"
                                class="@error('email') is-error @enderror" />
                            @error('email')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group align-end">
                            <button type="submit" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                </svg>
                                {{ __('profile.email_change') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        @endif
    </div>
</section>

<!-- ===== SECTION: Telefoon Verificatie ===== -->
<section id="section-telefoon" class="card section-panel">
    <div class="card-header">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.18 21 3 13.82 3 5a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z" />
        </svg>
        {{ __('profile.phone_title') }}
    </div>

    <div class="card-body">
        @if (session('status') === 'sms_sent')
            <div class="alert alert-info">{{ __('profile.phone_sms_sent') }}</div>
        @elseif (session('status') === 'phone_verified')
            <div class="alert alert-success">{{ __('profile.phone_verified') }}</div>
        @endif

        @if ($user->phone_verified && $user->phone_number)
            <div class="info-row">
                <div>
                    <p class="label-small">{{ __('profile.sidebar_phone') }}</p>
                    <p class="value-text">{{ $user->phone_number }}</p>
                </div>
                <span class="input-badge verified">{{ __('profile.badge_verified') }}</span>
            </div>
            <p class="field-hint mt-2">{{ __('profile.phone_verified_hint') }}</p>
        @elseif (!$user->phone_number)
            <form action="{{ route('phone.send') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-row">
                    <div class="form-group" style="flex:1">
                        <label for="phone_number_input">{{ __('profile.sidebar_phone') }}</label>
                        <input type="tel" name="phone_number" id="phone_number_input"
                            placeholder="+31 6 12345678" value="{{ old('phone_number') }}"
                            class="@error('phone_number') is-error @enderror" />
                        <p class="field-hint">Gebruik internationaal formaat, bijv. +31612345678</p>
                        @error('phone_number')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group align-end">
                        <button type="submit" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                            </svg>
                            {{ __('profile.phone_send_code') }}
                        </button>
                    </div>
                </div>
            </form>
        @else
            <form action="{{ route('phone.verify') }}" method="POST" class="space-y-4">
                @csrf
                <p class="text-muted">We hebben een verificatiecode naar <strong>{{ $user->phone_number }}</strong>
                    gestuurd.</p>
                <div class="form-group">
                    <label for="verification_code">{{ __('profile.phone_verification_code') }}</label>
                    <div class="otp-row">
                        <input type="text" name="code" id="verification_code" maxlength="6"
                            placeholder="_ _ _ _ _ _" value="{{ old('code') }}"
                            class="otp-input @error('code') is-error @enderror" />
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                            </svg>
                            {{ __('profile.phone_verify') }}
                        </button>
                    </div>
                    <p class="field-hint">De code is 10 minuten geldig.</p>
                    @error('code')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <a href="{{ route('profile.show') }}" class="btn btn-ghost">{{ __('profile.phone_cancel') }}</a>
            </form>
        @endif
    </div>
</section>

</main>
</div>
</div>

<style>
    /* ===== RESET & BASE ===== */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* ===== CSS VARIABLES ===== */
    :root {
        --bg: #111214;
        --surface: #1a1c1f;
        --surface-2: #212326;
        --border: #2a2c30;
        --border-hover: #3a3c42;
        --text: #e8e9eb;
        --text-muted: #6b7280;
        --text-dim: #9ca3af;
        --accent: #4ade80;
        --accent-dim: rgba(74, 222, 128, .15);
        --accent-dark: #22c55e;
        --danger: #f87171;
        --warning: #fbbf24;
        --info: #60a5fa;
        --radius: 10px;
        --radius-sm: 6px;
        --transition: .18s ease;
        --font: 'Inter', system-ui, sans-serif;
    }

    /* ===== PAGE SHELL ===== */
    .profile-page {
        background: var(--bg);
        min-height: 100vh;
        font-family: var(--font);
        color: var(--text);
        padding: 2rem 1.5rem;
    }

    .profile-layout {
        max-width: 1080px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .75rem;
        position: sticky;
        top: 1.5rem;
    }

    .sidebar-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        overflow: hidden;
        background: var(--surface-2);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        flex-shrink: 0;
    }

    .sidebar-avatar svg {
        width: 36px;
        height: 36px;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-identity {
        text-align: center;
    }

    .sidebar-name {
        font-size: .95rem;
        font-weight: 600;
        color: var(--text);
    }

    .sidebar-handle {
        font-size: .8rem;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .sidebar-bio {
        font-size: .8rem;
        color: var(--text-dim);
        text-align: center;
        line-height: 1.5;
    }

    .sidebar-bio.muted {
        color: var(--text-muted);
        font-style: italic;
    }

    .sidebar-divider {
        width: 100%;
        height: 1px;
        background: var(--border);
        margin: .25rem 0;
    }

    .sidebar-info {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .sidebar-info-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        color: var(--text-dim);
    }

    .sidebar-info-item svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        color: var(--text-muted);
    }

    .badge-verified {
        color: var(--accent);
        font-size: .7rem;
    }

    .badge-unverified {
        color: var(--warning);
        font-size: .7rem;
    }

    /* Sidebar nav */
    .sidebar-nav {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem .75rem;
        border-radius: var(--radius-sm);
        font-size: .84rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: background var(--transition), color var(--transition);
        cursor: pointer;
    }

    .sidebar-nav-item svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .sidebar-nav-item:hover {
        background: var(--surface-2);
        color: var(--text);
    }

    .sidebar-nav-item.active {
        background: var(--accent-dim);
        color: var(--accent);
        font-weight: 500;
    }

    /* ===== MAIN CONTENT ===== */
    .profile-main {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Section show/hide */
    .section-panel {
        display: none;
    }

    .section-panel.active {
        display: block;
    }

    /* ===== CARD ===== */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        font-size: .95rem;
        font-weight: 600;
        color: var(--text);
        background: var(--surface-2);
    }

    .card-header svg {
        width: 18px;
        height: 18px;
        color: var(--accent);
    }

    .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .card-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        background: var(--surface-2);
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
    }

    /* ===== FORM ===== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: .4rem;
    }

    .form-group.align-end {
        justify-content: flex-end;
    }

    label {
        font-size: .82rem;
        font-weight: 500;
        color: var(--text-dim);
        letter-spacing: .02em;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    textarea {
        background: var(--surface-2);
        border: 1px solid var(--border);
        color: var(--text);
        padding: .6rem .85rem;
        border-radius: var(--radius-sm);
        font-size: .88rem;
        font-family: inherit;
        width: 100%;
        transition: border-color var(--transition), box-shadow var(--transition);
        outline: none;
    }

    input::placeholder,
    textarea::placeholder {
        color: var(--text-muted);
    }

    input:focus,
    textarea:focus {
        border-color: var(--accent-dark);
        box-shadow: 0 0 0 3px rgba(74, 222, 128, .08);
    }

    input.is-error,
    textarea.is-error {
        border-color: var(--danger);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .field-hint {
        font-size: .75rem;
        color: var(--text-muted);
    }

    .field-error {
        font-size: .78rem;
        color: var(--danger);
    }

    /* Input with verification badge */
    .input-with-badge {
        display: flex;
        gap: .5rem;
        align-items: center;
    }

    .input-with-badge input {
        flex: 1;
    }

    .input-badge {
        white-space: nowrap;
        padding: .3rem .75rem;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .input-badge.verified {
        background: rgba(74, 222, 128, .12);
        color: var(--accent);
        border: 1px solid rgba(74, 222, 128, .3);
    }

    .input-badge.unverified {
        background: rgba(251, 191, 36, .12);
        color: var(--warning);
        border: 1px solid rgba(251, 191, 36, .3);
    }

    /* Password toggle */
    .input-password-wrap {
        position: relative;
    }

    .input-password-wrap input {
        padding-right: 2.8rem;
    }

    .toggle-pw {
        position: absolute;
        right: .7rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: .2rem;
        display: flex;
        align-items: center;
        transition: color var(--transition);
    }

    .toggle-pw:hover {
        color: var(--text);
    }

    .toggle-pw svg {
        width: 18px;
        height: 18px;
    }

    /* File upload */
    .file-upload-area {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .current-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
        flex-shrink: 0;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: var(--surface-2);
        border: 1px dashed var(--border-hover);
        padding: .75rem 1.25rem;
        border-radius: var(--radius-sm);
        font-size: .85rem;
        color: var(--text-dim);
        cursor: pointer;
        transition: border-color var(--transition), color var(--transition);
        flex: 1;
    }

    .file-upload-label:hover {
        border-color: var(--accent-dark);
        color: var(--text);
    }

    .file-upload-label svg {
        width: 18px;
        height: 18px;
        color: var(--accent);
    }

    .file-upload-label input[type="file"] {
        display: none;
    }

    /* OTP input */
    .otp-row {
        display: flex;
        gap: .75rem;
        align-items: center;
    }

    .otp-input {
        text-align: center;
        font-size: 1.4rem;
        letter-spacing: .35em;
        font-weight: 600;
        color: var(--accent) !important;
        flex: 1;
        padding: .6rem 1rem !important;
    }

    /* Info row (verified state) */
    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: .85rem 1rem;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
    }

    .label-small {
        font-size: .78rem;
        color: var(--text-muted);
        margin-bottom: 2px;
    }

    .value-text {
        font-size: .9rem;
        color: var(--text);
        font-weight: 500;
    }

    .text-muted {
        color: var(--text-muted);
        font-size: .88rem;
    }

    .mt-2 {
        margin-top: .5rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .space-y-4 {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .mt-4 {
        margin-top: 1rem;
    }

    /* ===== ALERTS ===== */
    .alert {
        padding: .8rem 1rem;
        border-radius: var(--radius-sm);
        font-size: .86rem;
        line-height: 1.5;
        border: 1px solid;
    }

    .alert-error {
        background: rgba(248, 113, 113, .08);
        border-color: rgba(248, 113, 113, .3);
        color: var(--danger);
    }

    .alert-success {
        background: rgba(74, 222, 128, .08);
        border-color: rgba(74, 222, 128, .3);
        color: var(--accent);
    }

    .alert-info {
        background: rgba(96, 165, 250, .08);
        border-color: rgba(96, 165, 250, .3);
        color: var(--info);
    }

    .alert-warning {
        background: rgba(251, 191, 36, .08);
        border-color: rgba(251, 191, 36, .3);
        color: var(--warning);
    }

    .alert ul {
        margin-top: .4rem;
        padding-left: 1.25rem;
    }

    .alert li {
        margin-top: .2rem;
    }

    /* ===== BUTTONS ===== */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1.1rem;
        border-radius: var(--radius-sm);
        font-size: .85rem;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        border: 1px solid transparent;
        text-decoration: none;
        transition: background var(--transition), box-shadow var(--transition), opacity var(--transition);
        white-space: nowrap;
    }

    .btn svg {
        width: 15px;
        height: 15px;
    }

    .btn:hover {
        opacity: .9;
    }

    .btn-primary {
        background: var(--accent-dark);
        color: #0a0e0a;
        border-color: var(--accent-dark);
    }

    .btn-primary:hover {
        background: var(--accent);
        border-color: var(--accent);
        box-shadow: 0 0 12px rgba(74, 222, 128, .25);
    }

    .btn-secondary {
        background: var(--surface-2);
        color: var(--text);
        border-color: var(--border-hover);
    }

    .btn-secondary:hover {
        border-color: var(--accent-dark);
        color: var(--accent);
    }

    .btn-success {
        background: rgba(74, 222, 128, .15);
        color: var(--accent);
        border-color: rgba(74, 222, 128, .4);
    }

    .btn-success:hover {
        background: rgba(74, 222, 128, .25);
        box-shadow: 0 0 10px rgba(74, 222, 128, .2);
    }

    .btn-ghost {
        background: transparent;
        color: var(--text-muted);
        border-color: var(--border);
    }

    .btn-ghost:hover {
        color: var(--text);
        border-color: var(--border-hover);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }

        .sidebar {
            position: static;
            flex-direction: column;
        }

        .sidebar-nav {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .otp-row {
            flex-direction: column;
        }

        .otp-row .btn {
            width: 100%;
            justify-content: center;
        }

        .input-with-badge {
            flex-wrap: wrap;
        }
    }
</style>

<script>
    function showSection(name, el) {
        // Hide all sections
        document.querySelectorAll('.section-panel').forEach(s => s.classList.remove('active'));
        // Remove active from all nav items
        document.querySelectorAll('.sidebar-nav-item').forEach(n => n.classList.remove('active'));
        // Show target section
        const target = document.getElementById('section-' + name);
        if (target) target.classList.add('active');
        // Mark nav item
        el.classList.add('active');
        // Prevent anchor jump
        return false;
    }

    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    // Auto-open section based on URL hash or session
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('email_change_status') === 'email_verification_sent')
            const emailLink = document.querySelector('[href="#email"]');
            if (emailLink) showSection('email', emailLink);
        @elseif (session('status') === 'sms_sent')
            const telLink = document.querySelector('[href="#telefoon"]');
            if (telLink) showSection('telefoon', telLink);
        @endif
    });
</script>
@endsection
