@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $searchChips = ['Vandaag toegevoegd', 'In jouw buurt', 'Vraagprijs tot 250'];
        $searchCategories = ['Alles', 'Elektronica', 'Huis & Tuin', 'Mode', 'Voertuigen'];
        $categoryCards = [
            ['label' => 'Elektronica', 'icon' => 'M7 3h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm2 14h6'],
            ['label' => 'Huis & Tuin', 'icon' => 'M3 11l9-7 9 7v9a2 2 0 01-2 2h-4v-6H9v6H5a2 2 0 01-2-2z'],
            ['label' => 'Mode', 'icon' => 'M9 4l-2 4v3h10V8l-2-4-3 2-3-2zm-1 7h8v9H8z'],
            ['label' => 'Voertuigen', 'icon' => 'M5 11l1-3h12l1 3v5a1 1 0 01-1 1h-1a2 2 0 01-4 0H9a2 2 0 01-4 0H4a1 1 0 01-1-1v-5zm3 7a1 1 0 102 0 1 1 0 00-2 0zm6 0a1 1 0 102 0 1 1 0 00-2 0z'],
            ['label' => 'Hobby', 'icon' => 'M12 6l2.2 4.5L19 11l-3.5 3.4.8 4.6L12 16.8 7.7 19l.8-4.6L5 11l4.8-.5z'],
            ['label' => 'Meer', 'icon' => 'M6 12a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4.5 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm4.5 0a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z'],
        ];
        $tips = [
            ['title' => 'Verkoop sneller', 'body' => 'Tips om je advertentie beter te laten scoren.'],
            ['title' => 'Koop slimmer', 'body' => 'Prijsalerts en opgeslagen zoekopdrachten.'],
            ['title' => 'Vertrouwen', 'body' => 'Bekijk reviews en profielbadges.'],
            ['title' => 'Lokale deals', 'body' => 'Ontdek aanbiedingen in je buurt.'],
        ];
    @endphp
    <div class="bg-[#F7F5F2]">
        <section class="relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute -top-24 right-0 w-80 h-80 bg-[#F4A261]/25 rounded-full blur-3xl"></div>
                <div class="absolute top-32 left-0 w-72 h-72 bg-[#2D6A4F]/20 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.75),transparent_55%)]"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-14 relative">
                <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr] gap-12 items-center">
                    <div>
                        <span
                            class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-[#2D6A4F] bg-white/70 px-3 py-1 rounded-full border border-[#2D6A4F]/10">
                            DirectDeal Marketplace
                        </span>
                        <h1 class="mt-5 text-4xl sm:text-5xl font-semibold text-[#1f4a34] leading-[1.1]">
                            De frisse manier om lokaal te kopen,
                            <span class="text-[#F4A261]">verkopen en ontdekken</span>
                        </h1>
                        <p class="mt-4 text-base sm:text-lg text-[#375a49] max-w-xl">
                            Moderne listings, snelle chat en betrouwbare verkopers. Start met zoeken of zet direct een advertentie live.
                        </p>

                        <div class="mt-7 bg-white/90 backdrop-blur rounded-2xl shadow-xl shadow-[#1f4a34]/10 p-4 border border-white/60">
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="flex-1">
                                    <label class="text-xs font-semibold text-[#2D6A4F]">Zoekterm</label>
                                    <input type="text" placeholder="Zoek naar fiets, laptop, meubels..."
                                        class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-[#F7F5F2] px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-4 focus:ring-[#2D6A4F]/15">
                                </div>
                                <div class="md:w-48">
                                    <label class="text-xs font-semibold text-[#2D6A4F]">Categorie</label>
                                    <select
                                        class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-[#F7F5F2] px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-4 focus:ring-[#2D6A4F]/15">
                                        @foreach ($searchCategories as $category)
                                            <option>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:w-36 flex items-end">
                                    <button
                                        class="w-full rounded-xl bg-[#2D6A4F] text-white font-semibold py-3 text-sm shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                                        Zoeken
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2 text-xs text-[#1f4a34]">
                                @foreach ($searchChips as $chip)
                                    <span class="px-3 py-1 rounded-full bg-[#2D6A4F]/10">{{ $chip }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="bg-white rounded-3xl p-6 shadow-lg shadow-[#1f4a34]/10 border border-[#2D6A4F]/10">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#2D6A4F]">Nieuw op DirectDeal</p>
                            <h3 class="mt-3 text-2xl font-semibold text-[#1f4a34]">Plaats je eerste item</h3>
                            <p class="mt-2 text-sm text-[#375a49]">
                                Start met verkopen en laat je items meteen op de homepage verschijnen.
                            </p>
                            @auth
                                <a href="{{ route('profile') }}"
                                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#2D6A4F] text-white text-sm font-semibold px-5 py-3 shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                                    Naar je profiel
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#2D6A4F] text-white text-sm font-semibold px-5 py-3 shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                                    Log in om te starten
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-center justify-between">
                <h2 class="text-xl sm:text-2xl font-semibold text-[#1f4a34]">Populaire categorieen</h2>
                <button class="text-sm font-semibold text-[#2D6A4F] hover:text-[#1f4a34]">Bekijk alles</button>
            </div>
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categoryCards as $cat)
                    <div
                        class="bg-white rounded-2xl border border-[#2D6A4F]/10 px-4 py-5 text-center shadow-sm hover:shadow-md transition">
                        <div
                            class="mx-auto w-10 h-10 rounded-full bg-[#2D6A4F]/10 flex items-center justify-center text-[#2D6A4F]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $cat['icon'] }}" />
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-gray-800">{{ $cat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-semibold text-[#1f4a34]">Nieuwe items</h2>
                    <p class="text-sm text-[#375a49] mt-2">Alles wat net is toegevoegd door de community.</p>
                </div>
                <form method="GET" action="{{ route('home') }}" class="flex gap-2">
                    <select name="sort"
                        class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-[#2D6A4F]/15 text-[#2D6A4F]">
                        <option value="newest" @selected($sort === 'newest')>Nieuwste</option>
                        <option value="label" @selected($sort === 'label')>Label</option>
                        <option value="price" @selected($sort === 'price')>Prijs</option>
                    </select>
                    <button class="px-4 py-2 rounded-full text-xs font-semibold bg-[#2D6A4F] text-white">Sorteren</button>
                </form>
            </div>

            @if ($listings->isEmpty())
                <div class="mt-8 bg-white rounded-3xl p-10 text-center border border-dashed border-[#2D6A4F]/20">
                    <p class="text-lg font-semibold text-[#1f4a34]">Nog geen items op de homepage</p>
                    <p class="mt-2 text-sm text-gray-500">Plaats een item en het verschijnt hier direct.</p>
                </div>
            @else
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($listings as $listing)
                        <article
                            class="bg-white rounded-2xl border border-[#2D6A4F]/10 p-4 shadow-sm hover:shadow-lg transition">
                            <div class="h-36 rounded-xl overflow-hidden bg-[#2D6A4F]/10">
                                @if ($listing->primaryImage)
                                    <img class="w-full h-full object-cover"
                                        src="{{ asset('storage/' . $listing->primaryImage->path) }}"
                                        alt="{{ $listing->title }}">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-xs text-[#2D6A4F]">
                                        Geen afbeelding
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 flex items-center justify-between text-xs">
                                @if ($listing->label)
                                    <span class="px-2.5 py-1 rounded-full bg-[#F4A261]/20 text-[#b0642e] font-semibold">
                                        {{ $listing->label }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Geen label</span>
                                @endif
                                <span class="text-gray-400">{{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-gray-800">{{ $listing->title }}</h3>
                            <p class="mt-1 text-[#2D6A4F] font-semibold">EUR {{ number_format($listing->price, 2, ',', '.') }}</p>
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $listing->user?->name ?? 'Verkoper' }}</span>
                                <span>Nieuw</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14">
            <div class="grid grid-cols-1 lg:grid-cols-[0.9fr_1.1fr] gap-8">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#2D6A4F]">DirectDeal Plus</p>
                    <h3 class="mt-3 text-2xl font-semibold text-[#1f4a34]">Veiliger handelen met extra checks</h3>
                    <p class="mt-2 text-sm text-[#375a49]">
                        Gebruik betrouwbare betaalopties, snelle chat en aankoopbescherming bij geselecteerde verkopers.
                    </p>
                    <button
                        class="mt-6 px-5 py-3 rounded-xl bg-[#2D6A4F] text-white text-sm font-semibold shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                        Ontdek DirectDeal Plus
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($tips as $tip)
                        <div class="bg-white rounded-2xl p-4 border border-[#2D6A4F]/10 shadow-sm">
                            <h4 class="text-sm font-semibold text-gray-800">{{ $tip['title'] }}</h4>
                            <p class="mt-2 text-sm text-gray-500">{{ $tip['body'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
