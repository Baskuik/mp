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
                        @if (($listing->listing_type ?? 'fixed') === 'bidding')
                            <div class="mt-2 flex flex-wrap items-center gap-3 text-[#2D6A4F] text-lg font-semibold">
                                <span>Bieden</span>
                                @if ($highestBid !== null)
                                    <span>Huidig bod: EUR {{ number_format($highestBid, 2, ',', '.') }}</span>
                                @elseif ($listing->price !== null)
                                    <span>Startprijs: EUR {{ number_format($listing->price, 2, ',', '.') }}</span>
                                @else
                                    <span>Geen startprijs ingesteld</span>
                                @endif
                            </div>
                        @else
                            <p class="mt-2 text-[#2D6A4F] text-2xl font-semibold">
                                EUR {{ number_format($listing->price, 2, ',', '.') }}
                            </p>
                        @endif
                        <div class="mt-4 text-sm text-gray-600 leading-relaxed">
                            {{ $listing->description }}
                        </div>
                    </div>
                </div>

                <div class="lg:w-2/5 space-y-6">
                    @if (session('status'))
                        <div class="bg-[#2D6A4F]/10 rounded-2xl px-4 py-3 text-sm text-[#1f4a34]">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (auth()->check() && auth()->user()->user_id === $listing->user_id)
                        <div class="bg-[#2D6A4F]/10 rounded-2xl px-4 py-3 text-sm text-[#1f4a34]">
                            Je bekijkt je eigen advertentie, exact zoals andere gebruikers deze zien.
                        </div>
                    @endif

                    @if (($listing->listing_type ?? 'fixed') === 'bidding')
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                            <h2 class="text-lg font-semibold text-[#1f4a34]">Bieden</h2>
                            <p class="mt-1 text-sm text-gray-500">Plaats je bod direct op deze listing.</p>

                            <div class="mt-4 text-sm text-gray-600">
                                <p>Totaal biedingen: {{ $bidsCount }}</p>
                                @if ($highestBid !== null)
                                    <p>Huidig hoogste bod: EUR {{ number_format($highestBid, 2, ',', '.') }}</p>
                                @endif
                            </div>

                            @auth
                                @if (auth()->user()->user_id === $listing->user_id)
                                    <p class="mt-4 text-sm text-gray-500">Je kunt niet bieden op je eigen item.</p>
                                @else
                                    <form
                                        method="POST"
                                        action="{{ route('bids.store', $listing) }}"
                                        class="mt-4 space-y-3">
                                        @csrf
                                        <div>
                                            <label class="text-xs font-semibold text-[#2D6A4F]">Jouw bod (EUR)</label>
                                            <input
                                                name="amount"
                                                value="{{ old('amount') }}"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                required
                                                class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                            @error('amount')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button
                                            class="w-full rounded-xl bg-[#2D6A4F] text-white font-semibold py-3 text-sm shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                                            Plaats bod
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#2D6A4F] px-4 py-3 text-sm font-semibold text-white">
                                    Log in om te bieden
                                </a>
                            @endauth

                            @if ($recentBids->isNotEmpty())
                                <div class="mt-5 border-t border-[#2D6A4F]/10 pt-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#2D6A4F]">Recente biedingen</p>
                                    <div class="mt-3 space-y-2 text-sm text-gray-600">
                                        @foreach ($recentBids as $bid)
                                            <div class="flex items-center justify-between">
                                                <span>{{ $bid->buyer?->name ?? 'Gebruiker' }}</span>
                                                <span>EUR {{ number_format($bid->amount, 2, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
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
