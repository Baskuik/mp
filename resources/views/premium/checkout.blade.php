{{-- resources/views/premium/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Afrekenen · Premium')

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
        --dd-shadow-sm:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --dd-shadow-md:  0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
    }

    body { background-color: var(--dd-bg) !important; font-family: 'DM Sans', sans-serif; }

    /* ── Card ── */
    .dd-card {
        background: var(--dd-white);
        border: 1px solid var(--dd-border);
        border-radius: 14px;
        box-shadow: var(--dd-shadow-sm);
    }

    /* ── Field label ── */
    .field-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--dd-ink-soft);
        margin-bottom: 7px;
        letter-spacing: 0.01em;
    }

    /* ── Field input ── */
    .field-input {
        width: 100%;
        background: var(--dd-white);
        border: 1px solid var(--dd-border);
        border-radius: 10px;
        padding: 11px 14px;
        color: var(--dd-ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.93rem;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .field-input:focus {
        border-color: var(--dd-forest-lit);
        box-shadow: 0 0 0 3px rgba(46,122,79,0.12);
    }
    .field-input:read-only {
        background: #F8FAF9;
        color: var(--dd-sage);
        cursor: not-allowed;
    }
    .field-input::placeholder { color: #B0BDB6; }

    /* ── Stripe wrapper ── */
    .stripe-wrap {
        background: var(--dd-white);
        border: 1px solid var(--dd-border);
        border-radius: 10px;
        padding: 12px 14px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .stripe-wrap.is-focused {
        border-color: var(--dd-forest-lit);
        box-shadow: 0 0 0 3px rgba(46,122,79,0.12);
    }
    .stripe-wrap.is-error {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
    }

    /* ── Pay button ── */
    .pay-btn {
        background: linear-gradient(135deg, var(--dd-forest-mid), var(--dd-forest-lit));
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px;
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(26,61,43,0.25);
    }
    .pay-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,61,43,0.3);
    }
    .pay-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner {
        width: 17px; height: 17px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    /* ── Divider with label ── */
    .field-divider {
        display: flex; align-items: center; gap: 12px;
        margin: 20px 0;
    }
    .field-divider::before, .field-divider::after {
        content: ''; flex: 1; height: 1px; background: var(--dd-border);
    }
    .field-divider span {
        font-size: 0.78rem; color: var(--dd-sage); font-weight: 500; white-space: nowrap;
    }

    /* ── Summary line ── */
    .summary-line {
        display: flex; justify-content: space-between; align-items: center;
        font-size: 0.9rem; padding: 8px 0;
        border-bottom: 1px solid #F0F3F2;
    }
    .summary-line:last-child { border-bottom: none; }
    .summary-line .label { color: var(--dd-sage); }
    .summary-line .value { color: var(--dd-ink-soft); font-weight: 500; }
    .summary-line.total  { padding-top: 12px; margin-top: 4px; border-top: 1px solid var(--dd-border); border-bottom: none; }
    .summary-line.total .label { color: var(--dd-ink); font-weight: 600; }
    .summary-line.total .value { color: var(--dd-forest); font-size: 1.1rem; font-weight: 700; }

    /* ── Trust badges ── */
    .trust-badge {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.78rem; color: var(--dd-sage); font-weight: 500;
    }
    .trust-badge svg { color: var(--dd-forest-lit); }

    /* ── Alert ── */
    .dd-alert-error {
        background: #FEF2F2;
        border: 1px solid rgba(220,38,38,0.2);
        border-radius: 10px;
        padding: 12px 16px;
        color: #B91C1C;
        font-size: 0.88rem;
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 20px;
    }

    /* ── Section header ── */
    .checkout-section-head {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--dd-border);
    }
    .checkout-section-head h2 {
        font-size: 1rem; font-weight: 700; color: var(--dd-ink); margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .checkout-section-head h2 .step {
        width: 22px; height: 22px;
        background: var(--dd-forest);
        color: #fff;
        border-radius: 50%;
        font-size: 0.72rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<div style="font-family:'DM Sans',sans-serif; background:var(--dd-bg); min-height:100vh; padding: 32px 16px 60px;">
    <div style="max-width:860px; margin:0 auto;">

        {{-- Back + title --}}
        <div class="mb-6">
            <a href="{{ route('premium.index') }}"
               class="inline-flex items-center gap-1.5 text-sm mb-4 hover:opacity-80 transition-opacity no-underline"
               style="color:var(--dd-sage);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Terug naar Premium
            </a>
            <h1 style="font-size:1.5rem; font-weight:700; color:var(--dd-ink); letter-spacing:-0.02em; margin:0;">Afrekenen</h1>
            <p style="color:var(--dd-sage); font-size:0.9rem; margin-top:4px;">Veilige betaling via Stripe</p>
        </div>

        {{-- Error --}}
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" class="dd-alert-error">
            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <span class="flex-1">{{ session('error') }}</span>
            <button @click="show=false" class="opacity-40 hover:opacity-70 transition-opacity text-lg leading-none">×</button>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-5 gap-5">

            {{-- ── Order Summary (2 cols) ── --}}
            <div class="md:col-span-2">

                {{-- Product card --}}
                <div class="dd-card mb-4">
                    <div class="checkout-section-head">
                        <h2>
                            <span class="step">1</span>
                            Bestelling
                        </h2>
                    </div>
                    <div style="padding:20px 24px;">
                        {{-- Product row --}}
                        <div class="flex items-center gap-3 pb-4 mb-4" style="border-bottom:1px solid var(--dd-border);">
                            <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--dd-forest-mid),var(--dd-forest-lit));border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">👑</div>
                            <div>
                                <p style="font-size:0.92rem;font-weight:600;color:var(--dd-ink);margin:0 0 2px;">Premium Lidmaatschap</p>
                                <p style="font-size:0.78rem;color:var(--dd-sage);margin:0;">Levenslange toegang</p>
                            </div>
                        </div>

                        {{-- Price breakdown --}}
                        <div class="summary-line">
                            <span class="label">Subtotaal</span>
                            <span class="value">€9,99</span>
                        </div>
                        <div class="summary-line">
                            <span class="label">BTW (0%)</span>
                            <span class="value">€0,00</span>
                        </div>
                        <div class="summary-line total">
                            <span class="label">Totaal</span>
                            <span class="value">€9,99</span>
                        </div>
                    </div>
                </div>

                {{-- Included --}}
                <div class="dd-card">
                    <div style="padding:16px 20px;">
                        <p style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--dd-forest-lit);margin:0 0 12px;">Inbegrepen</p>
                        <div class="space-y-2.5">
                            @foreach([
                                'Onbeperkte toegang tot alle functies',
                                'Exclusieve advertenties & content',
                                'Geen advertenties',
                                'Prioriteit klantenservice',
                                '30 dagen geld-terug garantie'
                            ] as $b)
                            <div class="flex items-center gap-2.5" style="font-size:0.83rem; color:var(--dd-ink-soft);">
                                <svg class="w-3.5 h-3.5 shrink-0" style="color:var(--dd-forest-lit);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $b }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Checkout Form (3 cols) ── --}}
            <div class="md:col-span-3"
                 x-data="{
                    loading: false,
                    cardFocused: false,
                    cardError: '',
                    init() {
                        const stripe = Stripe('{{ config('services.stripe.key') }}');
                        const elements = stripe.elements({
                            fonts: [{ cssSrc: 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap' }]
                        });
                        const card = elements.create('card', {
                            style: {
                                base: {
                                    iconColor: '#245C3A',
                                    color: '#162218',
                                    fontFamily: 'DM Sans, sans-serif',
                                    fontSize: '14px',
                                    fontWeight: '500',
                                    '::placeholder': { color: '#B0BDB6' }
                                },
                                invalid: { color: '#DC2626', iconColor: '#DC2626' }
                            }
                        });
                        card.mount('#card-element');
                        card.on('focus',  () => this.cardFocused = true);
                        card.on('blur',   () => this.cardFocused = false);
                        card.on('change', (e) => { this.cardError = e.error ? e.error.message : ''; });

                        this.\$el.querySelector('#checkout-form').addEventListener('submit', async (e) => {
                            e.preventDefault();
                            if (this.loading) return;
                            this.loading = true;
                            const { token, error } = await stripe.createToken(card, {
                                name: this.\$el.querySelector('[name=card_name]').value
                            });
                            if (error) {
                                this.cardError = error.message;
                                this.loading = false;
                            } else {
                                const inp = document.createElement('input');
                                inp.type = 'hidden'; inp.name = 'stripeToken'; inp.value = token.id;
                                e.target.appendChild(inp);
                                e.target.submit();
                            }
                        });
                    }
                 }">

                <div class="dd-card">
                    <div class="checkout-section-head">
                        <h2>
                            <span class="step">2</span>
                            Betaalgegevens
                        </h2>
                    </div>

                    <div style="padding:24px;">
                        <form id="checkout-form" action="{{ route('premium.process') }}" method="POST">
                            @csrf

                            {{-- Email --}}
                            <div style="margin-bottom:16px;">
                                <label class="field-label">E-mailadres</label>
                                <input type="email" value="{{ Auth::user()->email }}" readonly class="field-input">
                            </div>

                            <div class="field-divider"><span>Kaartgegevens</span></div>

                            {{-- Cardholder --}}
                            <div style="margin-bottom:16px;">
                                <label class="field-label">Naam op kaart</label>
                                <input type="text" name="card_name" placeholder="Jan Jansen"
                                       required autocomplete="cc-name" class="field-input">
                            </div>

                            {{-- Card number (Stripe) --}}
                            <div style="margin-bottom:4px;">
                                <label class="field-label">Kaart</label>
                                <div class="stripe-wrap"
                                     :class="{ 'is-focused': cardFocused, 'is-error': cardError }">
                                    <div id="card-element"></div>
                                </div>
                            </div>

                            {{-- Card error --}}
                            <div style="min-height:20px; margin-bottom:20px;">
                                <p x-show="cardError" x-text="cardError"
                                   style="font-size:0.8rem; color:#DC2626; margin:6px 0 0;"></p>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="pay-btn" :disabled="loading">
                                <template x-if="loading">
                                    <div class="spinner"></div>
                                </template>
                                <template x-if="!loading">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </template>
                                <span x-text="loading ? 'Verwerken...' : 'Betaal €9,99'"></span>
                            </button>
                        </form>

                        {{-- Trust badges --}}
                        <div class="flex flex-wrap items-center justify-center gap-5 mt-5 pt-4" style="border-top:1px solid var(--dd-border);">
                            <div class="trust-badge">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                SSL Beveiligd
                            </div>
                            <div class="trust-badge">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Stripe Payments
                            </div>
                            <div class="trust-badge">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                30d garantie
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
@endpush