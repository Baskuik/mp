<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Users', User::count())
                ->description('Alle accounts')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('success'),

            Stat::make('Actief', User::where('is_active', true)->count())
                ->description('Actieve accounts')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Admins', User::where('is_admin', true)->count())
                ->description('Beheerders')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Geverifieerd', User::whereNotNull('email_verified_at')->count())
                ->description('Email bevestigd')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('success'),
        ];
    }
}