<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Totaal Categorieën', Category::count())
                ->description('Alle categorieën')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->color('success'),

            Stat::make('Actief', Category::where('category_active', true)->count())
                ->description('Actieve categorieën')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Subcategorieën', Category::whereNotNull('parent_id')->count())
                ->description('Onderliggende categorieën')
                ->descriptionIcon('heroicon-m-folder')
                ->color('info'),

            Stat::make('Inactief', Category::where('category_active', false)->count())
                ->description('Verborgen categorieën')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
