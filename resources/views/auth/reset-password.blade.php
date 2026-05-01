@extends('layouts.auth')
@section('title', 'Nieuw wachtwoord instellen')

@section('content')
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        {{-- Linkerpaneel --}}
        <div class="hidden lg:flex flex-col justify-between bg-[#2D6A4F] p-12 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full bg-white/4"></div>

            {{-- Logo --}}
            <div class="font-display text-2xl text-white relative z-10">
                Direct<span class="text-[#F4A261]">Deal</span>
            </div>

            {{-- Hero tekst --}}
            <div class="relative z-10">
                <h1 class="font-display text-5xl text-white leading-tight mb-4">
                    Nieuw<br>
                    <em class="text-[#F4A261] not-italic font-display">wachtwoord</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Kies een sterk wachtwoord om je account te beveiligen.
                </p>
            </div>

            {{-- Tips --}}
            <div class="flex flex-col gap-4 relative z-10">
                @foreach ([
                    ['01', 'Minimaal 8 tekens', 'Hoe langer, hoe veiliger'],
                    ['02', 'Gebruik cijfers & symbolen', 'Verhoogt de beveiliging sterk'],
                    ['03', 'Uniek wachtwoord', 'Gebruik dit nergens anders'],
                ] as [$num, $title, $sub])
                    <div class="flex items-center gap-4">
                        <span class="font-display text-[#F4A261] text-sm">{{ $num }}</span>
                        <div>
                            <p class="text-white text-sm font-medium">{{ $title }}</p>
                            <p class="text-white/50 text-xs">{{ $sub }}</p>
                        </div>
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

                {{-- Header --}}
                <div class="mb-8">
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Nieuw wachtwoord</h2>
                    <p class="text-gray-500 text-sm">
                        Kies een sterk wachtwoord van minimaal 8 tekens.
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
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5" novalidate>
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

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
                            <input id="email" type="email" name="email" value="{{ old('email', $email) }}"
                                required placeholder="jouw@email.nl" readonly
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-500 bg-gray-50 cursor-not-allowed placeholder-gray-400 focus:outline-none transition-all @error('email') border-red-400 @enderror">
                        </div>
                    </div>

                    {{-- Nieuw wachtwoord --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nieuw wachtwoord
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
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
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-1"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-2"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-3"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="bar-4"></div>
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
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Herhaal je nieuwe wachtwoord"
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

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98]">
                        Wachtwoord opslaan
                    </button>

                    {{-- Terug naar login --}}
                    <a href="{{ route('login') }}"
                        class="w-full flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Terug naar inloggen
                    </a>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Wachtwoordsterkte indicator
        document.getElementById('password').addEventListener('input', function() {
            const val = this.value;
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-[#2D6A4F]'];
            const labels = ['Zwak', 'Matig', 'Goed', 'Sterk'];

            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('bar-' + i);
                bar.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' +
                    (i <= strength ? colors[strength - 1] : 'bg-gray-200');
            }

            const label = document.getElementById('strength-label');
            label.textContent = val.length > 0 ? (labels[strength - 1] ?? '') : '';
            label.className = 'text-xs mt-1 ' + (
                strength <= 1 ? 'text-red-400' :
                strength === 2 ? 'text-orange-400' :
                strength === 3 ? 'text-yellow-500' :
                'text-[#2D6A4F]'
            );
        });
    </script>
@endsection