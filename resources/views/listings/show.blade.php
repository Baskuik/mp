@extends('layouts.app')

@section('title', $listing->title)

@section('content')
    <div class="bg-[#F7F5F2] py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-3/5">
                    <div class="bg-white rounded-3xl p-4 shadow-sm border border-[#2D6A4F]/10">
                        <div class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth">
                            @forelse ($images as $image)
                                <div class="snap-center min-w-full">
                                    <img
                                        class="w-full h-72 sm:h-80 object-cover rounded-2xl"
                                        src="{{ asset('storage/' . $image->path) }}"
                                        alt="{{ $listing->title }}">
                                </div>
                            @empty
                                <div class="w-full h-72 sm:h-80 rounded-2xl bg-[#2D6A4F]/10 flex items-center justify-center text-sm text-[#2D6A4F]">
                                    Geen afbeeldingen beschikbaar
                                </div>
                            @endforelse
                        </div>
                        <p class="mt-3 text-xs text-gray-400">Scroll horizontaal om alle foto's te bekijken.</p>
                    </div>

                    <div class="mt-6 bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                        <div class="flex flex-wrap items-center gap-3 text-xs">
                            @if ($listing->label)
                                <span class="px-3 py-1 rounded-full bg-[#F4A261]/20 text-[#b0642e] font-semibold">
                                    {{ $listing->label }}
                                </span>
                            @endif
                            <span class="text-gray-400">Geplaatst {{ $listing->created_at->diffForHumans() }}</span>
                            <span class="text-gray-400">{{ $listing->category?->name ?? 'Algemeen' }}</span>
                        </div>
                        <h1 class="mt-4 text-3xl font-semibold text-[#1f4a34]">{{ $listing->title }}</h1>
                        <p class="mt-2 text-[#2D6A4F] text-2xl font-semibold">
                            EUR {{ number_format($listing->price, 2, ',', '.') }}
                        </p>
                        <div class="mt-4 text-sm text-gray-600 leading-relaxed">
                            {{ $listing->description }}
                        </div>
                    </div>
                </div>

                <div class="lg:w-2/5 space-y-6">
                    @if (auth()->check() && auth()->user()->user_id === $listing->user_id)
                        <div class="bg-[#2D6A4F]/10 rounded-2xl px-4 py-3 text-sm text-[#1f4a34]">
                            Je bekijkt je eigen advertentie, exact zoals andere gebruikers deze zien.
                        </div>
                    @endif

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#2D6A4F]">Verkoper</p>
                        <div class="mt-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-[#2D6A4F]/10 flex items-center justify-center text-[#2D6A4F]">
                                <span class="text-lg font-semibold">
                                    {{ strtoupper(substr($listing->user?->name ?? 'V', 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-[#1f4a34]">
                                    {{ $listing->user?->name ?? 'Verkoper' }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $listing->user?->email ?? '' }}</p>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <a
                                href="{{ route('home') }}"
                                class="flex-1 text-center rounded-xl border border-[#2D6A4F]/20 px-4 py-3 text-sm font-semibold text-[#2D6A4F]">
                                Terug naar home
                            </a>
                            @auth
                                <a
                                    href="{{ route('profile') }}"
                                    class="flex-1 text-center rounded-xl bg-[#2D6A4F] px-4 py-3 text-sm font-semibold text-white">
                                    Naar profiel
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                        <h2 class="text-lg font-semibold text-[#1f4a34]">Highlights</h2>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li>Afspraak maken direct in de chat.</li>
                            <li>Veilig betalen met DirectDeal Plus.</li>
                            <li>Ophalen of verzenden in overleg.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
