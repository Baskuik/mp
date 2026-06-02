{{-- resources/views/premium/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Premium')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --dd-forest:     #1A3D2B;
        --dd-forest-mid: #245C3A;
        --dd-forest-lit: #2E7A4F;
        --dd-sage:       #7BA98A;
        --dd-mist:       #EEF3F0;
        --dd-orange:     #E07B2A;
        --dd-orange-drk: #C46A1E;
        --dd-ink:        #162218;
        --dd-ink-soft:   #3D5444;
        --dd-white:      #FFFFFF;
        --dd-border:     #E0E4E2;
        --dd-bg:         #F4F6F5;
    }

    body { background-color: var(--dd-bg) !important; font-family: 'DM Sans', sans-serif; }

    /* ── Hero banner ── */
    .premium-hero {
        background: linear-gradient(135deg, var(--dd-forest) 0%, #1C4530 60%, #245C3A 100%);
        position: relative;
        overflow: hidden;
    }
    .premium-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%),
                          radial-gradient(circle at 20% 80%, rgba(224,123,42,0.08) 0%, transparent 40%);
        pointer-events: none;
    }
    .premium-hero::after {
        content: '';
        position: absolute;
        bottom: -1px; left: 0; right: 0;
        height: 40px;
        background: var(--dd-bg);
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    /* ── Crown badge ── */
    .crown-badge {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 24px rgba(224,123,42,0.35);
        font-size: 26px;
        flex-shrink: 0;
    }

    /* ── Price pill ── */
    .price-pill {
        display: inline-flex; align-items: baseline; gap: 2px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 100px;
        padding: 10px 24px;
        backdrop-filter: blur(4px);
    }

    /* ── CTA button ── */
    .btn-cta {
        background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        padding: 13px 32px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        box-shadow: 0 4px 16px rgba(224,123,42,0.3);
        font-family: 'DM Sans', sans-serif;
    }
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(224,123,42,0.4);
        color: #fff; text-decoration: none;
    }

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.85);
        border-radius: 12px;
        padding: 13px 24px;
        font-size: 0.95rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.2s ease;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-secondary:hover {
        background: rgba(255,255,255,0.18);
        color: #fff; text-decoration: none;
    }

    /* ── Feature card ── */
    .feature-card {
        background: var(--dd-white);
        border: 1px solid var(--dd-border);
        border-radius: 14px;
        padding: 24px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(26,61,43,0.1);
        border-color: rgba(26,61,43,0.15);
    }
    .feature-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
        background: var(--dd-mist);
    }

    /* ── Compare table ── */
    .compare-table {
        background: var(--dd-white);
        border: 1px solid var(--dd-border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .compare-table table { width: 100%; border-collapse: collapse; }
    .compare-table thead tr {
        background: #F8FAF9;
        border-bottom: 1px solid var(--dd-border);
    }
    .compare-table th {
        padding: 14px 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--dd-sage);
        text-align: center;
    }
    .compare-table th:first-child { text-align: left; }
    .compare-table td {
        padding: 13px 20px;
        border-bottom: 1px solid #F0F3F2;
        font-size: 0.92rem;
        color: var(--dd-ink-soft);
        text-align: center;
    }
    .compare-table td:first-child { text-align: left; color: var(--dd-ink); font-weight: 500; }
    .compare-table tbody tr:last-child td { border-bottom: none; }
    .compare-table tbody tr:hover td { background: #FAFCFA; }
    .compare-table td.premium-col { background: rgba(26,61,43,0.02); }
    .compare-table thead .premium-col {
        color: var(--dd-forest);
        position: relative;
    }
    .compare-table thead .premium-col::after {
        content: 'Aanbevolen';
        position: absolute; top: -1px; left: 50%; transform: translateX(-50%);
        background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
        color: #fff;
        font-size: 0.6rem; font-weight: 700; letter-spacing: 0.08em;
        padding: 2px 10px; border-radius: 0 0 8px 8px;
        white-space: nowrap;
    }

    /* ── Bottom CTA card ── */
    .cta-card {
        background: linear-gradient(135deg, var(--dd-forest) 0%, var(--dd-forest-mid) 100%);
        border-radius: 20px;
        padding: 48px 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(26,61,43,0.2);
    }
    .cta-card::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .cta-card::after {
        content: '';
        position: absolute;
        bottom: -40px; left: -40px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(224,123,42,0.07);
    }

    /* ── Section title ── */
    .section-eyebrow {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--dd-forest-lit);
        margin-bottom: 8px;
    }
    .section-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--dd-ink);
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .section-sub {
        color: var(--dd-sage);
        font-size: 0.95rem;
    }

    /* ── Check / cross ── */
    .check-yes { color: var(--dd-forest-lit); font-size: 1.1rem; font-weight: 700; }
    .check-no  { color: #D1D8D3; font-size: 1.1rem; }
</style>
@endpush

@section('content')
<div style="font-family:'DM Sans',sans-serif; background:var(--dd-bg); min-height:100vh;">

    {{-- ── HERO ── --}}
    <section class="premium-hero px-6 pt-14 pb-20 text-white">
        <div class="max-w-4xl mx-auto relative z-10">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-10 opacity-60">
                <a href="/" class="hover:opacity-100 transition-opacity text-white no-underline">Home</a>
                <span>/</span>
                <span>Premium</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center gap-8">
                {{-- Left --}}
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="crown-badge">👑</div>
                        <div>
                            <p class="text-xs font-700 tracking-widest uppercase opacity-60 mb-0.5" style="letter-spacing:0.18em;">DirectDeal</p>
                            <p class="text-sm font-600 opacity-80">Premium lidmaatschap</p>
                        </div>
                    </div>

                    <h1 class="font-700 leading-tight mb-4" style="font-size:clamp(2rem,5vw,3rem); letter-spacing:-0.02em;">
                        Alles uit het platform<br>
                        <span style="color: #F5A44A;">halen? Upgrade nu.</span>
                    </h1>

                    <p class="mb-8 leading-relaxed opacity-75 max-w-lg" style="font-size:1.05rem; font-weight:400;">
                        Eén betaling. Geen verborgen kosten. Levenslange toegang tot alle premium functies van DirectDeal.
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('premium.checkout') }}" class="btn-cta">
                            Upgrade voor €9,99
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#features" class="btn-secondary">Wat krijg ik?</a>
                    </div>
                </div>

                {{-- Right: price card --}}
                <div class="md:w-64 shrink-0">
                    <div class="rounded-2xl p-6" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); backdrop-filter:blur(8px);">
                        <p class="text-xs font-600 uppercase tracking-widest opacity-50 mb-3" style="letter-spacing:0.14em;">Prijs</p>
                        <div class="flex items-end gap-1 mb-2">
                            <span style="font-size:3rem; font-weight:800; line-height:1; color:#F5A44A;">€9</span>
                            <span style="font-size:1.5rem; font-weight:700; color:#F5A44A; padding-bottom:6px;">,99</span>
                        </div>
                        <p class="opacity-55 text-sm mb-5">Eenmalig · voor altijd</p>

                        <div class="space-y-2.5">
                            @foreach(['Onbeperkte toegang','Geen advertenties','Exclusieve content','Prioriteit support'] as $b)
                            <div class="flex items-center gap-2.5 text-sm opacity-80">
                                <svg class="w-3.5 h-3.5 shrink-0" style="color:#F5A44A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $b }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEATURES ── --}}
    <section id="features" class="max-w-5xl mx-auto px-6 py-16">
        <div class="mb-10">
            <p class="section-eyebrow">Inbegrepen</p>
            <h2 class="section-title">Alles wat je krijgt</h2>
            <p class="section-sub">Eén upgrade, alles ontgrendeld.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
            $features = [
                ['bg'=>'#EEF3F0', 'icon'=>'⚡', 'title'=>'Onbeperkt gebruik',      'desc'=>'Geen limieten op gebruik. Doe alles zo vaak je wilt.'],
                ['bg'=>'#FEF3E6', 'icon'=>'🎨', 'title'=>'Exclusieve content',     'desc'=>'Toegang tot advertenties en content die gratis niet zichtbaar zijn.'],
                ['bg'=>'#EEF3F0', 'icon'=>'🚀', 'title'=>'Prioriteit support',     'desc'=>'Sneller antwoord. Gemiddeld binnen 2 uur geholpen.'],
                ['bg'=>'#FEF3E6', 'icon'=>'🔭', 'title'=>'Vroege toegang',         'desc'=>'Nieuwe functies als eerste uitproberen vóór de grote release.'],
                ['bg'=>'#EEF3F0', 'icon'=>'📊', 'title'=>'Geavanceerde statistieken','desc'=>'Diepgaande inzichten over jouw advertenties en profielprestaties.'],
                ['bg'=>'#FEF3E6', 'icon'=>'✦',  'title'=>'Geen advertenties',      'desc'=>'Browse zonder reclame. Schoon, snel en afleidingsvrij.'],
            ];
            @endphp

            @foreach($features as $f)
            <div class="feature-card">
                <div class="feature-icon" style="background:{{ $f['bg'] }};">{{ $f['icon'] }}</div>
                <h3 class="font-600 mb-2" style="color:var(--dd-ink); font-size:0.95rem; font-weight:600;">{{ $f['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color:var(--dd-sage); font-weight:400;">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ── COMPARISON TABLE ── --}}
    <section class="max-w-3xl mx-auto px-6 pb-16">
        <div class="mb-8">
            <p class="section-eyebrow">Vergelijking</p>
            <h2 class="section-title">Gratis vs Premium</h2>
        </div>

        <div class="compare-table">
            <table>
                <thead>
                    <tr>
                        <th style="text-align:left;">Functie</th>
                        <th>Gratis</th>
                        <th class="premium-col" style="padding-top:22px;">Premium</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $rows = [
                        ['Basis functies',              true,  true],
                        ['Advertenties plaatsen',       true,  true],
                        ['Onbeperkt gebruik',           false, true],
                        ['Exclusieve advertenties',     false, true],
                        ['Prioriteit support',          false, true],
                        ['Vroege toegang',              false, true],
                        ['Geavanceerde statistieken',   false, true],
                        ['Geen advertenties',           false, true],
                    ];
                    @endphp
                    @foreach($rows as $r)
                    <tr>
                        <td>{{ $r[0] }}</td>
                        <td>
                            @if($r[1])
                                <span class="check-yes">✓</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td class="premium-col">
                            @if($r[2])
                                <span class="check-yes">✓</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- ── BOTTOM CTA ── --}}
    <section class="max-w-4xl mx-auto px-6 pb-20">
        <div class="cta-card text-white text-center relative z-10">
            <p class="text-xs font-700 uppercase tracking-widest opacity-50 mb-3" style="letter-spacing:0.16em;">Klaar om te beginnen?</p>
            <h2 class="font-700 mb-3" style="font-size:1.8rem; letter-spacing:-0.02em;">
                Upgrade vandaag nog
            </h2>
            <p class="opacity-65 mb-8 max-w-md mx-auto" style="font-size:0.95rem;">
                Eenmalige betaling van €9,99. Nooit meer nadenken over limieten.
            </p>
            <a href="{{ route('premium.checkout') }}" class="btn-cta" style="font-size:1rem; padding:14px 40px;">
                Start nu voor €9,99
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <p class="mt-5 text-xs opacity-40 flex items-center justify-center gap-4 flex-wrap">
                <span>🔒 Stripe beveiligd</span>
                <span>·</span>
                <span>30 dagen geld-terug garantie</span>
                <span>·</span>
                <span>Geen abonnement</span>
            </p>
        </div>
    </section>

</div>
@endsection