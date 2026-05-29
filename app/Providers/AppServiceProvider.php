<?php

namespace App\Providers;

use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Number::useLocale('nl');
    }

    public function boot(): void
    {
        // Sidebar styling + theme switcher verbergen
        FilamentView::registerRenderHook(
            'panels::styles.after',
            fn(): string => Blade::render('<style>
                .fi-sidebar { background-color: #2d5036 !important; }
                .fi-sidebar-item-button { color: white !important; }
                .fi-sidebar-group-label { color: #a1a1aa !important; }
                .fi-sidebar-item-active { background-color: rgba(255, 255, 255, 0.1) !important; }

                /* Verberg de originele theme switcher */
                .fi-user-menu-theme-switcher { display: none !important; }

                /* Taalwisselaar styling */
                .dd-lang-switcher {
                    display: flex;
                    gap: 6px;
                    padding: 10px 14px;
                    border-bottom: 1px solid rgba(0,0,0,0.07);
                }
                .dd-lang-btn {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 2px;
                    padding: 6px 4px;
                    border-radius: 8px;
                    border: 1px solid transparent;
                    background: transparent;
                    cursor: pointer;
                    font-size: 18px;
                    transition: background 0.15s, border-color 0.15s;
                    text-decoration: none;
                }
                .dd-lang-btn:hover {
                    background: rgba(0,0,0,0.06);
                    border-color: rgba(0,0,0,0.1);
                }
                .dd-lang-btn.active {
                    background: rgba(45,80,54,0.1);
                    border-color: #2d5036;
                }
                .dd-lang-label {
                    font-size: 10px;
                    font-weight: 600;
                    letter-spacing: 0.3px;
                    color: #555;
                    line-height: 1;
                }
                .dd-lang-btn.active .dd-lang-label {
                    color: #2d5036;
                }

                @media (prefers-color-scheme: dark) {
                    .dd-lang-switcher { border-bottom-color: rgba(255,255,255,0.08); }
                    .dd-lang-btn:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); }
                    .dd-lang-btn.active { background: rgba(255,255,255,0.12); border-color: #86efac; }
                    .dd-lang-label { color: #aaa; }
                    .dd-lang-btn.active .dd-lang-label { color: #86efac; }
                }
            </style>'),
        );

FilamentView::registerRenderHook(
    'panels::user-menu.profile.after',
    fn(): string => Blade::render('
        <div class="dd-lang-switcher">
            <a href="{{ route(\'set-language\', \'nl\') }}?redirect={{ urlencode(request()->url()) }}" 
               class="dd-lang-btn {{ app()->getLocale() === "nl" ? "active" : "" }}">
                <span>🇳🇱</span>
                <span class="dd-lang-label">NL</span>
            </a>
            <a href="{{ route(\'set-language\', \'en\') }}?redirect={{ urlencode(request()->url()) }}"
               class="dd-lang-btn {{ app()->getLocale() === "en" ? "active" : "" }}">
                <span>🇬🇧</span>
                <span class="dd-lang-label">EN</span>
            </a>
            <a href="{{ route(\'set-language\', \'de\') }}?redirect={{ urlencode(request()->url()) }}"
               class="dd-lang-btn {{ app()->getLocale() === "de" ? "active" : "" }}">
                <span>🇩🇪</span>
                <span class="dd-lang-label">DE</span>
            </a>
        </div>
    '),
);
    }
}