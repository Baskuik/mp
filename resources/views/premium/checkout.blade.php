{{-- resources/views/premium/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Afrekenen · Premium')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --dd-forest: #1A3D2B;
            --dd-forest-mid: #245C3A;
            --dd-forest-lit: #2E7A4F;
            --dd-forest-pale: #3D9660;
            --dd-sage: #7BA98A;
            --dd-mist: #EEF3F0;
            --dd-orange: #E07B2A;
            --dd-orange-drk: #C46A1E;
            --dd-ink: #162218;
            --dd-ink-soft: #3D5444;
            --dd-white: #FFFFFF;
            --dd-border: #C2CFC5;
            --dd-bg: #F2F5F3;
            --dd-error: #DC2626;
            --dd-error-bg: #FEF2F2;
            --dd-error-border: rgba(220, 38, 38, 0.2);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            background: var(--dd-bg) !important;
            font-family: 'DM Sans', sans-serif;
        }

        /* ─── Page fade-in ─── */
        @keyframes pageFade {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .checkout-page {
            animation: pageFade 0.55s cubic-bezier(.22, 1, .36, 1) both;
        }

        /* ─── Cards ─── */
        .co-card {
            background: var(--dd-white);
            border: 1px solid var(--dd-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(26, 61, 43, 0.07);
            transition: box-shadow 0.3s;
        }

        .co-card:hover {
            box-shadow: 0 6px 24px rgba(26, 61, 43, 0.11);
        }

        .co-card-head {
            padding: 16px 24px;
            border-bottom: 1px solid var(--dd-border);
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FAFCFB;
        }

        .co-card-head h2 {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--dd-ink);
            margin: 0;
            letter-spacing: -0.01em;
        }

        .step-num {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--dd-forest-mid), var(--dd-forest-lit));
            color: #fff;
            border-radius: 50%;
            font-size: 0.68rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(26, 61, 43, 0.3);
        }

        .co-card-body {
            padding: 22px 24px;
        }

        /* ─── Product row ─── */
        .product-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 18px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--dd-border);
        }

        .product-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--dd-forest), var(--dd-forest-lit));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(26, 61, 43, 0.25);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .product-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.12) 0%, transparent 55%);
            pointer-events: none;
        }

        .product-icon svg {
            display: inline !important;
            flex-shrink: 0;
        }

        .product-name {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--dd-ink);
            margin: 0 0 3px;
            letter-spacing: -0.01em;
        }

        .product-sub {
            font-size: 0.75rem;
            color: var(--dd-sage);
            margin: 0;
        }

        /* ─── Summary lines ─── */
        .sum-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #EEF2EF;
            font-size: 0.87rem;
        }

        .sum-line:last-child {
            border-bottom: none;
        }

        .sum-line .l {
            color: var(--dd-sage);
        }

        .sum-line .v {
            color: var(--dd-ink-soft);
            font-weight: 500;
        }

        .sum-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0 0;
            margin-top: 4px;
            border-top: 2px solid var(--dd-border);
        }

        .sum-total .l {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            color: var(--dd-ink);
            font-weight: 700;
            font-size: 0.93rem;
        }

        .sum-total .v {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            color: var(--dd-forest);
            font-size: 1.7rem;
            font-weight: 400;
            letter-spacing: -0.03em;
        }

        /* ─── Includes list ─── */
        .inc-section-label {
            font-size: 0.67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--dd-forest-lit);
            margin: 0 0 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .inc-section-label::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 2px;
            background: linear-gradient(90deg, var(--dd-forest-lit), rgba(46, 122, 79, 0.3));
            border-radius: 2px;
        }

        .inc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .inc-item {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 0.8rem;
            color: var(--dd-ink-soft);
            padding: 5px 0;
        }

        .inc-check {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: rgba(46, 122, 79, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
            border: 1px solid rgba(46, 122, 79, 0.18);
        }

        .inc-check svg {
            width: 8px !important;
            height: 8px !important;
            color: var(--dd-forest-lit);
            display: inline !important;
            flex-shrink: 0;
        }

        /* SVG visibility */
        .co-card svg,
        .co-back svg,
        .pay-btn svg,
        .trust-badge svg,
        .field-error svg,
        .alert-error svg,
        .guarantee-badge svg,
        .product-icon svg {
            display: inline !important;
            flex-shrink: 0;
        }

        .checkout-page svg {
            max-width: none;
        }

        /* ─── Form fields ─── */
        .field-block {
            margin-bottom: 16px;
        }

        .field-label {
            display: block;
            font-size: 0.79rem;
            font-weight: 600;
            color: var(--dd-ink-soft);
            margin-bottom: 7px;
            letter-spacing: 0.01em;
        }

        .field-input {
            width: 100%;
            background: var(--dd-white);
            border: 1.5px solid var(--dd-border);
            border-radius: 10px;
            padding: 11px 14px;
            color: var(--dd-ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .field-input:focus {
            border-color: var(--dd-forest-lit);
            box-shadow: 0 0 0 3px rgba(46, 122, 79, 0.1);
        }

        .field-input[readonly] {
            background: #F7FAF8;
            color: var(--dd-sage);
            cursor: not-allowed;
        }

        .field-input::placeholder {
            color: #B8C5BC;
        }

        /* ─── Stripe element wrapper ─── */
        .stripe-field {
            background: var(--dd-white);
            border: 1.5px solid var(--dd-border);
            border-radius: 10px;
            padding: 12px 14px;
            transition: border-color 0.15s, box-shadow 0.15s;
            cursor: text;
        }

        .stripe-field.focused {
            border-color: var(--dd-forest-lit);
            box-shadow: 0 0 0 3px rgba(46, 122, 79, 0.1);
        }

        .stripe-field.errored {
            border-color: var(--dd-error);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
        }

        .field-error {
            font-size: 0.78rem;
            color: var(--dd-error);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            min-height: 20px;
        }

        /* ─── Pay button ─── */
        .pay-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange), #F0924A);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: transform 0.25s cubic-bezier(.22, 1, .36, 1), box-shadow 0.25s, opacity 0.18s;
            box-shadow: 0 4px 24px rgba(224, 123, 42, 0.45), 0 1px 0 rgba(255, 255, 255, 0.14) inset;
            position: relative;
            overflow: hidden;
            letter-spacing: -0.01em;
        }

        .pay-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.13) 0%, transparent 55%);
            pointer-events: none;
        }

        /* Shimmer sweep */
        .pay-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.18), transparent);
            transform: skewX(-20deg);
            transition: left 0.5s ease;
            pointer-events: none;
        }

        .pay-btn:hover:not(:disabled)::after {
            left: 150%;
        }

        .pay-btn:hover:not(:disabled) {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 12px 36px rgba(224, 123, 42, 0.55);
        }

        .pay-btn:active:not(:disabled) {
            transform: none;
        }

        .pay-btn:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.65s linear infinite;
            flex-shrink: 0;
        }

        /* ─── Trust badges ─── */
        .trust-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--dd-border);
            margin-top: 18px;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.74rem;
            color: var(--dd-sage);
            font-weight: 500;
            transition: color 0.15s;
        }

        .trust-badge:hover {
            color: var(--dd-ink-soft);
        }

        .trust-badge svg {
            color: var(--dd-forest-lit);
            flex-shrink: 0;
        }

        /* ─── Alert ─── */
        .alert-error {
            background: var(--dd-error-bg);
            border: 1px solid var(--dd-error-border);
            border-radius: 12px;
            padding: 12px 16px;
            color: #B91C1C;
            font-size: 0.86rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            animation: pageFade 0.3s both;
        }

        /* ─── Layout ─── */
        .co-layout {
            display: grid;
            grid-template-columns: 2fr 3fr;
            gap: 20px;
            align-items: start;
        }

        @media (max-width: 720px) {
            .co-layout {
                grid-template-columns: 1fr;
            }

            .inc-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ─── Breadcrumb ─── */
        .co-back {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.82rem;
            color: var(--dd-sage);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s, transform 0.15s;
            margin-bottom: 22px;
        }

        .co-back:hover {
            color: var(--dd-ink-soft);
            text-decoration: none;
            transform: translateX(-2px);
        }

        .co-back svg {
            width: 15px;
            height: 15px;
        }

        /* ─── Page title ─── */
        .co-eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--dd-forest-lit);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .co-eyebrow::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 2px;
            background: linear-gradient(90deg, var(--dd-forest-lit), rgba(46, 122, 79, 0.3));
            border-radius: 2px;
        }

        .co-title {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 400;
            color: var(--dd-ink);
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin: 0 0 6px;
        }

        .co-title em {
            font-style: italic;
            color: var(--dd-forest-lit);
        }

        .co-subtitle {
            color: var(--dd-sage);
            font-size: 0.86rem;
            margin: 0 0 32px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .co-subtitle-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--dd-forest-lit);
            flex-shrink: 0;
        }

        /* ─── Guarantee badge ─── */
        .guarantee-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, rgba(26, 61, 43, 0.04), rgba(46, 122, 79, 0.06));
            border: 1px solid rgba(46, 122, 79, 0.15);
            border-radius: 14px;
            padding: 14px 16px;
            margin-top: 14px;
            transition: border-color 0.2s;
        }

        .guarantee-badge:hover {
            border-color: rgba(46, 122, 79, 0.28);
        }

        .guarantee-badge svg {
            color: var(--dd-forest-lit);
            flex-shrink: 0;
        }

        .guarantee-badge-text {
            font-size: 0.8rem;
            color: var(--dd-ink-soft);
            font-weight: 500;
            line-height: 1.4;
        }

        .guarantee-badge-text strong {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            color: var(--dd-forest);
            display: block;
            margin-bottom: 2px;
        }

        /* ─── One-time badge on price ─── */
        .once-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 99px;
            box-shadow: 0 2px 8px rgba(224, 123, 42, 0.3);
            vertical-align: middle;
            margin-left: 8px;
            position: relative;
            top: -2px;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-page" style="min-height:100vh; background:var(--dd-bg); padding: 36px 20px 80px;">
        <div style="max-width:900px; margin:0 auto;">

            <a href="{{ route('premium.index') }}" class="co-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="width:15px;height:15px;display:inline-block;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Terug naar Premium
            </a>

            <p class="co-eyebrow">DirectDeal Premium</p>
            <h1 class="co-title">Afrekenen. <em>Eenmalig.</em></h1>
            <p class="co-subtitle">
                <span class="co-subtitle-dot"></span>
                Veilige betaling via Stripe · SSL versleuteld
            </p>

            @if (session('error'))
                <div class="alert-error">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="width:16px;height:16px;display:inline-block;flex-shrink:0;margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="co-layout">

                {{-- ── LEFT: Order summary ── --}}
                <div>
                    {{-- Product & Price --}}
                    <div class="co-card" style="margin-bottom:14px;">
                        <div class="co-card-head">
                            <div class="step-num">1</div>
                            <h2>Bestelling</h2>
                        </div>
                        <div class="co-card-body">
                            <div class="product-row">
                                <div class="product-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="width:24px;height:24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M5 3l1.5 9h11L19 3M5 3H3M5 3h14M19 3h2M9 21a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M9 12l2 2 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="product-name">Premium Lidmaatschap</p>
                                    <p class="product-sub">Levenslange toegang · eenmalig</p>
                                </div>
                            </div>

                            <div class="sum-line"><span class="l">Subtotaal</span><span class="v">€9,99</span>
                            </div>
                            <div class="sum-line"><span class="l">BTW (0%)</span><span class="v">€0,00</span>
                            </div>
                            <div class="sum-total">
                                <span class="l">
                                    Totaal
                                    <span class="once-pill">Eenmalig</span>
                                </span>
                                <span class="v">€9,99</span>
                            </div>
                        </div>
                    </div>

                    {{-- Includes --}}
                    <div class="co-card">
                        <div class="co-card-body" style="padding-top:18px;padding-bottom:18px;">
                            <p class="inc-section-label">Inbegrepen</p>
                            <div class="inc-grid">
                                @foreach (['Auto-bieden', 'Inbox prioriteit', 'Statistieken', 'Push notificaties', 'Premium border', 'Max. 10 advertenties', 'Geen advertenties', 'Premium badge', '30 dagen garantie'] as $b)
                                    <div class="inc-item">
                                        <div class="inc-check">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        {{ $b }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Guarantee --}}
                    <div class="guarantee-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width:26px;height:26px;display:inline-block;flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div class="guarantee-badge-text">
                            <strong>Zeg gemakkelijk op </strong>
                            Niet tevreden? Zeg gemakkelijk je lidmaatschap op.
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT: Payment form ── --}}
                <div x-data="stripePayment">
                    <div class="co-card">
                        <div class="co-card-head">
                            <div class="step-num">2</div>
                            <h2>Betaalgegevens</h2>
                        </div>
                        <div class="co-card-body">
                            <form @submit="submit($event)">
                                @csrf

                                {{-- Stripe Payment Element --}}
                                <div class="field-block">
                                    <label class="field-label">Betaalmethode</label>
                                    <div id="payment-element"></div>
                                    <div class="field-error" x-show="paymentError">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="width:12px;height:12px;display:inline-block;flex-shrink:0;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01" />
                                        </svg>
                                        <span x-text="paymentError"></span>
                                    </div>
                                </div>

                                {{-- Email (readonly) --}}
                                <div class="field-block">
                                    <label class="field-label">E-mailadres</label>
                                    <input type="email" value="{{ Auth::user()->email }}" readonly class="field-input">
                                </div>

                                {{-- Naam op kaart (alleen bij kaartbetaling) --}}
                                <div class="field-block" id="card-name-block" style="display:none;">
                                    <label class="field-label">Naam op kaart</label>
                                    <input type="text" name="card_name" placeholder="Jan Jansen"
                                        autocomplete="cc-name" class="field-input">
                                </div>

                                {{-- Submit --}}
                                <button type="submit" class="pay-btn" :disabled="loading">
                                    <template x-if="loading">
                                        <div class="spinner"></div>
                                    </template>
                                    <template x-if="!loading">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="width:17px;height:17px;display:inline-block;flex-shrink:0;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </template>
                                    <span x-text="loading ? 'Verwerken...' : 'Betaal €9,99'"></span>
                                </button>

                            </form>

                            {{-- Trust row --}}
                            <div class="trust-row">
                                <div class="trust-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="width:13px;height:13px;display:inline-block;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    SSL Beveiligd
                                </div>
                                <div class="trust-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="width:13px;height:13px;display:inline-block;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Stripe Payments
                                </div>
                                <div class="trust-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        style="width:13px;height:13px;display:inline-block;flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    30 dagen garantie
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('stripePayment', () => ({
                loading: false,
                paymentError: '',
                stripe: null,
                elements: null,
                paymentElement: null,

                init() {
                    this.stripe = Stripe('{{ config('services.stripe.key') }}');

                    fetch('/premium/intent', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')
                                    .content
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.elements = this.stripe.elements({
                                clientSecret: data.clientSecret,
                                appearance: {
                                    theme: 'stripe',
                                    variables: {
                                        colorPrimary: '#2E7A4F',
                                        colorText: '#162218',
                                        borderRadius: '10px',
                                        fontFamily: 'DM Sans, sans-serif',
                                    }
                                }
                            });
                            this.paymentElement = this.elements.create('payment', {
                                wallets: {
                                    link: 'never'
                                }
                            });
                            this.paymentElement.mount('#payment-element');

                            this.paymentElement.on('change', (e) => {
                                const isCard = e.value?.type === 'card';
                                const nameBlock = document.getElementById(
                                'card-name-block');
                                const nameInput = document.querySelector(
                                '[name=card_name]');
                                nameBlock.style.display = isCard ? 'block' : 'none';
                                nameInput.required = isCard;
                            });
                        });
                },

                async submit(e) {
                    e.preventDefault();
                    if (this.loading) return;
                    this.loading = true;
                    this.paymentError = '';

                    const nameInput = document.querySelector('[name=card_name]');
                    const cardName = nameInput && nameInput.closest('#card-name-block').style
                        .display !== 'none' ?
                        nameInput.value :
                        '{{ Auth::user()->name }}';

                    const {
                        error
                    } = await this.stripe.confirmPayment({
                        elements: this.elements,
                        confirmParams: {
                            return_url: '{{ route('premium.success') }}',
                            payment_method_data: {
                                billing_details: {
                                    name: cardName,
                                    email: '{{ Auth::user()->email }}'
                                }
                            }
                        }
                    });

                    if (error) {
                        this.paymentError = error.message;
                        this.loading = false;
                    }
                }
            }));
        });
    </script>
@endpush
