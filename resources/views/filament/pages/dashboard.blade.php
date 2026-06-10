<x-filament-panels::page>

    {{-- ══ Widget Selector ══════════════════════════════════════════ --}}
    <div class="ws-wrap">

        {{-- Pagina-dropdown --}}
        <div class="ws-header">
            <label class="ws-label">Pagina</label>
            <select wire:model.live="selectedPage" class="ws-select">
                <option value="users">👤 Gebruikers</option>
                <option value="categories">📂 Categorieën</option>
                <option value="listings">📋 Advertenties</option>
                <option value="bids">💰 Biedingen</option>
                <option value="reviews">⭐ Reviews</option>
                <option value="conversations">💬 Gesprekken</option>
            </select>
        </div>

        {{-- Widget-kaartjes --}}
        <div class="ws-grid">
            @foreach ($this->getWidgetRows() as $row)
                <div class="ws-card {{ $row['enabled'] ? 'ws-card--on' : 'ws-card--off' }}"
                     wire:key="wc-{{ md5($row['class']) }}">

                    <span class="ws-dot"></span>

                    <span class="ws-name">{{ $row['label'] }}</span>

                    <button
                        type="button"
                        wire:click="toggleWidget('{{ addslashes($row['class']) }}')"
                        wire:loading.attr="disabled"
                        wire:target="toggleWidget('{{ addslashes($row['class']) }}')"
                        class="ws-btn"
                        title="{{ $row['enabled'] ? 'Uitschakelen' : 'Inschakelen' }}"
                    >
                        <span class="ws-track">
                            <span class="ws-thumb"></span>
                        </span>
                        <span class="ws-lbl">{{ $row['enabled'] ? 'Aan' : 'Uit' }}</span>
                    </button>

                </div>
            @endforeach
        </div>
    </div>

     {{-- ══ Widget-grid ═══════════════════════════════════════════════ --}}
@foreach ($this->enabledWidgets as $widgetClass)
    <div wire:key="widget-{{ md5($widgetClass) }}">
        @livewire($widgetClass)
    </div>
@endforeach
    <style>
        /* Wrapper */
        .ws-wrap{background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.07);overflow:hidden;margin-bottom:1.5rem}

        /* Header (dropdown) */
        .ws-header{padding:1.25rem 1.5rem 1rem;border-bottom:1px solid #e5e7eb}
        .ws-label{display:block;font-size:.875rem;font-weight:600;color:#111827;margin-bottom:.5rem}
        .ws-select{display:block;width:100%;max-width:280px;border:1px solid #e5e7eb;border-radius:8px;padding:.5rem .75rem;font-size:.875rem;color:#111827;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.05);cursor:pointer}
        .ws-select:focus{outline:none;border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.15)}

        /* Grid van kaartjes */
        .ws-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1px;background:#e5e7eb}

        /* Kaart */
        .ws-card{display:flex;align-items:center;gap:12px;padding:14px 20px;background:#fff;transition:background .15s;cursor:default}
        .ws-card:hover{background:#f9fafb}

        /* Status-dot */
        .ws-dot{display:inline-block;width:8px;height:8px;border-radius:50%;flex-shrink:0;background:#d1d5db;transition:background .2s,box-shadow .2s}
        .ws-card--on .ws-dot{background:#22c55e;box-shadow:0 0 0 3px #dcfce7}

        /* Widget-naam */
        .ws-name{flex:1;font-size:13px;font-weight:500;color:#374151;line-height:1.3}
        .ws-card--off .ws-name{color:#9ca3af}

        /* Toggle-knop */
        .ws-btn{display:inline-flex;align-items:center;gap:6px;border:none;background:transparent;padding:0;cursor:pointer;flex-shrink:0}
        .ws-btn:disabled{opacity:.5;cursor:wait}

        /* Track */
        .ws-track{position:relative;display:block;width:36px;height:20px;border-radius:999px;background:#d1d5db;transition:background .2s;flex-shrink:0}
        .ws-card--on .ws-track{background:#16a34a}

        /* Thumb */
        .ws-thumb{position:absolute;top:2px;left:2px;width:16px;height:16px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.25);transition:transform .2s}
        .ws-card--on .ws-thumb{transform:translateX(16px)}

        /* Label Aan/Uit */
        .ws-lbl{font-size:11px;font-weight:700;letter-spacing:.03em;width:20px;text-align:left;color:#9ca3af}
        .ws-card--on .ws-lbl{color:#15803d}

        @@media(max-width:640px){.ws-header{padding:1rem}.ws-grid{grid-template-columns:1fr 1fr}}
    </style>

</x-filament-panels::page>