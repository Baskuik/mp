<x-filament-panels::page>

    {{-- ═══════════════════════════════════════════════════════════
         PAGINA-SELECTOR + WIDGET TOGGLE-KAARTJES
    ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-6">

        {{-- Dropdown: kies pagina --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <label class="block text-sm font-semibold text-gray-900 mb-2">Pagina</label>
            <select
                wire:model.live="selectedPage"
                class="w-full max-w-xs px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 cursor-pointer"
            >
                <option value="users">👤  Gebruikers</option>
                <option value="categories">📂  Categorieën</option>
                <option value="listings">📋  Advertenties</option>
                <option value="bids">💰  Biedingen</option>
                <option value="reviews">⭐  Reviews</option>
                <option value="conversations">💬  Gesprekken</option>
            </select>
        </div>

        {{-- Widget-kaartjes --}}
        <div class="grid gap-px bg-gray-200" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr))">
            @foreach ($this->getWidgetRows() as $row)
                <div
                    class="flex items-center gap-3 px-5 py-3.5 bg-white hover:bg-gray-50 transition-colors"
                    wire:key="toggle-card-{{ md5($row['class']) }}"
                >
                    {{-- Status-dot --}}
                    @if ($row['enabled'])
                        <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0" style="box-shadow: 0 0 0 3px #dcfce7"></span>
                    @else
                        <span class="w-2 h-2 rounded-full bg-gray-300 flex-shrink-0"></span>
                    @endif

                    {{-- Naam --}}
                    <span class="flex-1 text-[13px] font-medium {{ $row['enabled'] ? 'text-gray-700' : 'text-gray-400' }} leading-tight">
                        {{ $row['label'] }}
                    </span>

                    {{-- Toggle --}}
                    <button
                        type="button"
                        wire:click="toggleWidget('{{ addslashes($row['class']) }}')"
                        wire:loading.attr="disabled"
                        wire:target="toggleWidget('{{ addslashes($row['class']) }}')"
                        class="flex items-center gap-1.5 flex-shrink-0 cursor-pointer border-0 bg-transparent p-0 disabled:opacity-50 disabled:cursor-wait"
                        title="{{ $row['enabled'] ? 'Widget uitschakelen' : 'Widget inschakelen' }}"
                    >
                        {{-- Track --}}
                         <span
                            class="relative block rounded-full transition-colors duration-200 {{ $row['enabled'] ? 'bg-green-600' : 'bg-gray-300' }}"
                            style="width: 2.25rem; height: 1.25rem;"
                        >
                            {{-- Thumb --}}
                            <span
                                class="absolute rounded-full bg-white transition-transform duration-200"
                                style="top: 2px; left: 2px; width: 1rem; height: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.2); {{ $row['enabled'] ? 'transform: translateX(1rem)' : '' }}"
                            ></span>
                        </span>

                        <span class="text-[11px] font-semibold w-7 text-left {{ $row['enabled'] ? 'text-green-700' : 'text-gray-400' }}">
                            {{ $row['enabled'] ? 'Aan' : 'Uit' }}
                        </span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FILAMENT WIDGET-GRID
    ═══════════════════════════════════════════════════════════ --}}
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />

</x-filament-panels::page>