<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="font-display text-xl text-[#2D6A4F] shrink-0">
                Direct<span class="text-[#F4A261]">Deal</span>
            </a>

            {{-- Navigatie (desktop) --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ url('/') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150 {{ request()->is('/') ? 'text-[#2D6A4F] bg-[#2D6A4F]/8' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>

                <a href="{{ url('/favorieten') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150 {{ request()->is('favorieten') ? 'text-[#2D6A4F] bg-[#2D6A4F]/8' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Favorieten
                </a>

                <a href="{{ url('/contact') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150 {{ request()->is('contact') ? 'text-[#2D6A4F] bg-[#2D6A4F]/8' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact
                </a>
            </div>

            {{-- Rechtergedeelte: winkelwagen + user --}}
            <div class="flex items-center gap-2">

                {{-- Winkelwagen --}}
                <a href="{{ url('/winkelwagen') }}"
                   class="relative flex items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150"
                   title="Winkelwagen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    {{-- Badge (toon alleen als er items zijn) --}}
                    @if(session('cart_count', 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-[#F4A261] rounded-full">
                            {{ session('cart_count') }}
                        </span>
                    @endif
                </a>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">

                    <button @click="open = !open"
                            class="flex items-center gap-2 pl-2 pr-3 py-2 rounded-xl text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150">
                        {{-- Avatar / user icon --}}
                        <div class="w-7 h-7 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                            @auth
                                <span class="text-xs font-semibold text-[#2D6A4F]">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @else
                                <svg class="w-4 h-4 text-[#2D6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            @endauth
                        </div>
                        {{-- Chevron --}}
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown menu --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-gray-900/8 overflow-hidden origin-top-right"
                         style="display: none;">

                        @auth
                            {{-- Gebruikersnaam header --}}
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Ingelogd als</p>
                                <p class="text-sm font-semibold text-gray-800 truncate mt-0.5">{{ auth()->user()->name }}</p>
                            </div>
                        @endauth

                        <div class="p-1.5">
                            {{-- Profiel --}}
                            <a href="{{ url('/profiel') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#2D6A4F]/10 flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Mijn profiel</p>
                                    <p class="text-xs text-gray-400">Bekijk & bewerk profiel</p>
                                </div>
                            </a>

                            {{-- Instellingen --}}
                            <a href="{{ url('/instellingen') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150 group">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-[#2D6A4F]/10 flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Instellingen</p>
                                    <p class="text-xs text-gray-400">Taal, thema & meer</p>
                                </div>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            {{-- Uitloggen --}}
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-500 hover:text-red-600 hover:bg-red-50 transition-all duration-150 group">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                        </div>
                                        <p class="font-medium">Uitloggen</p>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all duration-150">
                                    <div class="w-8 h-8 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                    </div>
                                    <p class="font-medium">Inloggen</p>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- Hamburger (mobiel) --}}
                <button class="md:hidden flex items-center justify-center w-10 h-10 rounded-xl text-gray-500 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all"
                        x-data=""
                        @click="$dispatch('toggle-mobile-menu')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobiel menu --}}
    <div x-data="{ open: false }"
         @toggle-mobile-menu.window="open = !open"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-gray-100 bg-white px-4 pb-4 pt-2 space-y-1"
         style="display: none;">
        <a href="{{ url('/') }}"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Home
        </a>
        <a href="{{ url('/favorieten') }}"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Favorieten
        </a>
        <a href="{{ url('/contact') }}"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contact
        </a>
        <a href="{{ url('/winkelwagen') }}"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-[#2D6A4F] hover:bg-[#2D6A4F]/8 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Winkelwagen
        </a>
    </div>
</nav>