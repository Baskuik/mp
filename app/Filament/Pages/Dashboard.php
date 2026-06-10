<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BannedUsersWidget;
use App\Filament\Widgets\BidStatsOverview;
use App\Filament\Widgets\BidsOverTimeChart;
use App\Filament\Widgets\CategoryStatsOverview;
use App\Filament\Widgets\ConversationStatsWidget;
use App\Filament\Widgets\ListingsByLocationWidget;
use App\Filament\Widgets\ListingStatsOverview;
use App\Filament\Widgets\NewListingsChart;
use App\Filament\Widgets\NewUsersChart;
use App\Filament\Widgets\PremiumStatsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\ReviewRatingDistributionWidget;
use App\Filament\Widgets\ReviewStatsOverview;
use App\Filament\Widgets\SoftDeletedListingsWidget;
use App\Filament\Widgets\TopCategoriesWidget;
use App\Filament\Widgets\UserStatsOverview;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            // Stats
            UserStatsOverview::class,
            PremiumStatsWidget::class,
            BannedUsersWidget::class,
            CategoryStatsOverview::class,
            ListingStatsOverview::class,
            SoftDeletedListingsWidget::class,
            BidStatsOverview::class,
            ReviewStatsOverview::class,
            ConversationStatsWidget::class,
            // Charts
            NewUsersChart::class,
            NewListingsChart::class,
            BidsOverTimeChart::class,
            ReviewRatingDistributionWidget::class,
            // Tabellen
            RecentActivityWidget::class,
            TopCategoriesWidget::class,
            ListingsByLocationWidget::class,
        ];
    }
}