@extends('layouts.app')

@section('title', 'Profiel')

@section('content')
    <div class="bg-[#F7F5F2] py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-14 w-14 rounded-full bg-[#2D6A4F]/10 flex items-center justify-center text-[#2D6A4F]">
                                <span class="text-lg font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Welkom terug</p>
                                <h1 class="text-xl font-semibold text-[#1f4a34]">{{ auth()->user()->name }}</h1>
                                <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                        <h2 class="text-lg font-semibold text-[#1f4a34]">Nieuw item plaatsen</h2>
                        <p class="mt-1 text-sm text-gray-500">Maak een advertentie aan met maximaal 8 foto's.</p>

                        @if (session('status'))
                            <div class="mt-4 rounded-xl bg-[#2D6A4F]/10 text-[#1f4a34] text-sm px-4 py-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form
                            class="mt-4 space-y-4"
                            method="POST"
                            action="{{ route('listings.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div>
                                <label class="text-xs font-semibold text-[#2D6A4F]">Titel</label>
                                <input
                                    name="title"
                                    value="{{ old('title') }}"
                                    type="text"
                                    required
                                    class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                @error('title')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-[#2D6A4F]">Beschrijving</label>
                                <p class="mt-1 text-xs text-gray-400">Maximaal 400 woorden.</p>
                                <textarea
                                    name="description"
                                    rows="4"
                                    required
                                    class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-[#2D6A4F]">Type verkoop</label>
                                <div class="mt-2 flex flex-wrap gap-3 text-sm text-gray-700">
                                    <label class="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="listing_type"
                                            value="fixed"
                                            class="text-[#2D6A4F]"
                                            @checked(old('listing_type', 'fixed') === 'fixed')>
                                        Vaste prijs
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="listing_type"
                                            value="bidding"
                                            class="text-[#2D6A4F]"
                                            @checked(old('listing_type') === 'bidding')>
                                        Bieden
                                    </label>
                                </div>
                                @error('listing_type')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-[#2D6A4F]">Label</label>
                                    <select
                                        name="label"
                                        class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                        <option value="">Kies een label</option>
                                        @foreach ($labels as $label)
                                            <option value="{{ $label }}" @selected(old('label') === $label)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('label')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-[#2D6A4F]" data-price-label>Prijs (EUR)</label>
                                    <input
                                        name="price"
                                        value="{{ old('price') }}"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        data-price-input
                                        class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                    <p class="mt-1 text-xs text-gray-400">Bij bieden kan dit leeg blijven.</p>
                                    @error('price')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-[#2D6A4F]">Categorie</label>
                                <select
                                    name="category_id"
                                    class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                    <option value="">Algemeen</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-[#2D6A4F]">Foto's (max 8)</label>
                                <input
                                    id="create-images"
                                    name="images[]"
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    data-multi-file
                                    data-counter="create-images-count"
                                    class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                                <p class="mt-1 text-xs text-gray-400">
                                    Je kunt meerdere foto's tegelijk selecteren (Ctrl/Shift).
                                </p>
                                <p id="create-images-count" class="mt-1 text-xs text-gray-400">0 geselecteerd.</p>
                                @error('images')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                @error('images.*')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                class="w-full rounded-xl bg-[#2D6A4F] text-white font-semibold py-3 text-sm shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                                Item plaatsen
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-[#1f4a34]">Jouw items</h2>
                            <p class="text-sm text-gray-500">Beheer je actieve advertenties.</p>
                        </div>
                        <form method="GET" action="{{ route('profile') }}" class="flex items-center gap-2">
                            <select name="sort"
                                class="rounded-full border border-[#2D6A4F]/15 bg-white px-4 py-2 text-xs font-semibold text-[#2D6A4F]">
                                <option value="newest" @selected($sort === 'newest')>Nieuwste</option>
                                <option value="label" @selected($sort === 'label')>Label</option>
                                <option value="price" @selected($sort === 'price')>Prijs</option>
                            </select>
                            <button
                                class="px-4 py-2 rounded-full text-xs font-semibold bg-[#2D6A4F] text-white">Sorteren</button>
                        </form>
                    </div>

                    @if ($listings->isEmpty())
                        <div class="mt-6 bg-white rounded-3xl p-10 text-center border border-dashed border-[#2D6A4F]/20">
                            <p class="text-lg font-semibold text-[#1f4a34]">Nog geen items geplaatst</p>
                            <p class="mt-2 text-sm text-gray-500">Gebruik het formulier om je eerste item toe te voegen.</p>
                        </div>
                    @else
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            @foreach ($listings as $listing)
                                <article class="bg-white rounded-2xl border border-[#2D6A4F]/10 p-4 shadow-sm">
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
                                    @if (($listing->listing_type ?? 'fixed') === 'bidding')
                                        <p class="mt-1 text-[#2D6A4F] font-semibold">
                                            Bieden
                                            @if ($listing->price !== null)
                                                vanaf EUR {{ number_format($listing->price, 2, ',', '.') }}
                                            @endif
                                        </p>
                                    @else
                                        <p class="mt-1 text-[#2D6A4F] font-semibold">
                                            EUR {{ number_format($listing->price, 2, ',', '.') }}
                                        </p>
                                    @endif
                                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                                        <a
                                            class="text-[#2D6A4F] font-semibold"
                                            href="{{ route('listings.edit', $listing) }}">
                                            Bewerken
                                        </a>
                                        <a
                                            class="text-[#2D6A4F] font-semibold"
                                            href="{{ route('listings.show', $listing) }}">
                                            Bekijken
                                        </a>
                                        <form
                                            method="POST"
                                            action="{{ route('listings.destroy', $listing) }}"
                                            onsubmit="return confirm('Weet je zeker dat je dit item wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 font-semibold">Verwijderen</button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('input[data-multi-file]').forEach((input) => {
            const dataTransfer = new DataTransfer();

            input.addEventListener('change', () => {
                Array.from(input.files).forEach((file) => dataTransfer.items.add(file));
                input.files = dataTransfer.files;

                const counterId = input.getAttribute('data-counter');
                if (counterId) {
                    const counter = document.getElementById(counterId);
                    if (counter) {
                        counter.textContent = `${dataTransfer.files.length} geselecteerd.`;
                    }
                }
            });
        });

        const listingTypeInputs = document.querySelectorAll('input[name="listing_type"]');
        const priceInput = document.querySelector('[data-price-input]');
        const priceLabel = document.querySelector('[data-price-label]');

        const updatePriceState = () => {
            if (!priceInput || !priceLabel) {
                return;
            }

            const selectedType = document.querySelector('input[name="listing_type"]:checked')?.value || 'fixed';
            const isBidding = selectedType === 'bidding';

            priceInput.required = !isBidding;
            priceLabel.textContent = isBidding ? 'Startprijs (EUR)' : 'Prijs (EUR)';
        };

        listingTypeInputs.forEach((input) => {
            input.addEventListener('change', updatePriceState);
        });

        updatePriceState();
    </script>
@endsection
