@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <a href="{{ route('profile.public', $user) }}" target="_blank"
   class="inline-flex items-center gap-2 mt-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700">
    Bekijk mijn profiel als anderen
</a><a href="{{ route('profile.public', $user) }}" target="_blank"
   class="inline-flex items-center gap-2 mt-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700">
    Bekijk mijn profiel als anderen
</a>
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
                        <a href="#badge-settings"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#badge-settings')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                Badge instellingen
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

                    <!-- SECTION: Badge Settings -->
                    <div id="badge-settings" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Badge instellingen</h2>
                            <p class="text-sm text-gray-500 mt-1">Kies welke badges zichtbaar zijn op jouw profiel.</p>
                        </div>

                        <form action="{{ route('profile.badges') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="divide-y divide-gray-100">

                                @if($user->is_premium)
                                <div class="flex items-center gap-4 px-6 py-4">
                                    <div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Premium</p>
                                        <p class="text-xs text-gray-500">Toont dat je een premium account hebt</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="show_badge_premium" value="0">
                                        <input type="checkbox" name="show_badge_premium" value="1" class="sr-only peer"
                                            {{ $user->show_badge_premium ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-purple-600 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>
                                @endif

                                @if($user->email_verified_at)
                                <div class="flex items-center gap-4 px-6 py-4">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">E-mail geverifieerd</p>
                                        <p class="text-xs text-gray-500">Toont dat jouw e-mailadres bevestigd is</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="show_badge_email" value="0">
                                        <input type="checkbox" name="show_badge_email" value="1" class="sr-only peer"
                                            {{ $user->show_badge_email ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>
                                @endif

                                @if($user->number_verified_at)
                                <div class="flex items-center gap-4 px-6 py-4">
                                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Telefoon geverifieerd</p>
                                        <p class="text-xs text-gray-500">Toont dat jouw telefoonnummer bevestigd is</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="show_badge_phone" value="0">
                                        <input type="checkbox" name="show_badge_phone" value="1" class="sr-only peer"
                                            {{ $user->show_badge_phone ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </label>
                                </div>
                                @endif

                                @if(!$user->is_premium && !$user->email_verified_at && !$user->number_verified_at)
                                <div class="px-6 py-4 text-sm text-gray-400">
                                    Je hebt nog geen badges om te beheren.
                                </div>
                                @endif

                            </div>
                        </form>
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