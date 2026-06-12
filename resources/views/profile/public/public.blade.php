@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4">

            @auth
                @if (auth()->id() === $user->user_id)
                    <div class="mb-4 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                        <p class="text-blue-700 text-sm">
                            Dit is hoe anderen jouw profiel zien.
                            <a href="{{ route('profile.show') }}" class="font-medium underline">Terug naar je instellingen</a>
                        </p>
                    </div>
                @endif
            @endauth

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-6 flex items-center gap-4">
                    @if ($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profielfoto"
                             class="w-16 h-16 rounded-full object-cover border border-gray-300" />
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1">
                        <h1 class="text-xl font-bold text-gray-900">{{ $user->name }}</h1>
                        @if ($user->username)
                            <p class="text-sm text-gray-500">@{{ $user->username }}</p>
                        @endif
                    </div>
                </div>

                <div class="px-6 pb-4 flex flex-wrap gap-2">
                    @if ($user->show_badge_premium && $user->is_premium)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                            ⭐ Premium
                        </span>
                    @endif

                    @if ($user->show_badge_email && $user->email_verified_at)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                            ✓ E-mail geverifieerd
                        </span>
                    @endif

                    @if ($user->show_badge_phone && $user->phone_verified)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                            ✓ Telefoon geverifieerd
                        </span>
                    @endif
                </div>

                @if ($user->bio)
                    <div class="px-6 pb-6 border-t border-gray-100 pt-4">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $user->bio }}</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection