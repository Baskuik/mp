<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ListingStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Aanbiedingen', Listing::count())
                ->description('Alle aanbiedingen')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('success'),

            Stat::make('Actief', Listing::where('status', 'active')->count())
                ->description('Actieve aanbiedingen')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Verkocht', Listing::where('status', 'sold')->count())
                ->description('Verkochte aanbiedingen')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),

            Stat::make('Inactief', Listing::where('status', 'inactive')->count())
                ->description('Inactieve aanbiedingen')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Gearchiveerd', Listing::where('status', 'archived')->count())
                ->description('Gearchiveerde aanbiedingen')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('warning'),
        ];
    }
}
