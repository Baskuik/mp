@extends('layouts.app')

@section('title', 'Mijn Profiel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Mijn Profiel</h1>
                <p class="text-gray-600 dark:text-gray-400">Beheer je persoonlijke gegevens en beveiligingsinstellingen</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                    <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">Fouten gevonden</h3>
                    <ul class="list-disc list-inside text-red-700 dark:text-red-300 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                    <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('email_change_status') === 'email_verification_sent')
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                    <p class="text-blue-800 dark:text-blue-200"><strong>⚠️ Email wijzigingsverzoek:</strong> We hebben een
                        verificatiecode naar je nieuwe email adres verstuurd. Voer de code in om je email adres te
                        verifiëren.</p>
                </div>
            @endif

            <!-- Profiel Gegevens Form -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Persoonlijke Gegevens</h2>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Volledige Naam -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Volledige Naam
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                placeholder="Jan de Vries"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('name') border-red-500 @enderror" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gebruikersnaam -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Gebruikersnaam
                            </label>
                            <input type="text" name="username" id="username"
                                value="{{ old('username', $user->username) }}" placeholder="jandevries"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('username') border-red-500 @enderror" />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Alleen letters, cijfers, koppeltekens
                                en underscores.</p>
                            @error('username')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- E-mailadres -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-mailadres
                        </label>
                        <div class="flex gap-2">
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                placeholder="jan@voorbeeld.nl"
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror" />
                            <div class="flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                @if ($user->email_verified_at)
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        ✓ Geverifieerd
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        ⚠ Niet geverifieerd
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Als je dit wijzigt, moet je het adres
                            opnieuw verifiëren.</p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefoonnummer -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Telefoonnummer
                        </label>
                        <div class="flex gap-2">
                            <input type="tel" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}" placeholder="+31 6 12345678"
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('phone_number') border-red-500 @enderror" />
                            <div class="flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                @if ($user->phone_verified)
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        ✓ Geverifieerd
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        ⚠ Niet geverifieerd
                                    </span>
                                @endif
                            </div>
                        </div>
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Bio
                        </label>
                        <textarea name="bio" id="bio" placeholder="Vertel iets over jezelf…" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximaal 500 tekens.</p>
                        @error('bio')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profielfoto -->
                    <div>
                        <label for="profile_photo_path"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Profielfoto
                        </label>
                        <div class="flex gap-6">
                            @if ($user->profile_photo_path)
                                <div class="flex-shrink-0">
                                    <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profielfoto"
                                        class="h-24 w-24 rounded-full object-cover" />
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="profile_photo_path" id="profile_photo_path" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    dark:file:bg-indigo-900 dark:file:text-indigo-200
                                    @error('profile_photo_path') border-red-500 @enderror" />
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Maximaal 5MB. PNG, JPG, GIF of
                                    JPEG.</p>
                                @error('profile_photo_path')
                                    <p class="text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            Profiel Opslaan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Wachtwoord Wijzigen Form -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Beveiliging</h2>
                </div>

                <form action="{{ route('profile.update-password') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Huidig Wachtwoord -->
                    <div>
                        <label for="current_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Hudig Wachtwoord
                        </label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                placeholder="Voer je huige wachtwoord in"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white pr-12 @error('current_password') border-red-500 @enderror" />
                            <button type="button"
                                class="absolute right-4 top-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200"
                                onclick="togglePasswordVisibility('current_password')">
                                👁️
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nieuw Wachtwoord -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nieuw Wachtwoord
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Minimaal 8 tekens"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white pr-12 @error('password') border-red-500 @enderror" />
                            <button type="button"
                                class="absolute right-4 top-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200"
                                onclick="togglePasswordVisibility('password')">
                                👁️
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimaal 8 tekens.</p>
                        @error('password')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Wachtwoord Bevestigen -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Wachtwoord Bevestigen
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Herhaal het nieuwe wachtwoord"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white pr-12" />
                            <button type="button"
                                class="absolute right-4 top-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200"
                                onclick="togglePasswordVisibility('password_confirmation')">
                                👁️
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            Wachtwoord Wijzigen
                        </button>
                    </div>
                </form>
            </div>

            <!-- Telefoon Verificatie -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Telefoon Verificatie</h2>
                </div>

                <div class="p-6 space-y-6">
                    @if (session('status'))
                        @if (session('status') === 'sms_sent')
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                                <p class="text-blue-800 dark:text-blue-200">SMS verzonden! Voer je verificatiecode in.</p>
                            </div>
                        @elseif (session('status') === 'phone_verified')
                            <div
                                class="p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                                <p class="text-green-800 dark:text-green-200">Je telefoonnummer is succesvol geverifieerd!
                                </p>
                            </div>
                        @endif
                    @endif

                    @if ($user->phone_verified && $user->phone_number)
                        <!-- Phone is verified -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Telefoonnummer:</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $user->phone_number }}</p>
                                </div>
                                <span
                                    class="inline-block px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    ✓ Geverifieerd
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Je telefoonnummer is geverifieerd en kan
                                gebruikt worden voor beveiligingsdoeleinden.</p>
                        </div>
                    @else
                        <!-- Phone verification process -->
                        <div class="space-y-4">
                            @if (!$user->phone_number)
                                <!-- Step 1: Enter phone number -->
                                <form action="{{ route('phone.send') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="phone_number_input"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Telefoonnummer (Internationaal formaat)
                                        </label>
                                        <input type="tel" name="phone_number" id="phone_number_input"
                                            placeholder="+31 6 12345678" value="{{ old('phone_number') }}"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('phone_number') border-red-500 @enderror" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Gebruik internationaal
                                            formaat, bijv. +31612345678</p>
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        Verificatiecode Versturen
                                    </button>
                                </form>
                            @else
                                <!-- Step 2: Verify code -->
                                <form action="{{ route('phone.verify') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            We hebben een verificatiecode naar <strong>{{ $user->phone_number }}</strong>
                                            gestuurd.
                                        </p>
                                        <label for="verification_code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Verificatiecode (6 cijfers)
                                        </label>
                                        <input type="text" name="code" id="verification_code" maxlength="6"
                                            placeholder="000000" value="{{ old('code') }}"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('code') border-red-500 @enderror text-center text-2xl letter-spacing" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">De code is 10 minuten
                                            geldig.</p>
                                        @error('code')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex gap-3">
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                            Code Verifiëren
                                        </button>
                                        <a href="{{ route('profile.show') }}"
                                            class="px-6 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600">
                                            Annuleren
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Email Verificatie -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Email Verificatie</h2>
                </div>

                <div class="p-6 space-y-6">
                    @if (session('email_change_status') === 'email_verification_sent')
                        <div
                            class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <p class="text-blue-800 dark:text-blue-200">Verificatiecode verzonden! Voer de 6-cijferige code
                                in die je per email hebt ontvangen.</p>
                        </div>
                    @endif

                    @if ($user->email_verified_at)
                        <!-- Email is verified -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Email adres:</p>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                                <span
                                    class="inline-block px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    ✓ Geverifieerd
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Je email adres is geverifieerd en je
                                account is veilig.</p>

                            <!-- Option to change email -->
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Wil je je email adres
                                        wijzigen?</p>
                                    <div>
                                        <label for="new_email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nieuw Email Adres
                                        </label>
                                        <input type="email" name="email" id="new_email"
                                            placeholder="nieuw@voorbeeld.nl"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">⚠️ Je zult dit adres
                                            moeten verifiëren.</p>
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        Wijziging Aanvragen
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Email not verified yet -->
                        <div class="space-y-4">
                            @if (session('email_change_status') === 'email_verification_sent')
                                <!-- Step 2: Verify code -->
                                <form action="{{ route('profile.email.verify') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            We hebben een verificatiecode naar je nieuwe email adres verstuurd. Voer de code
                                            in om je email adres te wijzigen.
                                        </p>
                                        <label for="email_code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Verificatiecode (6 cijfers)
                                        </label>
                                        <input type="text" name="email_code" id="email_code" maxlength="6"
                                            placeholder="000000" value="{{ old('email_code') }}"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('email_code') border-red-500 @enderror text-center text-2xl letter-spacing" />
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">De code is 15 minuten
                                            geldig.</p>
                                        @error('email_code')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex gap-3">
                                        <button type="submit"
                                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                            Email Verifiëren
                                        </button>
                                        <a href="{{ route('profile.show') }}"
                                            class="px-6 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium rounded-lg hover:bg-gray-400 dark:hover:bg-gray-600">
                                            Annuleren
                                        </a>
                                    </div>
                                </form>
                            @else
                                <!-- Step 1: Enter new email -->
                                <form action="{{ route('profile.email.send') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div
                                        class="p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                                        <p class="text-sm text-yellow-800 dark:text-yellow-200"><strong>⚠️ Email
                                                Verificatie:</strong> Je email adres is nog niet geverifieerd. Voer je email
                                            in en we zullen een verificatiecode sturen.</p>
                                    </div>
                                    <div>
                                        <label for="email_input"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Adres
                                        </label>
                                        <input type="email" name="email" id="email_input"
                                            placeholder="jan@voorbeeld.nl" value="{{ old('email', $user->email) }}"
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror" />
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        Verificatiecode Versturen
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
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
