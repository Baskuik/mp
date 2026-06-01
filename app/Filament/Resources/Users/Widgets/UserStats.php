<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('TOTAAL USERS'), User::count())
                ->description('Alle accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make(__('ACTIEF'), User::where('is_active', true)->count())
                ->description('100% actief')
                ->color('success'),
            Stat::make(__('ADMINS'), User::where('is_admin', true)->count())
                ->description('Beheerders')
                ->color('success'),
        ];
    }
}