<?php

namespace App\Filament\Widgets;

use App\Models\Bid;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BidStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Biedingen', Bid::count())
                ->description('Alle biedingen')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('success'),

            Stat::make('Actief', Bid::where('status', 'active')->count())
                ->description('Actieve biedingen')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Geaccepteerd', Bid::where('status', 'accepted')->count())
                ->description('Geaccepteerde biedingen')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make('Afgewezen', Bid::where('status', 'rejected')->count())
                ->description('Afgewezen biedingen')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
