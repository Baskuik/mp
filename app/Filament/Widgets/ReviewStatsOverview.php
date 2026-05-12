<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReviewStatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Reviews', Review::count())
                ->description('Alle reviews')
                ->descriptionIcon('heroicon-m-star')
                ->color('success')
                ->columnSpan(1),

            Stat::make('Gemiddeld Rating', number_format(Review::avg('rating') ?? 0, 1))
                ->description('Gemiddelde beoordeling')
                ->descriptionIcon('heroicon-m-star')
                ->color('info')
                ->columnSpan(1),
        ];
    }
}
