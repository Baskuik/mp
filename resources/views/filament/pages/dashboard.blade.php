<x-filament-panels::page>

    {{-- ── Widget Selector ─────────────────────────────────────────── --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">

        {{-- Header --}}
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                    🗂️ Widget Selector
                </h2>
                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                    Kies een sectie en schakel widgets in of uit.
                </p>
            </div>
            <span class="rounded-full bg-primary-100 px-3 py-1 text-xs font-medium text-primary-700 dark:bg-primary-900 dark:text-primary-300">
                {{ count($this->enabledWidgets) }} van {{ count($this->getAvailableWidgets()) }} actief
            </span>
        </div>

        {{-- Pagina Dropdown --}}
        <div class="mb-4">
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                Selecteer een pagina
            </label>
            <select
                wire:model.live="selectedPage"
                class="block w-full max-w-xs rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            >
                `@foreach` ($this->getPageOptions() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                `@endforeach`
            </select>
        </div>

        {{-- Toggle knoppen --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- Alles aan/uit --}}
            <button
                wire:click="toggleAll"
                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            >
                `@if` (count($this->enabledWidgets) === count($this->getAvailableWidgets()))
                    🙈 Alles uit
                `@else`
                    👁️ Alles aan
                `@endif`
            </button>

            <span class="text-gray-300 dark:text-gray-600">|</span>

            {{-- Per-widget knoppen --}}
            `@foreach` ($this->getAvailableWidgets() as $widget)
                `@php` $active = in_array($widget, $this->enabledWidgets); `@endphp`
                <button
                    wire:click="toggleWidget('{{ addslashes($widget) }}')"
                    `@class`([
                        'inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium transition',
                        'border-primary-400 bg-primary-50 text-primary-700 hover:bg-primary-100 dark:border-primary-500 dark:bg-primary-900/40 dark:text-primary-300' => $active,
                        'border-gray-200 bg-white text-gray-400 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-500' => ! $active,
                    ])
                >
                    <span>{{ $active ? '👁️' : '🙈' }}</span>
                    {{ $this->getWidgetLabel($widget) }}
                </button>
            `@endforeach`
        </div>
    </div>

    {{-- ── Widgets ───────────────────────────────────────────────────── --}}
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />

</x-filament-panels::page>