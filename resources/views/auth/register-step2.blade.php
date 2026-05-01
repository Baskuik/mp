@extends('layouts.auth')
@section('title', 'Registreren - Stap 2')

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
                    Maak je profiel<br>
                    <em class="text-[#F4A261] not-italic font-display">af</em>
                </h1>
                <p class="text-white/60 text-base leading-relaxed max-w-sm">
                    Voeg een profielfoto en bio toe zodat andere gebruikers je beter kunnen leren kennen.
                </p>
            </div>

            {{-- Stappen indicator --}}
            <div class="flex justify-start items-end gap-4 relative z-10">
                @foreach (['Account aanmaken', 'Profiel inrichten', 'Email verifiëren'] as $index => $title)
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold 
                            @if ($index === 1) bg-[#F4A261] text-[#2D6A4F]
                            @elseif($index === 0)
                                bg-white/40 text-white
                            @else 
                                bg-white/20 text-white @endif
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
                                @if ($index === 1) bg-[#2D6A4F] text-white
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
                    <h2 class="font-display text-3xl text-gray-900 mb-2">Profiel inrichten</h2>
                    <p class="text-gray-500 text-sm">
                        Dit kan je later altijd aanpassen
                    </p>
                </div>

                {{-- Foutmeldingen --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-600 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Formulier --}}
                <form method="POST" action="{{ route('register.step2.post') }}" class="space-y-5"
                    enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- Profielfoto upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Profielfoto (optioneel)
                        </label>
                        <div class="relative">
                            <input id="profile_photo" type="file" name="profile_photo" accept="image/*" class="hidden"
                                onchange="previewImage(this)">
                            <label for="profile_photo"
                                class="flex items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-[#2D6A4F] hover:bg-[#2D6A4F]/5 transition-all group">
                                <div class="text-center py-6">
                                    <div id="preview-container" class="hidden">
                                        <img id="preview-image" src="" alt="Preview"
                                            class="h-32 w-32 object-cover rounded-lg mx-auto">
                                        <p class="text-xs text-gray-500 mt-2">Klik om te veranderen</p>
                                    </div>
                                    <div id="upload-placeholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#2D6A4F] transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-600 mt-2">Sleep een foto of klik</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF tot 2MB</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Gebruikersnaam --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Gebruikersnaam <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <input id="username" type="text" name="username" required placeholder="bijv. Jan de Vries"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('username') border-red-400 @enderror">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Deze naam is zichtbaar voor andere gebruikers</p>
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Bio (optioneel)
                        </label>
                        <textarea id="bio" name="bio" rows="4"
                            placeholder="Vertel wat over jezelf... Wat verhandeleje graag? Wat zijn je interesses?"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all resize-none @error('bio') border-red-400 @enderror"></textarea>
                        <p class="text-xs text-gray-500 mt-1"><span id="char-count">0</span>/500 tekens</p>
                    </div>

                    {{-- Navigation buttons --}}
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('register.step1') }}"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98] text-center">
                            Terug
                        </a>
                        <button type="submit"
                            class="flex-1 bg-[#2D6A4F] hover:bg-[#1B4332] text-white font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 hover:shadow-lg hover:shadow-[#2D6A4F]/25 active:scale-[0.98]">
                            Volgende
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Char count for bio
        document.getElementById('bio').addEventListener('input', function() {
            document.getElementById('char-count').textContent = this.value.length;
        });
    </script>
@endsection
