<x-filament-panels::page>

    {{-- ═══════════════════════════════════════════════════════════
         PAGINA-SELECTOR + WIDGET TOGGLE-KAARTJES
    ═══════════════════════════════════════════════════════════ --}}
    <div class="dd-controls">

        {{-- Dropdown: kies pagina --}}
        <div class="dd-select-wrap">
            {{ $this->form }}
        </div>

        {{-- Widget-kaartjes voor de geselecteerde pagina --}}
        <div class="dd-widget-cards">
            @foreach ($this->getWidgetRows() as $row)
                <div
                    class="dd-widget-card {{ $row['enabled'] ? 'dd-widget-card--on' : 'dd-widget-card--off' }}"
                    wire:key="toggle-card-{{ md5($row['class']) }}"
                >
                    {{-- Status-indicator bolletje --}}
                    <span class="dd-widget-dot"></span>

                    {{-- Naam --}}
                    <span class="dd-widget-name">{{ $row['label'] }}</span>

                    {{-- Toggle-knop --}}
                    <button
                        type="button"
                        wire:click="toggleWidget('{{ addslashes($row['class']) }}')"
                        wire:loading.attr="disabled"
                        wire:target="toggleWidget('{{ addslashes($row['class']) }}')"
                        class="dd-toggle-btn {{ $row['enabled'] ? 'dd-toggle-btn--on' : 'dd-toggle-btn--off' }}"
                        title="{{ $row['enabled'] ? 'Widget uitschakelen' : 'Widget inschakelen' }}"
                    >
                        <span class="dd-toggle-track">
                            <span class="dd-toggle-thumb"></span>
                        </span>
                        <span class="dd-toggle-label">
                            {{ $row['enabled'] ? 'Aan' : 'Uit' }}
                        </span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         FILAMENT WIDGET-GRID (alleen ingeschakelde widgets)
    ═══════════════════════════════════════════════════════════ --}}
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />

    {{-- ═══════════════════════════════════════════════════════════
         STYLES
    ═══════════════════════════════════════════════════════════ --}}
    @push('styles')
    <style>
        /* ── Tokens ─────────────────────────────────────────────── */
        :root {
            --dd-green-900: #0d2b1f;
            --dd-green-700: #166534;
            --dd-green-600: #16a34a;
            --dd-green-500: #22c55e;
            --dd-green-100: #dcfce7;
            --dd-green-50:  #f0fdf4;
            --dd-gray-200:  #e5e7eb;
            --dd-gray-400:  #9ca3af;
            --dd-gray-500:  #6b7280;
            --dd-gray-50:   #f9fafb;
            --dd-radius:    10px;
            --dd-shadow:    0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
        }

        /* ── Controls wrapper ───────────────────────────────────── */
        .dd-controls {
            background: #fff;
            border: 1px solid var(--dd-gray-200);
            border-radius: 16px;
            box-shadow: var(--dd-shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        /* ── Select wrapper ─────────────────────────────────────── */
        .dd-select-wrap {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid var(--dd-gray-200);
        }

        .dd-select-wrap .fi-fo-field-wrp-label {
            font-weight: 600;
            color: #111827;
        }

        /* ── Widget-kaartjes grid ───────────────────────────────── */
        .dd-widget-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1px;
            background: var(--dd-gray-200); /* gap-kleur als border */
        }

        /* ── Eén kaartje ────────────────────────────────────────── */
        .dd-widget-card {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .9rem 1.25rem;
            background: #fff;
            transition: background .15s;
        }

        .dd-widget-card:hover { background: var(--dd-gray-50); }

        /* Uitgeschakeld: naam iets grijs */
        .dd-widget-card--off .dd-widget-name {
            color: var(--dd-gray-400);
        }

        /* ── Status-dot ─────────────────────────────────────────── */
        .dd-widget-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            background: var(--dd-gray-200);
            transition: background .2s;
        }

        .dd-widget-card--on .dd-widget-dot {
            background: var(--dd-green-500);
            box-shadow: 0 0 0 3px var(--dd-green-100);
        }

        /* ── Widget naam ────────────────────────────────────────── */
        .dd-widget-name {
            flex: 1;
            font-size: .8125rem;
            font-weight: 500;
            color: #374151;
            line-height: 1.3;
        }

        /* ── Toggle knop ────────────────────────────────────────── */
        .dd-toggle-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
            flex-shrink: 0;
        }

        .dd-toggle-btn:disabled { opacity: .5; cursor: wait; }

        /* Track (de balk van de toggle) */
        .dd-toggle-track {
            position: relative;
            width: 2.25rem;
            height: 1.25rem;
            border-radius: 999px;
            background: var(--dd-gray-200);
            transition: background .2s;
            display: block;
        }

        .dd-toggle-btn--on .dd-toggle-track {
            background: var(--dd-green-600);
        }

        /* Thumb (het ronde bolletje) */
        .dd-toggle-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
            transition: transform .2s;
        }

        .dd-toggle-btn--on .dd-toggle-thumb {
            transform: translateX(1rem);
        }

        /* Label (Aan / Uit) */
        .dd-toggle-label {
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .03em;
            color: var(--dd-gray-500);
            width: 1.75rem;
            text-align: left;
        }

        .dd-toggle-btn--on .dd-toggle-label {
            color: var(--dd-green-700);
        }

        /* ── Responsive ─────────────────────────────────────────── */
        @media (max-width: 640px) {
            .dd-select-wrap { padding: 1rem; }
            .dd-widget-cards { grid-template-columns: 1fr 1fr; }
        }
    </style>
    @endpush

</x-filament-panels::page>