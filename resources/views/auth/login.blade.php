@extends('layouts.auth')
@section('title', 'Inloggen')

@section('content')
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        {{-- Linkerpaneel --}}
        <div class="hidden lg:flex flex-col justify-between bg-[#2D6A4F] p-12 relative overflow-hidden">
            {{-- Decoratieve cirkels --}}
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-16 -left-16 w-72 h-72 rounded-full bg-white/4"></div>

            {{-- Logo --}}
            <div class="font-display text-2xl text-white relative z-10">
                Direct<span class="text-[#F4A261]">Deal</span>
            </div>

            {{-- Hero tekst --}}
            <div class="relative z-10">
                <h1 class="font-display text-5xl text-white leading-tight mb-4">
                    Koop & verkoop<br>
                    <em class="text-[#F4A261] not-italic font-display">lokaal & eerlijk</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Duizenden advertenties in jouw buurt. Snel, veilig en persoonlijk.
                </p>
            </div>

            {{-- Stats --}}
            <div class="flex gap-10 relative z-10">
                <div>
                    <strong class="block font-display text-2xl text-white">12.400+</strong>
                    <span class="text-white/50 text-sm">Advertenties</span>
                </div>
                <div>
                    <strong class="block font-display text-2xl text-white">3.800+</strong>
                    <span class="text-white/50 text-sm">Gebruikers</span>
                </div>
                <div>
                    <strong class="block font-display text-2xl text-white">98%</strong>
                    <span class="text-white/50 text-sm">Tevreden kopers</span>
                </div>
            </div>
        </div>

        {{-- Rechterpaneel --}}
        <div class="flex items-center justify-center px-6 py-12 lg:px-16">
            <div class="w-full max-w-md">

                {{-- Mobile logo --}}
                <div class="font-display text-2xl text-[#2D6A4F] mb-8 lg:hidden">
                    Markt<span class="text-[#F4A261]">plaats</span>
                </div>

                {{-- Header --}}
                <div class="mb-8">
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Welkom terug</h2>
                    <p class="text-gray-500 text-sm">
                        Nog geen account?
                        <a href="{{ route('register.step1') }}"
                            class="text-[#2D6A4F] font-medium hover:underline">Registreer hier</a>
                    </p>
                </div>

                {{-- Foutmelding --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                        <p class="text-red-600 text-sm">{{ $errors->first() }}</p>
                    </div>
                @endif

                {{-- Formulier --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

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
                                autofocus placeholder="jouw@email.nl"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('email') border-red-400 @enderror">
                        </div>
                    </div>

                    {{-- Wachtwoord --}}
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Wachtwoord
                            </label>
                            <a href="{{ route('password.request') }}" class="text-xs text-[#2D6A4F] hover:underline">
                                Vergeten?
                            </a>
                        </div>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password" required placeholder="••••••••"
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
                    </div>

                    {{-- Onthoud mij --}}
                    <div class="flex items-center gap-2.5">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-[#2D6A4F] focus:ring-[#2D6A4F]/20 cursor-pointer">
                        <label for="remember" class="text-sm text-gray-600 cursor-pointer">
                            Onthoud mij
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98]">
                        Inloggen
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
