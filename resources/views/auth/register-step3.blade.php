@extends('layouts.auth')
@section('title', 'Registreren - Stap 3')

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
                    Je bent er<br>
                    <em class="text-[#F4A261] not-italic font-display">bijna</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Verifieer je email adres om je account te activeren en direct te starten!
                </p>
            </div>

            {{-- Stappen indicator --}}
            <div class="flex justify-start items-end gap-4 relative z-10">
                @foreach (['Account aanmaken', 'Profiel inrichten', 'Email verifiëren'] as $index => $title)
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold 
                            @if ($index === 2) bg-[#F4A261] text-[#2D6A4F]
                            @else
                                bg-white/40 text-white @endif
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
                                @if ($index === 2) bg-[#2D6A4F] text-white
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
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Email verifiëren</h2>
                    <p class="text-gray-500 text-sm">
                        Verifieer je email adres om je account te activeren
                    </p>
                </div>

                {{-- Email verification box --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl px-6 py-6 mb-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-blue-900">Email verificatie</h3>
                            <p class="text-sm text-blue-700 mt-2">
                                Je hebt een verificatiemail ontvangen op je inbox. Klik op de link in dat emailbericht om je
                                account te activeren.
                            </p>
                            <p class="text-sm text-blue-600 mt-3">
                                Heb je de email niet ontvangen? Controleer je spamfolder of klik op "Opnieuw versturen"
                                hieronder.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Verification code input (alternative) --}}
                <form method="POST" action="{{ route('register.step3') }}" class="space-y-5" novalidate>
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Of enter je verificatiecode
                        </label>
                        <input type="text" name="verification_code" maxlength="6" placeholder="000000"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all text-center tracking-widest font-mono">
                        <p class="text-xs text-gray-500 mt-2">6-cijferige code uit je email</p>
                    </div>

                    {{-- Already verified message --}}
                    <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                        <p class="text-sm text-green-700">
                            Je email is geverifieerd! Je kunt nu je account gebruiken.
                        </p>
                    </div>

                    {{-- Navigation buttons --}}
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('register.step2') }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98] text-center">
                            Terug
                        </a>
                        <button type="submit"
                            class="flex-1 bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98]">
                            Account activeren
                        </button>
                    </div>
                </form>

                {{-- Resend link --}}
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Verificatiemail niet ontvangen?
                        <button type="button" onclick="alert('Email zou opnieuw verstuurd worden (Mailtrap integratie)')"
                            class="text-[#2D6A4F] font-medium hover:underline">
                            Opnieuw versturen
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
