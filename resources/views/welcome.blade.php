@extends('layouts.app')

@section('title', 'Home')

@section('content')
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
                                        <option>Alles</option>
                                        <option>Elektronica</option>
                                        <option>Huis & Tuin</option>
                                        <option>Mode</option>
                                        <option>Voertuigen</option>
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
                                <span class="px-3 py-1 rounded-full bg-[#2D6A4F]/10">Vandaag toegevoegd</span>
                                <span class="px-3 py-1 rounded-full bg-[#2D6A4F]/10">In jouw buurt</span>
                                <span class="px-3 py-1 rounded-full bg-[#2D6A4F]/10">Vraagprijs tot 250</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ([
                                ['title' => 'Vintage fiets', 'price' => 'EUR 120', 'location' => 'Utrecht'],
                                ['title' => 'Eiken eettafel', 'price' => 'EUR 340', 'location' => 'Rotterdam'],
                                ['title' => 'Laptop 16 inch', 'price' => 'EUR 780', 'location' => 'Eindhoven'],
                                ['title' => 'Design stoel', 'price' => 'EUR 90', 'location' => 'Den Haag'],
                            ] as $card)
                                <div class="bg-white rounded-2xl p-4 shadow-lg shadow-[#1f4a34]/10 border border-[#2D6A4F]/5">
                                    <div class="h-24 rounded-xl bg-gradient-to-br from-[#2D6A4F]/15 to-[#F4A261]/20"></div>
                                    <p class="mt-3 text-sm font-semibold text-gray-800">{{ $card['title'] }}</p>
                                    <div class="mt-1 flex items-center justify-between text-xs">
                                        <span class="text-[#2D6A4F] font-semibold">{{ $card['price'] }}</span>
                                        <span class="text-gray-400">{{ $card['location'] }}</span>
                                    </div>
                                </div>
                            @endforeach
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
                @foreach ([
                    ['label' => 'Elektronica', 'icon' => 'M12 3v18m9-9H3'],
                    ['label' => 'Huis & Tuin', 'icon' => 'M3 12l9-9 9 9'],
                    ['label' => 'Mode', 'icon' => 'M12 4v16m8-8H4'],
                    ['label' => 'Voertuigen', 'icon' => 'M5 16h14l1-4H4l1 4z'],
                    ['label' => 'Hobby', 'icon' => 'M12 6v12m6-6H6'],
                    ['label' => 'Meer', 'icon' => 'M6 12h12'],
                ] as $cat)
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
                    <h2 class="text-2xl sm:text-3xl font-semibold text-[#1f4a34]">Aanraders voor jou</h2>
                    <p class="text-sm text-[#375a49] mt-2">Verse advertenties met scherpe prijzen en betrouwbare verkopers.</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-[#2D6A4F]/15 text-[#2D6A4F]">Nieuw</button>
                    <button
                        class="px-4 py-2 rounded-full text-xs font-semibold bg-[#2D6A4F] text-white">Populair</button>
                    <button
                        class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-[#2D6A4F]/15 text-[#2D6A4F]">Budget</button>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach ([
                    ['title' => 'Stadsfiets met mand', 'price' => 'EUR 95', 'tag' => 'Populair'],
                    ['title' => 'Nintendo Switch', 'price' => 'EUR 210', 'tag' => 'Nieuwe prijs'],
                    ['title' => 'Vintage kast', 'price' => 'EUR 160', 'tag' => 'Topstaat'],
                    ['title' => 'AirPods Pro', 'price' => 'EUR 140', 'tag' => 'Snel ophalen'],
                ] as $item)
                    <article
                        class="bg-white rounded-2xl border border-[#2D6A4F]/10 p-4 shadow-sm hover:shadow-lg transition">
                        <div class="h-36 rounded-xl bg-gradient-to-br from-[#2D6A4F]/10 to-[#F4A261]/20"></div>
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <span class="px-2.5 py-1 rounded-full bg-[#F4A261]/20 text-[#b0642e] font-semibold">{{ $item['tag'] }}</span>
                            <span class="text-gray-400">Vandaag</span>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-gray-800">{{ $item['title'] }}</h3>
                        <p class="mt-1 text-[#2D6A4F] font-semibold">{{ $item['price'] }}</p>
                        <div class="mt-3 flex items-center justify-between text-xs text-gray-400">
                            <span>4 km</span>
                            <span>Ophalen</span>
                        </div>
                    </article>
                @endforeach
            </div>
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
                    @foreach ([
                        ['title' => 'Verkoop sneller', 'body' => 'Tips om je advertentie beter te laten scoren.'],
                        ['title' => 'Koop slimmer', 'body' => 'Prijsalerts en opgeslagen zoekopdrachten.'],
                        ['title' => 'Vertrouwen', 'body' => 'Bekijk reviews en profielbadges.'],
                        ['title' => 'Lokale deals', 'body' => 'Ontdek aanbiedingen in je buurt.'],
                    ] as $tip)
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
