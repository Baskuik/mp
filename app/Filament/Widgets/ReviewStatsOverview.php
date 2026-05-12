<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Reviews', Review::count())
                ->description('Alle reviews')
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),

            Stat::make('Actief', Review::where('reviews_active', true)->count())
                ->description('Actieve reviews')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Gemiddeld Rating', number_format(Review::avg('rating') ?? 0, 1))
                ->description('Gemiddelde beoordeling')
                ->descriptionIcon('heroicon-m-star')
                ->color('info'),

            Stat::make('Inactief', Review::where('reviews_active', false)->count())
                ->description('Verborgen reviews')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
