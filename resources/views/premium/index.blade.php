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
            --dd-orange-glow: rgba(224, 123, 42, 0.18);
            --dd-ink: #162218;
            --dd-ink-soft: #3D5444;
            --dd-white: #FFFFFF;
            --dd-border: #C2CFC5;
            --dd-bg: #F2F5F3;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--dd-bg) !important;
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        /* ─── Scroll-reveal ─── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s cubic-bezier(.22, 1, .36, 1), transform 0.8s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        /* Staggered children reveal */
        .reveal-stagger>* {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s cubic-bezier(.22, 1, .36, 1), transform 0.6s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal-stagger.visible>*:nth-child(1) {
            opacity: 1;
            transform: none;
            transition-delay: 0s;
        }

        .reveal-stagger.visible>*:nth-child(2) {
            opacity: 1;
            transform: none;
            transition-delay: 0.07s;
        }

        .reveal-stagger.visible>*:nth-child(3) {
            opacity: 1;
            transform: none;
            transition-delay: 0.14s;
        }

        .reveal-stagger.visible>*:nth-child(4) {
            opacity: 1;
            transform: none;
            transition-delay: 0.21s;
        }

        .reveal-stagger.visible>*:nth-child(5) {
            opacity: 1;
            transform: none;
            transition-delay: 0.28s;
        }

        .reveal-stagger.visible>*:nth-child(6) {
            opacity: 1;
            transform: none;
            transition-delay: 0.35s;
        }

        /* ─── HERO ─── */
        .hero {
            background: var(--dd-forest);
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        /* Animated mesh gradient */
        .hero-mesh {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .hero-mesh::before {
            content: '';
            position: absolute;
            width: 900px;
            height: 900px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(46, 122, 79, 0.45) 0%, transparent 65%);
            top: -320px;
            right: -240px;
            animation: meshFloat1 16s ease-in-out infinite alternate;
        }

        .hero-mesh::after {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(224, 123, 42, 0.18) 0%, transparent 65%);
            bottom: -200px;
            left: -160px;
            animation: meshFloat2 11s ease-in-out infinite alternate;
        }

        /* Extra mesh orb */
        .hero-mesh-extra {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .hero-mesh-extra::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(61, 150, 96, 0.2) 0%, transparent 70%);
            top: 40%;
            left: 30%;
            animation: meshFloat3 19s ease-in-out infinite alternate;
        }

        @keyframes meshFloat1 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(60px, 50px) scale(1.15);
            }
        }

        @keyframes meshFloat2 {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(-50px, -40px) scale(1.2);
            }
        }

        @keyframes meshFloat3 {
            from {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            to {
                transform: translate(30px, -50px) scale(1.1) rotate(15deg);
            }
        }

        /* Grain overlay */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            background-size: 256px;
            opacity: 0.5;
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            max-width: 1100px;
            margin: 0 auto;
            padding: 96px 32px 116px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 99px;
            padding: 8px 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 32px;
            backdrop-filter: blur(8px);
            animation: fadeUp 0.8s cubic-bezier(.22, 1, .36, 1) both;
            transition: background 0.2s, border-color 0.2s;
        }

        .hero-eyebrow:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.22);
        }

        .hero-eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #F5A44A;
            flex-shrink: 0;
            box-shadow: 0 0 10px rgba(245, 164, 74, 0.9);
            animation: pulse 2.2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
                box-shadow: 0 0 10px rgba(245, 164, 74, 0.9);
            }

            50% {
                opacity: 0.75;
                transform: scale(1.35);
                box-shadow: 0 0 18px rgba(245, 164, 74, 0.5);
            }
        }

        .hero-title {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: clamp(2.9rem, 6.5vw, 4.8rem);
            font-weight: 400;
            line-height: 1.04;
            color: #fff;
            margin: 0 0 6px;
            letter-spacing: -0.01em;
            animation: fadeUp 0.8s 0.1s cubic-bezier(.22, 1, .36, 1) both;
        }

        .hero-title em {
            font-style: italic;
            color: #F5A44A;
            text-shadow: 0 0 60px rgba(245, 164, 74, 0.35);
            position: relative;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.55);
            font-weight: 400;
            max-width: 520px;
            line-height: 1.72;
            margin: 24px 0 46px;
            animation: fadeUp 0.8s 0.18s cubic-bezier(.22, 1, .36, 1) both;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            animation: fadeUp 0.8s 0.26s cubic-bezier(.22, 1, .36, 1) both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: linear-gradient(135deg, #C46A1E, #E07B2A, #F0924A);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 0.92rem;
            border: none;
            border-radius: 12px;
            padding: 14px 32px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(224, 123, 42, 0.45), 0 1px 0 rgba(255, 255, 255, 0.14) inset;
            transition: transform 0.25s cubic-bezier(.22, 1, .36, 1), box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.14) 0%, transparent 55%);
            pointer-events: none;
        }

        /* Shimmer sweep on hover */
        .btn-primary::after {
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

        .btn-primary:hover::after {
            left: 150%;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 36px rgba(224, 123, 42, 0.55);
            color: #fff;
            text-decoration: none;
        }

        .btn-primary:active {
            transform: translateY(0) scale(1);
        }

        .btn-primary.is-purchased {
            opacity: 0.55;
            cursor: default;
            pointer-events: none;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.7);
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 12px;
            padding: 14px 24px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.38);
            color: #fff;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* hero price card */
        .hero-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 32px 28px;
            backdrop-filter: blur(20px);
            animation: fadeUp 0.8s 0.2s cubic-bezier(.22, 1, .36, 1) both;
            width: 256px;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(.22, 1, .36, 1), border-color 0.3s;
        }

        .hero-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245, 164, 74, 0.6), transparent);
        }

        .hero-card::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 164, 74, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-price {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            margin-bottom: 4px;
        }

        .hero-price-big {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: 3.8rem;
            line-height: 1;
            color: #F5A44A;
            text-shadow: 0 0 40px rgba(245, 164, 74, 0.28);
        }

        .hero-price-dec {
            font-size: 1.7rem;
            font-weight: 700;
            color: #F5A44A;
            padding-bottom: 7px;
        }

        .hero-price-label {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 22px;
            letter-spacing: 0.01em;
        }

        .hero-card-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.7);
            padding: 6px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            transition: color 0.15s;
        }

        .hero-card-item:last-of-type {
            border-bottom: none;
        }

        .hero-card-item:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-card-check {
            width: 18px;
            height: 18px;
            background: rgba(46, 122, 79, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(109, 214, 138, 0.22);
            transition: background 0.15s;
        }

        .hero-card-item:hover .hero-card-check {
            background: rgba(46, 122, 79, 0.5);
        }

        .hero-card-check svg {
            width: 9px !important;
            height: 9px !important;
            color: #6DD68A;
            display: inline !important;
        }

        .hero svg,
        .feat-card svg,
        .btn-primary svg,
        .btn-ghost svg,
        .btn-primary-lg svg,
        .trust-item svg,
        .co-back svg {
            display: inline !important;
            flex-shrink: 0;
        }

        /* wave divider */
        .hero-wave {
            position: relative;
            z-index: 2;
            line-height: 0;
            margin-top: -2px;
        }

        .hero-wave svg {
            display: block;
            width: 100%;
        }

        /* ─── FEATURES SECTION ─── */
        .section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 80px 32px;
        }

        .section-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--dd-forest-lit);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 2px;
            background: linear-gradient(90deg, var(--dd-forest-lit), rgba(46, 122, 79, 0.3));
            border-radius: 2px;
        }

        .section-heading {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 400;
            color: var(--dd-ink);
            line-height: 1.1;
            letter-spacing: -0.01em;
            margin: 0 0 10px;
        }

        .section-heading em {
            font-style: italic;
            color: var(--dd-forest-lit);
        }

        .section-desc {
            font-size: 0.97rem;
            color: var(--dd-sage);
            max-width: 500px;
            line-height: 1.68;
        }

        /* feature grid */
        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 48px;
        }

        @media (max-width: 820px) {
            .feat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .feat-grid {
                grid-template-columns: 1fr;
            }
        }

        .feat-card {
            background: var(--dd-white);
            border: 1px solid var(--dd-border);
            border-radius: 20px;
            padding: 28px 24px;
            transition: transform 0.3s cubic-bezier(.22, 1, .36, 1), box-shadow 0.3s, border-color 0.3s;
            position: relative;
            overflow: hidden;
            cursor: default;
            box-shadow: 0 2px 12px rgba(26, 61, 43, 0.07);
        }

        /* Subtle background tint on hover */
        .feat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(var(--accent-rgb, 46, 122, 79), 0.03) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        /* Top accent line */
        .feat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, var(--accent, var(--dd-forest-lit)) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(26, 61, 43, 0.12);
            border-color: rgba(26, 61, 43, 0.14);
        }

        .feat-card:hover::before {
            opacity: 1;
        }

        .feat-card:hover::after {
            opacity: 1;
        }

        .feat-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 18px;
            display: block;
            background: var(--dd-mist);
        }

        .feat-title {
            font-size: 0.93rem;
            font-weight: 700;
            color: var(--dd-ink);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .feat-desc {
            font-size: 0.83rem;
            color: var(--dd-sage);
            line-height: 1.67;
            margin: 0;
        }

        /* ─── AD LIMIT VISUAL ─── */
        .limit-section {
            background: var(--dd-white);
            border-top: 1px solid var(--dd-border);
            border-bottom: 1px solid var(--dd-border);
        }

        .limit-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 44px;
        }

        @media (max-width: 600px) {
            .limit-grid {
                grid-template-columns: 1fr;
            }
        }

        .limit-card {
            border-radius: 20px;
            padding: 28px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(.22, 1, .36, 1);
        }

        .limit-card:hover {
            transform: translateY(-3px);
        }

        .limit-card.free {
            background: var(--dd-mist);
            border: 1px solid var(--dd-border);
        }

        .limit-card.premium {
            background: linear-gradient(145deg, var(--dd-forest), var(--dd-forest-mid));
            border: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: 0 10px 40px rgba(26, 61, 43, 0.22);
        }

        .limit-card.premium::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 164, 74, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .limit-num {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: 3.8rem;
            line-height: 1;
            font-weight: 400;
        }

        .limit-card.free .limit-num {
            color: var(--dd-ink-soft);
        }

        .limit-card.premium .limit-num {
            color: #F5A44A;
            text-shadow: 0 0 28px rgba(245, 164, 74, 0.35);
        }

        .limit-bar-track {
            height: 8px;
            border-radius: 99px;
            margin-top: 14px;
            overflow: hidden;
        }

        .limit-card.free .limit-bar-track {
            background: var(--dd-border);
        }

        .limit-card.premium .limit-bar-track {
            background: rgba(255, 255, 255, 0.08);
        }

        .limit-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 1.6s cubic-bezier(.22, 1, .36, 1) 0.3s;
            width: 0;
        }

        .limit-bar-fill.animated-free {
            width: 50% !important;
            background: var(--dd-sage);
        }

        .limit-bar-fill.animated-prem {
            width: 100% !important;
            background: linear-gradient(90deg, #C46A1E, #F5A44A);
            box-shadow: 0 0 12px rgba(245, 164, 74, 0.4);
        }

        .prem-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
            color: #fff;
            font-size: 0.63rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 99px;
            box-shadow: 0 2px 10px rgba(224, 123, 42, 0.35);
        }

        /* ─── COMPARE TABLE ─── */
        .compare-wrap {
            background: var(--dd-white);
            border: 1px solid var(--dd-border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
            margin-top: 44px;
        }

        .compare-wrap table {
            width: 100%;
            border-collapse: collapse;
        }

        .compare-wrap thead tr {
            background: linear-gradient(to bottom, #F7FAF8, #F2F5F3);
        }

        .compare-wrap th {
            padding: 16px 20px;
            font-size: 0.71rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: var(--dd-sage);
            text-align: center;
        }

        .compare-wrap th:first-child {
            text-align: left;
        }

        .compare-wrap td {
            padding: 13px 20px;
            border-bottom: 1px solid #EEF2EF;
            font-size: 0.9rem;
            color: var(--dd-ink-soft);
            text-align: center;
            transition: background 0.15s;
        }

        .compare-wrap td:first-child {
            text-align: left;
            color: var(--dd-ink);
            font-weight: 500;
        }

        .compare-wrap tbody tr:last-child td {
            border-bottom: none;
        }

        .compare-wrap tbody tr:hover td {
            background: #F7FAF8;
        }

        .compare-wrap .prem-col {
            background: rgba(26, 61, 43, 0.025);
        }

        .compare-wrap tbody tr:hover td.prem-col {
            background: rgba(26, 61, 43, 0.05);
        }

        .compare-wrap thead .prem-col {
            color: var(--dd-forest);
            position: relative;
            padding-top: 28px;
        }

        .compare-wrap thead .prem-col::before {
            content: 'Aanbevolen';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--dd-orange-drk), var(--dd-orange));
            color: #fff;
            font-size: 0.56rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            padding: 3px 14px;
            border-radius: 0 0 8px 8px;
            white-space: nowrap;
        }

        .yes {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(46, 122, 79, 0.1);
            color: var(--dd-forest-lit);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .no {
            display: inline-block;
            width: 14px;
            height: 2.5px;
            background: #E0A0A0;
            border-radius: 99px;
            vertical-align: middle;
        }

        /* ─── CTA BANNER ─── */
        .cta-banner {
            background: linear-gradient(145deg, var(--dd-forest), var(--dd-forest-mid));
            border-radius: 28px;
            padding: 72px 60px;
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 20px 72px rgba(26, 61, 43, 0.24);
            transition: transform 0.3s cubic-bezier(.22, 1, .36, 1);
        }

        .cta-banner:hover {
            transform: translateY(-2px);
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(224, 123, 42, 0.14) 0%, transparent 70%);
            top: -250px;
            right: -150px;
            pointer-events: none;
        }

        .cta-banner::after {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(46, 122, 79, 0.2) 0%, transparent 70%);
            bottom: -160px;
            left: -100px;
            pointer-events: none;
        }

        .cta-banner-inner {
            position: relative;
            z-index: 1;
        }

        .cta-banner-title {
            font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif;
            font-size: clamp(2.2rem, 4vw, 3.3rem);
            font-weight: 400;
            color: #fff;
            margin-bottom: 18px;
            letter-spacing: -0.01em;
            line-height: 1.07;
        }

        .cta-banner-title em {
            font-style: italic;
            color: #F5A44A;
        }

        .cta-banner-sub {
            font-size: 0.97rem;
            color: rgba(255, 255, 255, 0.52);
            max-width: 400px;
            margin: 0 auto 44px;
            line-height: 1.68;
        }

        .btn-primary-lg {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #C46A1E, #E07B2A, #F0924A);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 14px;
            padding: 16px 44px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 30px rgba(224, 123, 42, 0.46), 0 1px 0 rgba(255, 255, 255, 0.12) inset;
            transition: transform 0.25s cubic-bezier(.22, 1, .36, 1), box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-lg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.11) 0%, transparent 55%);
            pointer-events: none;
        }

        .btn-primary-lg::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.18), transparent);
            transform: skewX(-20deg);
            transition: left 0.55s ease;
            pointer-events: none;
        }

        .btn-primary-lg:hover::after {
            left: 150%;
        }

        .btn-primary-lg:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 14px 40px rgba(224, 123, 42, 0.56);
            color: #fff;
            text-decoration: none;
        }

        .btn-primary-lg.is-purchased {
            opacity: 0.55;
            cursor: default;
            pointer-events: none;
        }

        .trust-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 22px;
            margin-top: 26px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.32);
            font-weight: 500;
            transition: color 0.2s;
        }

        .trust-item:hover {
            color: rgba(255, 255, 255, 0.55);
        }

        /* ─── Keyframes ─── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* ─── Hero layout ─── */
        .hero-layout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 56px;
        }

        .hero-left {
            flex: 1;
            min-width: 0;
        }

        /* ─── Social proof strip ─── */
        .social-strip {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 40px;
            animation: fadeUp 0.8s 0.34s cubic-bezier(.22, 1, .36, 1) both;
        }

        .social-avatars {
            display: flex;
        }

        .social-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dd-forest-mid), var(--dd-forest-pale));
            border: 2px solid rgba(255, 255, 255, 0.15);
            margin-left: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .social-avatar:first-child {
            margin-left: 0;
        }

        .social-text {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.42);
            line-height: 1.4;
        }

        .social-text strong {
            color: rgba(255, 255, 255, 0.65);
            font-weight: 600;
        }

        /* ─── Sticky mobile CTA ─── */
        .sticky-cta {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(22, 34, 24, 0.97);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            padding: 14px 20px;
            text-align: center;
            animation: slideUp 0.4s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: none;
            }
        }

        @media (max-width: 760px) {
            .hero-layout {
                flex-direction: column;
                gap: 36px;
            }

            .hero-card {
                width: 100%;
            }

            .hero-inner {
                padding: 64px 20px 96px;
            }

            .section {
                padding: 60px 20px;
            }

            .cta-banner {
                padding: 48px 28px;
            }

            .sticky-cta {
                display: block;
            }

            body {
                padding-bottom: 78px;
            }
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
                                <span class="btn-primary is-purchased">
                                    ✓ Actief abonnement
                                </span>
                                <form action="{{ route('premium.cancel') }}" method="POST"
                                      onsubmit="return confirm('Weet je zeker dat je je abonnement wilt opzeggen?')">
                                    @csrf
                                    <button type="submit" class="btn-ghost" style="border-color:rgba(255,255,255,0.3);color:rgba(255,255,255,0.6);">
                                        Abonnement opzeggen
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('premium.checkout') }}" class="btn-primary">
                                    Upgrade voor €9,99/maand
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            @endif
                            <a href="#features" class="btn-ghost">
                                Bekijk voordelen
                            </a>
                        </div>

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
                        <p
                            style="font-size:0.66rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:rgba(255,255,255,0.3);margin:0 0 14px;">
                            Maandelijks</p>
                        <div class="hero-price">
                            <span class="hero-price-big">€9</span>
                            <span class="hero-price-dec">,99</span>
                        </div>
                        <p class="hero-price-label">Per maand · maandelijks opzegbaar</p>

                        @foreach (['Auto-bieden op advertenties', 'Prioriteit in de inbox', 'Advertentiestatistieken', 'Push notificaties', 'Geen advertenties'] as $item)
                            <div class="hero-card-item">
                                <div class="hero-card-check">
                                    <svg width="9" height="9" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                {{ $item }}
                            </div>
                        @endforeach
                        <p style="font-size:0.69rem;color:rgba(255,255,255,0.24);margin-top:16px;">+4 meer voordelen</p>
                    </div>
                </div>
            </div>

            {{-- Wave --}}
            <div class="hero-wave">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,40 C240,80 480,0 720,40 C960,80 1200,10 1440,40 L1440,80 L0,80 Z" fill="#F2F5F3"
                        opacity="0.5" />
                    <path d="M0,55 C360,95 1080,15 1440,55 L1440,80 L0,80 Z" fill="#F2F5F3" />
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
                        [
                            'img' => 'auto-bieden.jpg',
                            'bg' => '#E8F3EC',
                            'title' => 'Auto-bieden',
                            'desc' =>
                                'Stel een maximumbod in en laat het systeem automatisch bieden. Nooit meer een kans missen terwijl je er niet bent.',
                            'accent' => '#2E7A4F',
                        ],
                        [
                            'img' => 'inbox-prioriteit.jpg',
                            'bg' => '#FEF1E6',
                            'title' => 'Prioriteit in de inbox',
                            'desc' =>
                                'Jouw berichten worden bovenaan de inbox van verkopers geplaatst, zodat je sneller reactie krijgt.',
                            'accent' => '#E07B2A',
                        ],
                        [
                            'img' => 'statistieken.jpg',
                            'bg' => '#E8F3EC',
                            'title' => 'Advertentiestatistieken',
                            'desc' =>
                                'Zie per advertentie hoeveel mensen hem openden of opsloegen. Optimaliseer jouw listings op basis van data.',
                            'accent' => '#2E7A4F',
                        ],
                        [
                            'img' => 'push-notificaties.jpg',
                            'bg' => '#FEF1E6',
                            'title' => 'Push notificaties',
                            'desc' =>
                                'Kies categorieën, subcategorieën of specifieke items. Ontvang direct een melding bij nieuwe plaatsingen.',
                            'accent' => '#E07B2A',
                        ],
                        [
                            'img' => 'uitlichtende-border.jpg',
                            'bg' => '#E8F3EC',
                            'title' => 'Uitlichtende border',
                            'desc' =>
                                'Een gouden rand om jouw advertenties zodat kopers direct zien dat jij een premium verkoper bent.',
                            'accent' => '#2E7A4F',
                        ],
                        [
                            'img' => 'geen-advertenties.jpg',
                            'bg' => '#EEF0FE',
                            'title' => 'Geen advertenties',
                            'desc' => 'Geen banners, geen pop-ups. Browse DirectDeal schoon, snel en afleidingsvrij.',
                            'accent' => '#4F6AE0',
                        ],
                        [
                            'img' => '10-advertenties.jpg',
                            'bg' => '#FEF1E6',
                            'title' => '10 advertenties',
                            'desc' =>
                                'Gratis gebruikers mogen 5 advertenties plaatsen. Jij hebt ruimte voor 10 actieve listings tegelijk.',
                            'accent' => '#E07B2A',
                        ],
                        [
                            'img' => 'premium-badge.jpg',
                            'bg' => '#E8F3EC',
                            'title' => 'Premium badge',
                            'desc' =>
                                'Een zichtbare badge op jouw profiel toont kopers dat je een serieuze en actieve verkoper bent.',
                            'accent' => '#2E7A4F',
                        ],
                        [
                            'img' => 'geavanceerde-filters.jpg',
                            'bg' => '#E8F3EC',
                            'title' => 'Geavanceerde filters',
                            'desc' =>
                                'Filter de inbox op premium/non-premium, datum, tijd en meer. Vind precies wat je zoekt.',
                            'accent' => '#2E7A4F',
                        ],
                    ];
                @endphp

                @foreach ($features as $i => $f)
                    <div class="feat-card" style="--accent:{{ $f['accent'] }};">
                        <img
                            src="{{ asset('img/premium/' . $f['img']) }}"
                            alt="{{ $f['title'] }}"
                            class="feat-img"
                        >
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
                    <p class="section-desc">Premium gebruikers mogen 10 actieve advertenties plaatsen - gratis gebruikers
                        slechts 5.</p>
                </div>

                <div class="limit-grid">
                    <div class="limit-card free reveal">
                        <p
                            style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--dd-sage);margin:0 0 14px;">
                            Gratis</p>
                        <div style="display:flex;align-items:flex-end;gap:8px;margin-bottom:4px;">
                            <span class="limit-num">5</span>
                            <span style="font-size:0.9rem;color:var(--dd-sage);padding-bottom:10px;">advertenties</span>
                        </div>
                        <div class="limit-bar-track">
                            <div class="limit-bar-fill" data-fill="free"></div>
                        </div>
                    </div>
                    <div class="limit-card premium reveal">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                            <p
                                style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin:0;">
                                Premium</p>
                            <span class="prem-pill">Premium</span>
                        </div>
                        <div style="display:flex;align-items:flex-end;gap:8px;margin-bottom:4px;">
                            <span class="limit-num">10</span>
                            <span
                                style="font-size:0.9rem;color:rgba(255,255,255,0.4);padding-bottom:10px;">advertenties</span>
                        </div>
                        <div class="limit-bar-track">
                            <div class="limit-bar-fill" data-fill="prem"></div>
                        </div>
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
                                <td>
                                    @if ($r[1])
                                        <span class="yes">✓</span>
                                    @else
                                        <span class="no"></span>
                                    @endif
                                </td>
                                <td class="prem-col">
                                    @if ($r[2])
                                        <span class="yes">✓</span>
                                    @else
                                        <span class="no"></span>
                                    @endif
                                </td>
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
                    <p
                        style="font-size:0.66rem;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(255,255,255,0.28);margin:0 0 20px;">
                        Klaar om te starten?</p>
                    <h2 class="cta-banner-title">
                        Upgrade vandaag.<br>
                        <em>Maandelijks opzegbaar.</em>
                    </h2>
                    <p class="cta-banner-sub">
                        Slechts €9,99 per maand. Nooit meer nadenken over limieten of gemiste kansen.
                    </p>
                    @if(Auth::user()->is_premium)
                        <span class="btn-primary-lg is-purchased">
                            ✓ Je hebt al Premium
                        </span>
                        <div class="trust-row" style="margin-top:18px;">
                            <form action="{{ route('premium.cancel') }}" method="POST"
                                  onsubmit="return confirm('Weet je zeker dat je je abonnement wilt opzeggen?')">
                                @csrf
                                <button type="submit" class="trust-item"
                                        style="background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:8px;padding:6px 16px;cursor:pointer;font-family:inherit;font-size:0.75rem;color:rgba(255,255,255,0.45);transition:color 0.2s,border-color 0.2s;"
                                        onmouseover="this.style.color='rgba(255,255,255,0.7)';this.style.borderColor='rgba(255,255,255,0.4)'"
                                        onmouseout="this.style.color='rgba(255,255,255,0.45)';this.style.borderColor='rgba(255,255,255,0.2)'">
                                    Abonnement opzeggen
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('premium.checkout') }}" class="btn-primary-lg">
                            Start nu voor €9,99/maand
                            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <div class="trust-row">
                            <span class="trust-item">🔒 SSL beveiligd</span>
                            <span class="trust-item" style="color:rgba(255,255,255,0.12);">·</span>
                            <span class="trust-item">💳 Stripe Payments</span>
                            <span class="trust-item" style="color:rgba(255,255,255,0.12);">·</span>
                            <span class="trust-item">↩ 30 dagen garantie</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>

    {{-- Sticky mobile CTA --}}
    @if(!Auth::user()->is_premium)
        <div class="sticky-cta" id="stickyCta" style="display:none;">
            <a href="{{ route('premium.checkout') }}" class="btn-primary-lg"
                style="width:100%;justify-content:center;padding:13px 24px;font-size:0.95rem;">
                Upgrade voor €9,99/maand →
            </a>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        (function() {
            // Scroll-reveal (single + stagger) — animates both scrolling down AND up
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('visible');
                        // bar animations
                        e.target.querySelectorAll('[data-fill]').forEach(bar => {
                            const type = bar.dataset.fill;
                            setTimeout(() => {
                                bar.classList.add(type === 'free' ? 'animated-free' : 'animated-prem');
                            }, 350);
                        });
                    } else {
                        // Reset when element leaves viewport so it re-animates on scroll back
                        e.target.classList.remove('visible');
                        e.target.querySelectorAll('[data-fill]').forEach(bar => {
                            bar.classList.remove('animated-free', 'animated-prem');
                        });
                    }
                });
            }, {
                threshold: 0.12
            });

            document.querySelectorAll('.reveal, .reveal-stagger').forEach(el => observer.observe(el));

            // Bar animations (for bars not inside .reveal)
            document.querySelectorAll('[data-fill]').forEach(bar => {
                const barObs = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        const type = bar.dataset.fill;
                        setTimeout(() => {
                            bar.classList.add(type === 'free' ? 'animated-free' : 'animated-prem');
                        }, 400);
                    } else {
                        bar.classList.remove('animated-free', 'animated-prem');
                    }
                }, {
                    threshold: 0.3
                });
                barObs.observe(bar);
            });

            // Sticky CTA: show after hero scrolls out of view
            const hero = document.querySelector('.hero');
            const stickyCta = document.getElementById('stickyCta');
            if (hero && stickyCta) {
                const stickyObs = new IntersectionObserver((entries) => {
                    stickyCta.style.display = entries[0].isIntersecting ? 'none' : 'block';
                }, {
                    threshold: 0
                });
                stickyObs.observe(hero);
            }
        })();
    </script>
@endpush