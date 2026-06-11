<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class SoftDeletedListingsWidget extends BaseWidget
{
    protected static ?int $sort = 6;
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $totalDeleted    = Listing::onlyTrashed()->count();
        $deletedThisWeek = Listing::onlyTrashed()
            ->where('deleted_at', '>=', Carbon::now()->subWeek())
            ->count();
        $activeListings  = Listing::whereNull('deleted_at')->count();

        return [
            Stat::make('Verwijderde advertenties', $totalDeleted)
                ->description('Totaal soft-deleted')
                ->descriptionIcon('heroicon-m-trash')
                ->color('danger')
                ->icon('heroicon-o-trash'),

            Stat::make('Verwijderd deze week', $deletedThisWeek)
                ->description('Afgelopen 7 dagen')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Actieve advertenties', $activeListings)
                ->description('Niet verwijderd')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}