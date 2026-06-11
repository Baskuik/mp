@extends('layouts.app')

@section('title', $user->name . ' – Profiel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10 space-y-8">

    {{-- ── PROFIEL HEADER ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600 flex-shrink-0">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <p class="text-xs text-gray-400 mt-1">Lid sinds {{ $user->created_at->translatedFormat('F Y') }}</p>
        </div>
        @if($user->is_premium)
            <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm font-semibold">
                ⭐ Premium
            </span>
        @endif
    </div>

    {{-- ── STATISTIEKEN WIDGET ── --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Jouw statistieken</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <p class="text-3xl font-bold text-indigo-600">{{ $stats['listings'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Advertenties</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <p class="text-3xl font-bold text-emerald-600">{{ $stats['bids'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Gedane biedingen</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <p class="text-3xl font-bold text-amber-500">{{ $stats['reviews'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Reviews ontvangen</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <p class="text-3xl font-bold text-gray-700">
                    {{ $stats['avg_rating'] > 0 ? number_format($stats['avg_rating'], 1) : '–' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">Gem. beoordeling</p>
            </div>
        </div>
    </div>

    {{-- ── PREMIUM UPGRADE WIDGET (alleen voor niet-premium gebruikers die ingelogd zijn) ── --}}
    @auth
        @if(auth()->id() === $user->id && !$user->is_premium)
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="text-3xl">⭐</div>
                    <div class="flex-1">
                        <h3 class="font-bold text-amber-800 text-lg mb-1">Word Premium lid</h3>
                        <p class="text-amber-700 text-sm mb-4">
                            Met Premium krijg je meer zichtbaarheid, onbeperkte advertenties en toegang tot exclusieve functies.
                        </p>
                        <ul class="space-y-1 text-sm text-amber-700 mb-5">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                                    01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Onbeperkte advertenties plaatsen
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                                    01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Uitgelichte plaatsing in zoekresultaten
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                                    01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Premium badge op je profiel
                            </li>
                        </ul>
                        <a
                            href="{{ route('premium.index') }}"
                            class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold
                                   px-6 py-2.5 rounded-xl transition shadow"
                        >
                            Upgrade voor €9,99/maand
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- ── PROFIELFORMULIER ── --}}
    @auth
        @if(auth()->id() === $user->id)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-5">Profiel bewerken</h2>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Naam</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">E-mailadres</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        />
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl transition"
                        >
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

</div>
@endsection
