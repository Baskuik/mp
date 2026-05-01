@extends('layouts.auth')
@section('title', 'Wachtwoord vergeten')

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
                    Wachtwoord<br>
                    <em class="text-[#F4A261] not-italic font-display">vergeten?</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Geen zorgen. Vul je e-mailadres in en we sturen je een link om een nieuw wachtwoord in te stellen.
                </p>
            </div>

            {{-- Info blokjes --}}
            <div class="flex flex-col gap-4 relative z-10">
                @foreach ([
                    ['01', 'Vul je e-mailadres in', 'Het adres waarmee je bent geregistreerd'],
                    ['02', 'Ontvang de resetlink', 'Check ook je spamfolder'],
                    ['03', 'Stel nieuw wachtwoord in', 'Veilig en direct inloggen'],
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
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Wachtwoord vergeten</h2>
                    <p class="text-gray-500 text-sm">
                        Weet je het toch nog?
                        <a href="{{ route('login') }}" class="text-[#2D6A4F] font-medium hover:underline">Log hier in</a>
                    </p>
                </div>

                {{-- Succesmelding --}}
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-4 py-4 flex gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                    </div>
                @endif

                {{-- Foutmeldingen --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Formulier --}}
                <form method="POST" action="{{ route('password.send') }}" class="space-y-5" novalidate>
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

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98]">
                        Stuur resetlink
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
@endsection