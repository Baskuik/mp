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
        if (!extension_loaded('intl')) {
            putenv('PATH=' . getenv('PATH') . ';C:\xampp\php');
            if (extension_loaded('intl')) {
                Number::useLocale('nl');
            }
        } else {
            Number::useLocale('nl');
        }
    }

   public function boot(): void
{
    FilamentView::registerRenderHook(
        'panels::styles.after',
        fn (): string => Blade::render('<style>
            .fi-sidebar { background-color: #2d5036 !important; }
            .fi-sidebar-item-button { color: white !important; }
            .fi-sidebar-group-label { color: #a1a1aa !important; }
            .fi-sidebar-item-active { background-color: rgba(255, 255, 255, 0.1) !important; }
        </style>'),
    );
}
}