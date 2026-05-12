<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BidStatsOverview;
use App\Filament\Widgets\CategoryStatsOverview;
use App\Filament\Widgets\ListingStatsOverview;
use App\Filament\Widgets\ReviewStatsOverview;
use App\Filament\Widgets\UserStatsOverview;
use Filament\Pages\Dashboard;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
            CategoryStatsOverview::class,
            ListingStatsOverview::class,
            BidStatsOverview::class,
            ReviewStatsOverview::class,
        ];
    }
}
