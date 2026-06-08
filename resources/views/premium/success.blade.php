@extends('layouts.app')

@section('title', 'Betaling geslaagd · DirectDeal')

@push('styles')
<style>
    body { background: #F2F5F3 !important; font-family: 'DM Sans', sans-serif; }

    .success-wrap {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
    }
    .success-card {
        background: #fff;
        border: 1px solid #DDE4DF;
        border-radius: 24px;
        padding: 56px 48px;
        max-width: 480px;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }
    .success-icon {
        width: 72px; height: 72px;
        background: linear-gradient(135deg, #245C3A, #2E7A4F);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 28px;
        font-size: 32px;
        box-shadow: 0 8px 24px rgba(26,61,43,0.25);
    }
    .success-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #162218;
        margin: 0 0 12px;
    }
    .success-sub {
        font-size: 0.95rem;
        color: #7BA98A;
        line-height: 1.6;
        margin: 0 0 36px;
    }
    .btn-home {
        display: inline-block;
        background: linear-gradient(135deg, #245C3A, #2E7A4F);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 14px 32px;
        border-radius: 12px;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-home:hover { opacity: 0.88; }
</style>
@endpush

@section('content')
<div class="success-wrap">
    <div class="success-card">
        <div class="success-icon">👑</div>
        <h1 class="success-title">Welkom bij Premium!</h1>
        <p class="success-sub">
            Je betaling is geslaagd. Je account is direct geüpgraded —
            geniet van alle Premium voordelen.
        </p>
        <a href="{{ url('/') }}" class="btn-home">Ga naar home →</a>
    </div>
</div>
@endsection