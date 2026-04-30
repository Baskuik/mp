@extends('layouts.auth')
@section('title', 'Registreren - Stap 1')

@section('content')
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        {{-- Linkerpaneel --}}
        <div class="hidden lg:flex flex-col justify-between bg-[#2D6A4F] p-12 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full bg-white/4"></div>

            <div class="font-display text-2xl text-white relative z-10">
                Direct<span class="text-[#F4A261]">Deal</span>
            </div>

            <div class="relative z-10">
                <h1 class="font-display text-5xl text-white leading-tight mb-4">
                    Jouw eerste<br>
                    <em class="text-[#F4A261] not-italic font-display">advertentie wacht</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Maak gratis een account aan en zet je eerste advertentie live in minder dan 2 minuten.
                </p>
            </div>

            {{-- Stappen indicator --}}
            <div class="flex justify-start items-end gap-4 relative z-10">
                @foreach (['Account aanmaken', 'Profiel inrichten', 'Email verifiëren'] as $index => $title)
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold 
                            @if ($index === 0) bg-[#F4A261] text-[#2D6A4F]
                            @else 
                                bg-white/20 text-white @endif
                            transition-all duration-300">
                            {{ $index + 1 }}
                        </div>
                        <p class="text-white/70 text-xs text-center max-w-20">{{ $title }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Rechterpaneel --}}
        <div class="flex items-center justify-center px-6 py-12 lg:px-16">
            <div class="w-full max-w-md">

                {{-- Mobile logo --}}
                <div class="font-display text-2xl text-[#2D6A4F] mb-8 lg:hidden">
                    Direct<span class="text-[#F4A261]">Deal</span>
                </div>

                {{-- Step indicator mobile --}}
                <div class="lg:hidden mb-8 flex justify-center items-end gap-2">
                    @foreach (['1', '2', '3'] as $index => $num)
                        <div class="flex flex-col items-center gap-1">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold 
                                @if ($index === 0) bg-[#2D6A4F] text-white
                                @else 
                                    bg-gray-200 text-gray-600 @endif
                                transition-all">
                                {{ $num }}
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Header --}}
                <div class="mb-8">
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Account aanmaken</h2>
                    <p class="text-gray-500 text-sm">
                        Al een account?
                        <a href="{{ route('login') }}" class="text-[#2D6A4F] font-medium hover:underline">Log hier in</a>
                    </p>
                </div>

                {{-- Foutmeldingen --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Formulier --}}
                <form method="POST" action="{{ route('register.step1.post') }}" class="space-y-4" novalidate>
                    @csrf

                    {{-- Naam --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Volledige naam
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus placeholder="Jan de Vries"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('name') border-red-400 @enderror">
                        </div>
                    </div>

                    {{-- E-mail --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            E-mailadres
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="jouwemail@example.com"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('email') border-red-400 @enderror">
                        </div>
                    </div>

                    {{-- Wachtwoord --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Wachtwoord
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password" required
                                placeholder="Wachtwoord (minimaal 8 tekens)"
                                class="w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('password') border-red-400 @enderror">
                            <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        {{-- Wachtwoordsterkte indicator --}}
                        <div class="mt-2 flex gap-1.5" id="strength-bars">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-1">
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-2">
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-3">
                            </div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-4">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1" id="strength-label"></p>
                    </div>

                    {{-- Wachtwoord bevestigen --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Wachtwoord bevestigen
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="Herhaal je wachtwoord"
                                class="w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all">
                            <button type="button" onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Voorwaarden --}}
                    <div class="flex items-start gap-2.5 pt-1">
                        <input id="terms" type="checkbox" name="terms" required
                            class="w-4 h-4 mt-0.5 rounded border-gray-300 text-[#2D6A4F] focus:ring-[#2D6A4F]/20 cursor-pointer">
                        <label for="terms" class="text-sm text-gray-600 cursor-pointer leading-snug">
                            Ik ga akkoord met de
                            <a href="#" class="text-[#2D6A4F] hover:underline">algemene voorwaarden</a>
                            en het
                            <a href="#" class="text-[#2D6A4F] hover:underline">privacybeleid</a>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98] mt-2">
                        Volgende
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            btn.innerHTML = isPassword ?
                `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>` :
                `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
        }
    </script>
@endsection
