<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | DirectDeal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="font-sans antialiased">
    <x-navbar />
    <main>
        @yield('content')
    </main>

    {{-- Flash notificatie --}}
    @if (session('error'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 6000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        style="position:fixed; bottom:24px; right:24px; z-index:9999; width:360px;"
    >
        <div style="
            background: #fff;
            border: 1px solid #FECACA;
            border-left: 4px solid #EF4444;
            border-radius: 12px;
            padding: 16px 18px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            display: flex;
            align-items: flex-start;
            gap: 12px;
        ">
            <div style="
                width: 32px; height: 32px; border-radius: 50%;
                background: #FEF2F2;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0; font-size: 15px;
            ">⚠️</div>
            <div style="flex: 1; min-width: 0;">
                <p style="margin:0 0 2px; font-weight:600; font-size:0.875rem; color:#111827;">
                    Betaling niet geslaagd
                </p>
                <p style="margin:0; font-size:0.8rem; color:#6B7280; line-height:1.5;">
                    {{ session('error') }}
                </p>
            </div>
            <button @click="show = false" style="
                background: none; border: none; cursor: pointer;
                color: #9CA3AF; font-size: 16px; line-height: 1;
                padding: 0; flex-shrink: 0;
            ">✕</button>
        </div>
    </div>
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>