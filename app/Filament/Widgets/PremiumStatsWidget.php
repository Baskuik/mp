<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PremiumStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $total   = User::count();
        $premium = User::where('is_premium', true)->count();
        $free    = $total - $premium;
        $ratio   = $total > 0 ? round(($premium / $total) * 100, 1) : 0;
        $revenue = $premium * 9.99;

        return [
            Stat::make('Premium gebruikers', $premium)
                ->description('Van totaal ' . $total . ' gebruikers')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->icon('heroicon-o-star'),

            Stat::make('Premium ratio', $ratio . '%')
                ->description($free . ' gratis vs ' . $premium . ' premium')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('info')
                ->icon('heroicon-o-chart-pie'),

            Stat::make('Geschatte omzet', '€ ' . number_format($revenue, 2, ',', '.'))
                ->description('Op basis van €9,99/maand')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success')
                ->icon('heroicon-o-banknotes'),
        ];
    }
}