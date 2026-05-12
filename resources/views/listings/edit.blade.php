@extends('layouts.app')

@section('title', 'Item bewerken')

@section('content')
    <div class="bg-[#F7F5F2] py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#2D6A4F]/10">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#1f4a34]">Item bewerken</h1>
                    <a class="text-sm font-semibold text-[#2D6A4F]" href="{{ route('profile') }}">Terug</a>
                </div>

                <form
                    class="mt-6 space-y-4"
                    method="POST"
                    action="{{ route('listings.update', $listing) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs font-semibold text-[#2D6A4F]">Titel</label>
                        <input
                            name="title"
                            value="{{ old('title', $listing->title) }}"
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
                            class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">{{ old('description', $listing->description) }}</textarea>
                        @error('description')
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
                                    <option value="{{ $label }}" @selected(old('label', $listing->label) === $label)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('label')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-[#2D6A4F]">Prijs (EUR)</label>
                            <input
                                name="price"
                                value="{{ old('price', $listing->price) }}"
                                type="number"
                                step="0.01"
                                min="0"
                                required
                                class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
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
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id', $listing->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-[#2D6A4F]">Extra foto's toevoegen</label>
                        <input
                            name="images[]"
                            type="file"
                            multiple
                            accept="image/*"
                            class="mt-1 w-full rounded-xl border border-[#2D6A4F]/15 bg-white px-4 py-2 text-sm text-gray-800">
                        <p class="mt-1 text-xs text-gray-400">
                            Je hebt {{ $listing->images->count() }} foto's gekoppeld. Gebruik Ctrl/Shift om meerdere tegelijk te kiezen.
                        </p>
                        @if ($listing->images->isNotEmpty())
                            <div class="mt-3 grid grid-cols-3 gap-2">
                                @foreach ($listing->images as $image)
                                    <div class="group relative h-20 rounded-lg overflow-hidden bg-[#2D6A4F]/10">
                                        <img
                                            class="w-full h-full object-cover"
                                            src="{{ asset('storage/' . $image->path) }}"
                                            alt="{{ $listing->title }}">
                                        <button
                                            type="submit"
                                            form="delete-image-{{ $image->id }}"
                                            class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition h-6 w-6 rounded-full bg-white/90 text-red-600 text-xs font-semibold shadow">
                                            X
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @error('images')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        class="w-full rounded-xl bg-[#2D6A4F] text-white font-semibold py-3 text-sm shadow-md shadow-[#1f4a34]/20 hover:bg-[#245640] transition">
                        Wijzigingen opslaan
                    </button>
                </form>

                @foreach ($listing->images as $image)
                    <form
                        id="delete-image-{{ $image->id }}"
                        method="POST"
                        action="{{ route('listings.images.destroy', [$listing, $image]) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
