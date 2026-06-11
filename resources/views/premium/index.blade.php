{{-- resources/views/premium/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Premium · DirectDeal')

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
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background: var(--dd-bg) !important; font-family: 'DM Sans', sans-serif; overflow-x: hidden; }

        /* ─── Cancel modal ─── */
        .dd-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(15, 25, 18, 0.55);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }
        .dd-modal-backdrop.open {
            opacity: 1;
            pointer-events: all;
        }
        .dd-modal {
            background: #fff;
            border-radius: 20px;
            padding: 32px 28px 28px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 24px 64px rgba(0,0,0,.18);
            transform: translateY(12px) scale(.97);
            transition: transform .3s cubic-bezier(.22,1,.36,1), opacity .25s ease;
            opacity: 0;
        }
        .dd-modal-backdrop.open .dd-modal {
            transform: none;
            opacity: 1;
        }
        .dd-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #FEF2F2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }
        .dd-modal-title {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--dd-ink);
            margin: 0 0 8px;
        }
        .dd-modal-desc {
            font-size: .875rem;
            color: var(--dd-ink-soft);
            line-height: 1.6;
            margin: 0 0 24px;
        }
        .dd-modal-desc strong {
            color: var(--dd-ink);
        }
        .dd-modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .dd-modal-btn-cancel {
            background: transparent;
            border: 1px solid var(--dd-border);
            color: var(--dd-ink-soft);
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background .15s, border-color .15s;
        }
        .dd-modal-btn-cancel:hover {
            background: var(--dd-mist);
            border-color: #A8BDB0;
        }
        .dd-modal-btn-confirm {
            background: #DC2626;
            border: none;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(220,38,38,.3);
            transition: background .15s, box-shadow .15s, transform .15s;
        }
        .dd-modal-btn-confirm:hover {
            background: #B91C1C;
            box-shadow: 0 4px 16px rgba(220,38,38,.4);
            transform: translateY(-1px);
        }
        .dd-modal-btn-confirm:active { transform: none; }

        /* ─── Filament-stijl toast notificaties ─── */
        .dd-toasts {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .dd-toast {
            pointer-events: all;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 14px 16px;
            min-width: 280px;
            max-width: 360px;
            box-shadow: 0 8px 32px rgba(0,0,0,.10), 0 1px 4px rgba(0,0,0,.06);
            animation: toastIn .35s cubic-bezier(.22,1,.36,1) both;
        }
        .dd-toast.hiding {
            animation: toastOut .3s cubic-bezier(.22,1,.36,1) forwards;
        }
        @keyframes toastIn {
            from { opacity:0; transform: translateX(24px) scale(.97); }
            to   { opacity:1; transform: none; }
        }
        @keyframes toastOut {
            from { opacity:1; transform: none; }
            to   { opacity:0; transform: translateX(24px) scale(.97); }
        }
        .dd-toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
        }
        .dd-toast-icon.success { background: #DCFCE7; color: #16A34A; }
        .dd-toast-icon.error   { background: #FEE2E2; color: #DC2626; }
        .dd-toast-icon.info    { background: #DBEAFE; color: #2563EB; }
        .dd-toast-icon.warning { background: #FEF9C3; color: #CA8A04; }
        .dd-toast-body { flex: 1; min-width: 0; }
        .dd-toast-title { font-size: .82rem; font-weight: 700; color: #111827; margin: 0 0 2px; line-height: 1.3; }
        .dd-toast-msg   { font-size: .79rem; color: #6B7280; margin: 0; line-height: 1.45; }
        .dd-toast-close {
            background: none; border: none; cursor: pointer;
            color: #9CA3AF; padding: 0; line-height: 1; font-size: 16px;
            flex-shrink: 0; transition: color .15s;
        }
        .dd-toast-close:hover { color: #374151; }
        @media(max-width:480px) {
            .dd-toasts { bottom: 88px; right: 12px; left: 12px; }
            .dd-toast   { min-width: 0; max-width: 100%; }
        }

        /* ─── Scroll-reveal ─── */
        .reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.8s cubic-bezier(.22,1,.36,1), transform 0.8s cubic-bezier(.22,1,.36,1); }
        .reveal.visible { opacity: 1; transform: none; }
        .reveal-stagger > * { opacity: 0; transform: translateY(20px); transition: opacity 0.6s cubic-bezier(.22,1,.36,1), transform 0.6s cubic-bezier(.22,1,.36,1); }
        .reveal-stagger.visible > *:nth-child(1) { opacity:1;transform:none;transition-delay:0s; }
        .reveal-stagger.visible > *:nth-child(2) { opacity:1;transform:none;transition-delay:.07s; }
        .reveal-stagger.visible > *:nth-child(3) { opacity:1;transform:none;transition-delay:.14s; }
        .reveal-stagger.visible > *:nth-child(4) { opacity:1;transform:none;transition-delay:.21s; }
        .reveal-stagger.visible > *:nth-child(5) { opacity:1;transform:none;transition-delay:.28s; }
        .reveal-stagger.visible > *:nth-child(6) { opacity:1;transform:none;transition-delay:.35s; }

        /* ─── HERO ─── */
        .hero { background: var(--dd-forest); position: relative; overflow: hidden; isolation: isolate; }
        .hero-mesh { position:absolute;inset:0;pointer-events:none;z-index:0; }
        .hero-mesh::before { content:'';position:absolute;width:900px;height:900px;border-radius:50%;background:radial-gradient(circle,rgba(46,122,79,.45) 0%,transparent 65%);top:-320px;right:-240px;animation:meshFloat1 16s ease-in-out infinite alternate; }
        .hero-mesh::after { content:'';position:absolute;width:700px;height:700px;border-radius:50%;background:radial-gradient(circle,rgba(224,123,42,.18) 0%,transparent 65%);bottom:-200px;left:-160px;animation:meshFloat2 11s ease-in-out infinite alternate; }
        .hero-mesh-extra { position:absolute;inset:0;pointer-events:none;z-index:0; }
        .hero-mesh-extra::before { content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(61,150,96,.2) 0%,transparent 70%);top:40%;left:30%;animation:meshFloat3 19s ease-in-out infinite alternate; }
        @keyframes meshFloat1 { from{transform:translate(0,0) scale(1)} to{transform:translate(60px,50px) scale(1.15)} }
        @keyframes meshFloat2 { from{transform:translate(0,0) scale(1)} to{transform:translate(-50px,-40px) scale(1.2)} }
        @keyframes meshFloat3 { from{transform:translate(0,0) scale(1) rotate(0deg)} to{transform:translate(30px,-50px) scale(1.1) rotate(15deg)} }
        .hero::after { content:'';position:absolute;inset:0;z-index:1;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");background-size:256px;opacity:.5; }

        .hero-inner { position:relative;z-index:2;max-width:1100px;margin:0 auto;padding:96px 32px 116px; }
        .hero-eyebrow { display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.14);border-radius:99px;padding:8px 20px;font-size:.7rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.65);margin-bottom:32px;backdrop-filter:blur(8px);animation:fadeUp .8s cubic-bezier(.22,1,.36,1) both;transition:background .2s,border-color .2s; }
        .hero-eyebrow:hover { background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.22); }
        .hero-eyebrow-dot { width:7px;height:7px;border-radius:50%;background:#F5A44A;flex-shrink:0;box-shadow:0 0 10px rgba(245,164,74,.9);animation:pulse 2.2s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1);box-shadow:0 0 10px rgba(245,164,74,.9)} 50%{opacity:.75;transform:scale(1.35);box-shadow:0 0 18px rgba(245,164,74,.5)} }

        .hero-title { font-family:'Plus Jakarta Sans','DM Sans',sans-serif;font-size:clamp(2.9rem,6.5vw,4.8rem);font-weight:400;line-height:1.04;color:#fff;margin:0 0 6px;letter-spacing:-.01em;animation:fadeUp .8s .1s cubic-bezier(.22,1,.36,1) both; }
        .hero-title em { font-style:italic;color:#F5A44A;text-shadow:0 0 60px rgba(245,164,74,.35); }
        .hero-sub { font-size:1.05rem;color:rgba(255,255,255,.55);font-weight:400;max-width:520px;line-height:1.72;margin:24px 0 46px;animation:fadeUp .8s .18s cubic-bezier(.22,1,.36,1) both; }
        .hero-actions { display:flex;flex-wrap:wrap;gap:12px;align-items:center;animation:fadeUp .8s .26s cubic-bezier(.22,1,.36,1) both; }

        .btn-primary { display:inline-flex;align-items:center;gap:9px;background:linear-gradient(135deg,#C46A1E,#E07B2A,#F0924A);color:#fff;font-family:'DM Sans',sans-serif;font-weight:700;font-size:.92rem;border:none;border-radius:12px;padding:14px 32px;text-decoration:none;cursor:pointer;box-shadow:0 4px 24px rgba(224,123,42,.45),0 1px 0 rgba(255,255,255,.14) inset;transition:transform .25s cubic-bezier(.22,1,.36,1),box-shadow .25s;position:relative;overflow:hidden; }
        .btn-primary::before { content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(255,255,255,.14) 0%,transparent 55%);pointer-events:none; }
        .btn-primary::after { content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transform:skewX(-20deg);transition:left .5s ease;pointer-events:none; }
        .btn-primary:hover::after { left:150%; }
        .btn-primary:hover { transform:translateY(-3px) scale(1.02);box-shadow:0 12px 36px rgba(224,123,42,.55);color:#fff;text-decoration:none; }
        .btn-primary:active { transform:translateY(0) scale(1); }
        .btn-primary.is-purchased { opacity:.55;cursor:default;pointer-events:none; }

        .btn-ghost { display:inline-flex;align-items:center;gap:6px;background:transparent;border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.7);font-family:'DM Sans',sans-serif;font-weight:500;font-size:.9rem;border-radius:12px;padding:14px 24px;text-decoration:none;transition:background .2s,border-color .2s,color .2s,transform .2s; }
        .btn-ghost:hover { background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.38);color:#fff;text-decoration:none;transform:translateY(-2px); }

        .btn-cancel { display:inline-flex;align-items:center;gap:8px;background:transparent;border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.5);font-family:'DM Sans',sans-serif;font-weight:500;font-size:.85rem;border-radius:12px;padding:12px 22px;cursor:pointer;transition:background .2s,border-color .2s,color .2s;text-decoration:none; }
        .btn-cancel:hover { background:rgba(220,38,38,.12);border-color:rgba(220,38,38,.4);color:rgba(255,100,100,.9); }

        .hero-cancelled-badge { display:inline-flex;align-items:center;gap:7px;background:rgba(202,138,4,.15);border:1px solid rgba(202,138,4,.3);border-radius:10px;padding:10px 16px;font-size:.8rem;color:#FCD34D;font-weight:500;margin-top:18px; }

        .hero-card { background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:24px;padding:32px 28px;backdrop-filter:blur(20px);animation:fadeUp .8s .2s cubic-bezier(.22,1,.36,1) both;width:256px;flex-shrink:0;position:relative;overflow:hidden;transition:transform .3s cubic-bezier(.22,1,.36,1),border-color .3s; }
        .hero-card:hover { transform:translateY(-4px);border-color:rgba(255,255,255,.2); }
        .hero-card::before { content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(245,164,74,.6),transparent); }
        .hero-card::after { content:'';position:absolute;top:-60px;right:-60px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(245,164,74,.1) 0%,transparent 70%);pointer-events:none; }

        .hero-price { display:flex;align-items:flex-end;gap:2px;margin-bottom:4px; }
        .hero-price-big { font-family:'Plus Jakarta Sans','DM Sans',sans-serif;font-size:3.8rem;line-height:1;color:#F5A44A;text-shadow:0 0 40px rgba(245,164,74,.28); }
        .hero-price-dec { font-size:1.7rem;font-weight:700;color:#F5A44A;padding-bottom:7px; }
        .hero-price-label { font-size:.76rem;color:rgba(255,255,255,.35);margin-bottom:22px;letter-spacing:.01em; }

        .hero-card-item { display:flex;align-items:center;gap:10px;font-size:.82rem;color:rgba(255,255,255,.7);padding:6px 0;border-bottom:1px solid rgba(255,255,255,.04);transition:color .15s; }
        .hero-card-item:last-of-type { border-bottom:none; }
        .hero-card-item:hover { color:rgba(255,255,255,.9); }
        .hero-card-check { width:18px;height:18px;background:rgba(46,122,79,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(109,214,138,.22);transition:background .15s; }
        .hero-card-item:hover .hero-card-check { background:rgba(46,122,79,.5); }
        .hero-card-check svg { width:9px!important;height:9px!important;color:#6DD68A;display:inline!important; }

        .hero svg,.feat-card svg,.btn-primary svg,.btn-ghost svg,.btn-primary-lg svg,.trust-item svg { display:inline!important;flex-shrink:0; }
        .hero-wave { position:relative;z-index:2;line-height:0;margin-top:-2px; }
        .hero-wave svg { display:block;width:100%; }

        .section { max-width:1100px;margin:0 auto;padding:80px 32px; }
        .section-label { font-size:.68rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--dd-forest-lit);margin-bottom:10px;display:flex;align-items:center;gap:8px; }
        .section-label::before { content:'';display:inline-block;width:24px;height:2px;background:linear-gradient(90deg,var(--dd-forest-lit),rgba(46,122,79,.3));border-radius:2px; }
        .section-heading { font-family:'Plus Jakarta Sans','DM Sans',sans-serif;font-size:clamp(2rem,3.5vw,2.8rem);font-weight:400;color:var(--dd-ink);line-height:1.1;letter-spacing:-.01em;margin:0 0 10px; }
        .section-heading em { font-style:italic;color:var(--dd-forest-lit); }
        .section-desc { font-size:.97rem;color:var(--dd-sage);max-width:500px;line-height:1.68; }

        .feat-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:48px; }
        @media(max-width:820px){.feat-grid{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:520px){.feat-grid{grid-template-columns:1fr;}}

        .feat-card { background:var(--dd-white);border:1px solid var(--dd-border);border-radius:20px;padding:28px 24px;transition:transform .3s cubic-bezier(.22,1,.36,1),box-shadow .3s,border-color .3s;position:relative;overflow:hidden;cursor:default;box-shadow:0 2px 12px rgba(26,61,43,.07); }
        .feat-card::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(var(--accent-rgb,46,122,79),.03) 0%,transparent 60%);opacity:0;transition:opacity .3s;pointer-events:none; }
        .feat-card::after { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent 0%,var(--accent,var(--dd-forest-lit)) 50%,transparent 100%);opacity:0;transition:opacity .3s; }
        .feat-card:hover { transform:translateY(-6px);box-shadow:0 20px 48px rgba(26,61,43,.12);border-color:rgba(26,61,43,.14); }
        .feat-card:hover::before,.feat-card:hover::after { opacity:1; }
        .feat-img { width:100%;height:160px;object-fit:cover;border-radius:12px;margin-bottom:18px;display:block;background:var(--dd-mist); }
        .feat-title { font-size:.93rem;font-weight:700;color:var(--dd-ink);margin-bottom:8px;letter-spacing:-.01em; }
        .feat-desc { font-size:.83rem;color:var(--dd-sage);line-height:1.67;margin:0; }

        .limit-section { background:var(--dd-white);border-top:1px solid var(--dd-border);border-bottom:1px solid var(--dd-border); }
        .limit-grid { display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:44px; }
        @media(max-width:600px){.limit-grid{grid-template-columns:1fr;}}
        .limit-card { border-radius:20px;padding:28px;position:relative;overflow:hidden;transition:transform .3s cubic-bezier(.22,1,.36,1); }
        .limit-card:hover { transform:translateY(-3px); }
        .limit-card.free { background:var(--dd-mist);border:1px solid var(--dd-border); }
        .limit-card.premium { background:linear-gradient(145deg,var(--dd-forest),var(--dd-forest-mid));border:1px solid rgba(255,255,255,.07);box-shadow:0 10px 40px rgba(26,61,43,.22); }
        .limit-card.premium::before { content:'';position:absolute;top:-80px;right:-80px;width:240px;height:240px;border-radius:50%;background:radial-gradient(circle,rgba(245,164,74,.12) 0%,transparent 70%);pointer-events:none; }
        .limit-num { font-family:'Plus Jakarta Sans','DM Sans',sans-serif;font-size:3.8rem;line-height:1;font-weight:400; }
        .limit-card.free .limit-num { color:var(--dd-ink-soft); }
        .limit-card.premium .limit-num { color:#F5A44A;text-shadow:0 0 28px rgba(245,164,74,.35); }
        .limit-bar-track { height:8px;border-radius:99px;margin-top:14px;overflow:hidden; }
        .limit-card.free .limit-bar-track { background:var(--dd-border); }
        .limit-card.premium .limit-bar-track { background:rgba(255,255,255,.08); }
        .limit-bar-fill { height:100%;border-radius:99px;transition:width 1.6s cubic-bezier(.22,1,.36,1) .3s;width:0; }
        .limit-bar-fill.animated-free { width:50%!important;background:var(--dd-sage); }
        .limit-bar-fill.animated-prem { width:100%!important;background:linear-gradient(90deg,#C46A1E,#F5A44A);box-shadow:0 0 12px rgba(245,164,74,.4); }
        .prem-pill { display:inline-flex;align-items:center;gap:5px;background:linear-gradient(135deg,var(--dd-orange-drk),var(--dd-orange));color:#fff;font-size:.63rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:4px 12px;border-radius:99px;box-shadow:0 2px 10px rgba(224,123,42,.35); }

        .compare-wrap { background:var(--dd-white);border:1px solid var(--dd-border);border-radius:22px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.04);margin-top:44px; }
        .compare-wrap table { width:100%;border-collapse:collapse; }
        .compare-wrap thead tr { background:linear-gradient(to bottom,#F7FAF8,#F2F5F3); }
        .compare-wrap th { padding:16px 20px;font-size:.71rem;font-weight:700;text-transform:uppercase;letter-spacing:.09em;color:var(--dd-sage);text-align:center; }
        .compare-wrap th:first-child { text-align:left; }
        .compare-wrap td { padding:13px 20px;border-bottom:1px solid #EEF2EF;font-size:.9rem;color:var(--dd-ink-soft);text-align:center;transition:background .15s; }
        .compare-wrap td:first-child { text-align:left;color:var(--dd-ink);font-weight:500; }
        .compare-wrap tbody tr:last-child td { border-bottom:none; }
        .compare-wrap tbody tr:hover td { background:#F7FAF8; }
        .compare-wrap .prem-col { background:rgba(26,61,43,.025); }
        .compare-wrap tbody tr:hover td.prem-col { background:rgba(26,61,43,.05); }
        .compare-wrap thead .prem-col { color:var(--dd-forest);position:relative;padding-top:28px; }
        .compare-wrap thead .prem-col::before { content:'Aanbevolen';position:absolute;top:0;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--dd-orange-drk),var(--dd-orange));color:#fff;font-size:.56rem;font-weight:700;letter-spacing:.1em;padding:3px 14px;border-radius:0 0 8px 8px;white-space:nowrap; }
        .yes { display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:rgba(46,122,79,.1);color:var(--dd-forest-lit);font-size:.8rem;font-weight:800; }
        .no { display:inline-block;width:14px;height:2.5px;background:#E0A0A0;border-radius:99px;vertical-align:middle; }

        .cta-banner { background:linear-gradient(145deg,var(--dd-forest),var(--dd-forest-mid));border-radius:28px;padding:72px 60px;position:relative;overflow:hidden;text-align:center;box-shadow:0 20px 72px rgba(26,61,43,.24);transition:transform .3s cubic-bezier(.22,1,.36,1); }
        .cta-banner:hover { transform:translateY(-2px); }
        .cta-banner::before { content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(224,123,42,.14) 0%,transparent 70%);top:-250px;right:-150px;pointer-events:none; }
        .cta-banner::after { content:'';position:absolute;width:450px;height:450px;border-radius:50%;background:radial-gradient(circle,rgba(46,122,79,.2) 0%,transparent 70%);bottom:-160px;left:-100px;pointer-events:none; }
        .cta-banner-inner { position:relative;z-index:1; }
        .cta-banner-title { font-family:'Plus Jakarta Sans','DM Sans',sans-serif;font-size:clamp(2.2rem,4vw,3.3rem);font-weight:400;color:#fff;margin-bottom:18px;letter-spacing:-.01em;line-height:1.07; }
        .cta-banner-title em { font-style:italic;color:#F5A44A; }
        .cta-banner-sub { font-size:.97rem;color:rgba(255,255,255,.52);max-width:400px;margin:0 auto 44px;line-height:1.68; }

        .btn-primary-lg { display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#C46A1E,#E07B2A,#F0924A);color:#fff;font-family:'DM Sans',sans-serif;font-weight:700;font-size:1rem;border:none;border-radius:14px;padding:16px 44px;text-decoration:none;cursor:pointer;box-shadow:0 6px 30px rgba(224,123,42,.46),0 1px 0 rgba(255,255,255,.12) inset;transition:transform .25s cubic-bezier(.22,1,.36,1),box-shadow .25s;position:relative;overflow:hidden; }
        .btn-primary-lg::before { content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(255,255,255,.11) 0%,transparent 55%);pointer-events:none; }
        .btn-primary-lg::after { content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);transform:skewX(-20deg);transition:left .55s ease;pointer-events:none; }
        .btn-primary-lg:hover::after { left:150%; }
        .btn-primary-lg:hover { transform:translateY(-3px) scale(1.02);box-shadow:0 14px 40px rgba(224,123,42,.56);color:#fff;text-decoration:none; }
        .btn-primary-lg.is-purchased { opacity:.55;cursor:default;pointer-events:none; }

        .trust-row { display:flex;flex-wrap:wrap;justify-content:center;gap:22px;margin-top:26px; }
        .trust-item { display:flex;align-items:center;gap:6px;font-size:.75rem;color:rgba(255,255,255,.32);font-weight:500;transition:color .2s; }
        .trust-item:hover { color:rgba(255,255,255,.55); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }

        .hero-layout { display:flex;align-items:center;justify-content:space-between;gap:56px; }
        .hero-left { flex:1;min-width:0; }

        .social-strip { display:flex;align-items:center;gap:16px;margin-top:40px;animation:fadeUp .8s .34s cubic-bezier(.22,1,.36,1) both; }
        .social-avatars { display:flex; }
        .social-avatar { width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--dd-forest-mid),var(--dd-forest-pale));border:2px solid rgba(255,255,255,.15);margin-left:-8px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0; }
        .social-avatar:first-child { margin-left:0; }
        .social-text { font-size:.78rem;color:rgba(255,255,255,.42);line-height:1.4; }
        .social-text strong { color:rgba(255,255,255,.65);font-weight:600; }

        .sticky-cta { display:none;position:fixed;bottom:0;left:0;right:0;z-index:50;background:rgba(22,34,24,.97);backdrop-filter:blur(16px);border-top:1px solid rgba(255,255,255,.07);padding:14px 20px;text-align:center;animation:slideUp .4s cubic-bezier(.22,1,.36,1) both; }
        @keyframes slideUp { from{transform:translateY(100%)} to{transform:none} }

        @media(max-width:760px){
            .hero-layout{flex-direction:column;gap:36px;}
            .hero-card{width:100%;}
            .hero-inner{padding:64px 20px 96px;}
            .section{padding:60px 20px;}
            .cta-banner{padding:48px 28px;}
            .sticky-cta{display:block;}
            body{padding-bottom:78px;}
        }
    </style>
@endpush

@section('content')
    <div style="font-family:'DM Sans',sans-serif; background:var(--dd-bg); min-height:100vh;">

        {{-- ══════ HERO ══════ --}}
        <section class="hero">
            <div class="hero-mesh" aria-hidden="true"></div>
            <div class="hero-mesh-extra" aria-hidden="true"></div>

            <div class="hero-inner">
                <div class="hero-layout">
                    <div class="hero-left">
                        <div class="hero-eyebrow">
                            <span class="hero-eyebrow-dot"></span>
                            DirectDeal Premium
                        </div>

                        <h1 class="hero-title">
                            Meer uit DirectDeal<br>
                            halen? <em>Upgrade nu.</em>
                        </h1>

                        <p class="hero-sub">
                            Slechts €9,99 per maand. Maandelijks opzegbaar, geen verborgen kosten. Toegang
                            tot auto-bieden, inbox-prioriteit, statistieken en negen andere voordelen.
                        </p>

                        <div class="hero-actions">
                            @if(Auth::user()->is_premium)
                                <span class="btn-primary is-purchased">✓ Actief abonnement</span>
                                @if(!Auth::user()->subscription_cancelled)
                                    <button type="button" class="btn-cancel" id="openCancelModal">
                                        Abonnement opzeggen
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('premium.checkout') }}" class="btn-primary">
                                    Upgrade voor €9,99/maand
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @endif
                            <a href="#features" class="btn-ghost">Bekijk voordelen</a>
                        </div>

                        @if(Auth::user()->is_premium && Auth::user()->premium_expires_at?->isFuture())
                            <div class="hero-cancelled-badge">
                                Actief tot {{ Auth::user()->premium_expires_at->format('d-m-Y') }}
                            </div>
                        @endif

                        <div class="social-strip">
                            <div class="social-avatars">
                                <div class="social-avatar"><i class="fa-regular fa-user"></i></div>
                                <div class="social-avatar"><i class="fa-regular fa-user"></i></div>
                                <div class="social-avatar"><i class="fa-regular fa-user"></i></div>
                                <div class="social-avatar"><i class="fa-regular fa-user"></i></div>
                            </div>
                            <p class="social-text">
                                <strong>{{ number_format(\App\Models\User::where('is_premium', true)->count(), 0, ',', '.') }}+ gebruikers</strong><br>
                                gingen je al voor
                            </p>
                        </div>
                    </div>

                    <div class="hero-card">
                        <p style="font-size:.66rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.3);margin:0 0 14px;">Maandelijks</p>
                        <div class="hero-price">
                            <span class="hero-price-big">€9</span>
                            <span class="hero-price-dec">,99</span>
                        </div>
                        <p class="hero-price-label">Per maand · maandelijks opzegbaar</p>
                        @foreach (['Auto-bieden op advertenties', 'Prioriteit in de inbox', 'Advertentiestatistieken', 'Push notificaties', 'Geen advertenties'] as $item)
                            <div class="hero-card-item">
                                <div class="hero-card-check">
                                    <svg width="9" height="9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                {{ $item }}
                            </div>
                        @endforeach
                        <p style="font-size:.69rem;color:rgba(255,255,255,.24);margin-top:16px;">+4 meer voordelen</p>
                    </div>
                </div>
            </div>

            <div class="hero-wave">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,10 1440,40 L1440,80 L0,80 Z" fill="#F2F5F3" opacity="0.5"/>
                    <path d="M0,55 C360,95 1080,15 1440,55 L1440,80 L0,80 Z" fill="#F2F5F3"/>
                </svg>
            </div>
        </section>

        {{-- ══════ FEATURES ══════ --}}
        <section id="features" class="section" style="padding-top:88px;">
            <div class="reveal">
                <p class="section-label">Inbegrepen</p>
                <h2 class="section-heading">Alles wat je <em>krijgt</em></h2>
                <p class="section-desc">Voor €9,99 per maand, negen voordelen ontgrendeld. Hier is exact wat je krijgt.</p>
            </div>
            <div class="feat-grid reveal-stagger" style="margin-top:48px;">
                @php
                    $features = [
                        ['img'=>'auto-bieden.jpg','title'=>'Auto-bieden','desc'=>'Stel een maximumbod in en laat het systeem automatisch bieden. Nooit meer een kans missen terwijl je er niet bent.','accent'=>'#2E7A4F'],
                        ['img'=>'inbox-prioriteit.jpg','title'=>'Prioriteit in de inbox','desc'=>'Jouw berichten worden bovenaan de inbox van verkopers geplaatst, zodat je sneller reactie krijgt.','accent'=>'#E07B2A'],
                        ['img'=>'statistieken.jpg','title'=>'Advertentiestatistieken','desc'=>'Zie per advertentie hoeveel mensen hem openden of opsloegen. Optimaliseer jouw listings op basis van data.','accent'=>'#2E7A4F'],
                        ['img'=>'push-notificaties.jpg','title'=>'Push notificaties','desc'=>'Kies categorieën, subcategorieën of specifieke items. Ontvang direct een melding bij nieuwe plaatsingen.','accent'=>'#E07B2A'],
                        ['img'=>'uitlichtende-border.jpg','title'=>'Uitlichtende border','desc'=>'Een gouden rand om jouw advertenties zodat kopers direct zien dat jij een premium verkoper bent.','accent'=>'#2E7A4F'],
                        ['img'=>'geen-advertenties.jpg','title'=>'Geen advertenties','desc'=>'Geen banners, geen pop-ups. Browse DirectDeal schoon, snel en afleidingsvrij.','accent'=>'#4F6AE0'],
                        ['img'=>'10-advertenties.jpg','title'=>'10 advertenties','desc'=>'Gratis gebruikers mogen 5 advertenties plaatsen. Jij hebt ruimte voor 10 actieve listings tegelijk.','accent'=>'#E07B2A'],
                        ['img'=>'premium-badge.jpg','title'=>'Premium badge','desc'=>'Een zichtbare badge op jouw profiel toont kopers dat je een serieuze en actieve verkoper bent.','accent'=>'#2E7A4F'],
                        ['img'=>'geavanceerde-filters.jpg','title'=>'Geavanceerde filters','desc'=>'Filter de inbox op premium/non-premium, datum, tijd en meer. Vind precies wat je zoekt.','accent'=>'#2E7A4F'],
                    ];
                @endphp
                @foreach ($features as $f)
                    <div class="feat-card" style="--accent:{{ $f['accent'] }};">
                        <img src="{{ asset('img/premium/' . $f['img']) }}" alt="{{ $f['title'] }}" class="feat-img">
                        <p class="feat-title">{{ $f['title'] }}</p>
                        <p class="feat-desc">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ══════ AD LIMIT ══════ --}}
        <section class="limit-section">
            <div class="section" style="padding-top:88px; padding-bottom:88px;">
                <div class="reveal">
                    <p class="section-label">Advertentielimiet</p>
                    <h2 class="section-heading">Twee keer zoveel <em>ruimte</em></h2>
                    <p class="section-desc">Premium gebruikers mogen 10 actieve advertenties plaatsen - gratis gebruikers slechts 5.</p>
                </div>
                <div class="limit-grid">
                    <div class="limit-card free reveal">
                        <p style="font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dd-sage);margin:0 0 14px;">Gratis</p>
                        <div style="display:flex;align-items:flex-end;gap:8px;margin-bottom:4px;">
                            <span class="limit-num">5</span>
                            <span style="font-size:.9rem;color:var(--dd-sage);padding-bottom:10px;">advertenties</span>
                        </div>
                        <div class="limit-bar-track"><div class="limit-bar-fill" data-fill="free"></div></div>
                    </div>
                    <div class="limit-card premium reveal">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                            <p style="font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.35);margin:0;">Premium</p>
                            <span class="prem-pill">Premium</span>
                        </div>
                        <div style="display:flex;align-items:flex-end;gap:8px;margin-bottom:4px;">
                            <span class="limit-num">10</span>
                            <span style="font-size:.9rem;color:rgba(255,255,255,.4);padding-bottom:10px;">advertenties</span>
                        </div>
                        <div class="limit-bar-track"><div class="limit-bar-fill" data-fill="prem"></div></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ══════ COMPARISON ══════ --}}
        <section class="section" style="padding-top:88px;">
            <div class="reveal">
                <p class="section-label">Vergelijking</p>
                <h2 class="section-heading">Gratis <em>vs</em> Premium</h2>
            </div>
            <div class="compare-wrap reveal">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align:left;">Functie</th>
                            <th>Gratis</th>
                            <th class="prem-col">Premium</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rows = [
                                ['Advertenties plaatsen', true, true],
                                ['Berichten sturen', true, true],
                                ['Max. 5 advertenties', true, false],
                                ['Max. 10 advertenties', false, true],
                                ['Auto-bieden', false, true],
                                ['Prioriteit in de inbox', false, true],
                                ['Advertentiestatistieken', false, true],
                                ['Push notificaties', false, true],
                                ['Uitlichtende advertentieborder', false, true],
                                ['Geavanceerde inbox-filters', false, true],
                                ['Premium badge op profiel', false, true],
                                ['Geen advertenties / pop-ups', false, true],
                            ];
                        @endphp
                        @foreach ($rows as $r)
                            <tr>
                                <td>{{ $r[0] }}</td>
                                <td>@if($r[1])<span class="yes">✓</span>@else<span class="no"></span>@endif</td>
                                <td class="prem-col">@if($r[2])<span class="yes">✓</span>@else<span class="no"></span>@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- ══════ CTA BANNER ══════ --}}
        <section class="section" style="padding-top:40px; padding-bottom:108px;">
            <div class="cta-banner reveal">
                <div class="cta-banner-inner">
                    <p style="font-size:.66rem;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,255,255,.28);margin:0 0 20px;">Klaar om te starten?</p>
                    <h2 class="cta-banner-title">Upgrade vandaag.<br><em>Maandelijks opzegbaar.</em></h2>
                    <p class="cta-banner-sub">Slechts €9,99 per maand. Nooit meer nadenken over limieten of gemiste kansen.</p>
                    @if(Auth::user()->is_premium)
                        <span class="btn-primary-lg is-purchased">✓ Je hebt al Premium</span>
                        @if(!Auth::user()->subscription_cancelled)
                            <div class="trust-row" style="margin-top:18px;">
                                <button type="button" id="openCancelModal2"
                                    style="background:transparent;border:1px solid rgba(255,255,255,.2);border-radius:8px;padding:6px 16px;cursor:pointer;font-family:inherit;font-size:.75rem;color:rgba(255,255,255,.45);transition:color .2s,border-color .2s;"
                                    onmouseover="this.style.color='rgba(255,100,100,.8)';this.style.borderColor='rgba(220,38,38,.4)'"
                                    onmouseout="this.style.color='rgba(255,255,255,.45)';this.style.borderColor='rgba(255,255,255,.2)'">
                                    Abonnement opzeggen
                                </button>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('premium.checkout') }}" class="btn-primary-lg">
                            Start nu voor €9,99/maand
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <div class="trust-row">
                            <span class="trust-item">🔒 SSL beveiligd</span>
                            <span class="trust-item" style="color:rgba(255,255,255,.12);">·</span>
                            <span class="trust-item">💳 Stripe Payments</span>
                            <span class="trust-item" style="color:rgba(255,255,255,.12);">·</span>
                            <span class="trust-item">↩ Maandelijks opzegbaar</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>

    @if(!Auth::user()->is_premium)
        <div class="sticky-cta" id="stickyCta" style="display:none;">
            <a href="{{ route('premium.checkout') }}" class="btn-primary-lg"
                style="width:100%;justify-content:center;padding:13px 24px;font-size:.95rem;">
                Upgrade voor €9,99/maand →
            </a>
        </div>
    @endif

    {{-- ══════ CANCEL MODAL ══════ --}}
    @if(Auth::user()->is_premium)
        <div class="dd-modal-backdrop" id="cancelModal" role="dialog" aria-modal="true" aria-labelledby="cancelModalTitle">
            <div class="dd-modal">
                
                <h2 class="dd-modal-title" id="cancelModalTitle">Abonnement opzeggen?</h2>
                <p class="dd-modal-desc">
                    Weet je het zeker? Je behoudt toegang tot alle Premium-functies
                    @if(Auth::user()->premium_expires_at)
                        tot <strong>{{ Auth::user()->premium_expires_at->format('d-m-Y') }}</strong>.
                    @else
                        tot het einde van je huidige betaalperiode.
                    @endif
                    Daarna wordt je account automatisch teruggezet naar Gratis.
                </p>
                <div class="dd-modal-actions">
                    <button type="button" class="dd-modal-btn-cancel" id="closeCancelModal">Toch niet</button>
                    <form action="{{ route('premium.cancel') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="dd-modal-btn-confirm">Ja, opzeggen</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════ TOAST NOTIFICATIES ══════ --}}
    <div class="dd-toasts" id="ddToasts" aria-live="polite"></div>
    @if(session('success'))   <div id="flash-success"   data-msg="{{ session('success') }}"   style="display:none;"></div>@endif
    @if(session('cancelled')) <div id="flash-cancelled" data-msg="{{ session('cancelled') }}" style="display:none;"></div>@endif
    @if(session('error'))     <div id="flash-error"     data-msg="{{ session('error') }}"     style="display:none;"></div>@endif
    @if(session('info'))      <div id="flash-info"      data-msg="{{ session('info') }}"      style="display:none;"></div>@endif

@endsection

@push('scripts')
    <script>
        (function () {

            // ── Cancel modal ──
            const modal       = document.getElementById('cancelModal');
            const openBtns    = [document.getElementById('openCancelModal'), document.getElementById('openCancelModal2')];
            const closeBtn    = document.getElementById('closeCancelModal');

            function openModal()  { modal?.classList.add('open'); document.body.style.overflow = 'hidden'; }
            function closeModal() { modal?.classList.remove('open'); document.body.style.overflow = ''; }

            openBtns.forEach(btn => btn?.addEventListener('click', openModal));
            closeBtn?.addEventListener('click', closeModal);

            // Sluit bij klik op backdrop (buiten de modal)
            modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

            // Sluit met Escape
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

            // ── Toast systeem ──
            const container = document.getElementById('ddToasts');
            const icons  = { success:'✓', warning:'', error:'✕', info:'ℹ' };
            const titles = { success:'Gelukt', warning:'Let op', error:'Fout', info:'Info' };

            function showToast(type, message, duration = 6000) {
                const toast = document.createElement('div');
                toast.className = 'dd-toast';
                toast.innerHTML = `
                    <div class="dd-toast-icon ${type}">${icons[type] ?? 'ℹ'}</div>
                    <div class="dd-toast-body">
                        <p class="dd-toast-title">${titles[type] ?? 'Melding'}</p>
                        <p class="dd-toast-msg">${message}</p>
                    </div>
                    <button class="dd-toast-close" aria-label="Sluiten">✕</button>`;

                const dismiss = () => {
                    toast.classList.add('hiding');
                    toast.addEventListener('animationend', () => toast.remove(), { once: true });
                };
                toast.querySelector('.dd-toast-close').addEventListener('click', dismiss);
                container.appendChild(toast);
                if (duration > 0) setTimeout(dismiss, duration);
            }

            [
                { id: 'flash-success',   type: 'success' },
                { id: 'flash-cancelled', type: 'warning' },
                { id: 'flash-error',     type: 'error'   },
                { id: 'flash-info',      type: 'info'    },
            ].forEach(({ id, type }) => {
                const el = document.getElementById(id);
                if (el) showToast(type, el.dataset.msg);
            });

            // ── Scroll-reveal ──
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        e.target.querySelectorAll('[data-fill]').forEach(bar => {
                            setTimeout(() => bar.classList.add(bar.dataset.fill === 'free' ? 'animated-free' : 'animated-prem'), 350);
                        });
                    } else {
                        e.target.classList.remove('visible');
                        e.target.querySelectorAll('[data-fill]').forEach(bar => {
                            bar.classList.remove('animated-free', 'animated-prem');
                        });
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal, .reveal-stagger').forEach(el => observer.observe(el));

            document.querySelectorAll('[data-fill]').forEach(bar => {
                const o = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        setTimeout(() => bar.classList.add(bar.dataset.fill === 'free' ? 'animated-free' : 'animated-prem'), 400);
                    } else {
                        bar.classList.remove('animated-free', 'animated-prem');
                    }
                }, { threshold: 0.3 });
                o.observe(bar);
            });

            // ── Sticky CTA ──
            const hero = document.querySelector('.hero');
            const stickyCta = document.getElementById('stickyCta');
            if (hero && stickyCta) {
                const o = new IntersectionObserver((entries) => {
                    stickyCta.style.display = entries[0].isIntersecting ? 'none' : 'block';
                }, { threshold: 0 });
                o.observe(hero);
            }

        })();
    </script>
@endpush