@extends('layouts.app')

@section('title', 'Instellingen')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10 space-y-8">

    <h1 class="text-2xl font-bold text-gray-900">Instellingen</h1>

    {{-- ── ACCOUNT STATUS WIDGET ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0
                         00-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622
                         5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Accountstatus
        </h2>

        <div class="space-y-3">
            {{-- E-mailverificatie --}}
            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0
                                 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">E-mailverificatie</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                @if(auth()->user()->email_verified_at)
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                            01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Geverifieerd
                    </span>
                @else
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            Niet geverifieerd
                        </span>
                        <form action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-indigo-600 hover:underline">Stuur opnieuw</button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Account actief / geband --}}
            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Accountstatus</p>
                        <p class="text-xs text-gray-400">Zichtbaarheid & toegang</p>
                    </div>
                </div>
                @if(auth()->user()->is_banned)
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        🚫 Geband
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        ✓ Actief
                    </span>
                @endif
            </div>

            {{-- Premium status --}}
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462
                                 c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921
                                 -.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838
                                 -.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81
                                 .588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Premium abonnement</p>
                        <p class="text-xs text-gray-400">€9,99 per maand</p>
                    </div>
                </div>
                @if(auth()->user()->is_premium)
                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        ⭐ Actief
                    </span>
                @else
                    <a
                        href="{{ route('premium.index') }}"
                        class="text-xs bg-amber-500 hover:bg-amber-600 text-white font-semibold px-3 py-1.5 rounded-lg transition"
                    >
                        Upgrade
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ── WACHTWOORD WIJZIGEN ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-5">Wachtwoord wijzigen</h2>

        <form action="{{ route('settings.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Huidig wachtwoord</label>
                <input
                    type="password"
                    name="current_password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                />
                @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nieuw wachtwoord</label>
                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                />
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Herhaal nieuw wachtwoord</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                />
            </div>

            <div class="flex justify-end pt-2">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl transition"
                >
                    Wachtwoord bijwerken
                </button>
            </div>
        </form>
    </div>

    {{-- ── ACCOUNT VERWIJDEREN ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
        <h2 class="text-base font-semibold text-red-700 mb-2">Account verwijderen</h2>
        <p class="text-sm text-gray-500 mb-4">
            Door je account te verwijderen worden al je advertenties, biedingen en berichten permanent gewist.
            Dit kan niet ongedaan worden gemaakt.
        </p>
        <form action="{{ route('settings.destroy') }}" method="POST"
              onsubmit="return confirm('Weet je het zeker? Dit kan niet ongedaan worden gemaakt.')">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-xl transition text-sm"
            >
                Account definitief verwijderen
            </button>
        </form>
    </div>

</div>
@endsection
