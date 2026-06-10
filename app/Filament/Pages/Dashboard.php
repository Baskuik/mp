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
    protected static string $view = 'filament.pages.dashboard';

    // Alle widgets per pagina
    protected array $widgetMap = [
        'users' => [
            UserStatsOverview::class,
            PremiumStatsWidget::class,
            BannedUsersWidget::class,
            NewUsersChart::class,
        ],
        'categories' => [
            CategoryStatsOverview::class,
            TopCategoriesWidget::class,
        ],
        'listings' => [
            ListingStatsOverview::class,
            SoftDeletedListingsWidget::class,
            NewListingsChart::class,
            ListingsByLocationWidget::class,
            RecentActivityWidget::class,
        ],
        'bids' => [
            BidStatsOverview::class,
            BidsOverTimeChart::class,
        ],
        'reviews' => [
            ReviewStatsOverview::class,
            ReviewRatingDistributionWidget::class,
        ],
        'conversations' => [
            ConversationStatsWidget::class,
        ],
    ];

    // Vriendelijke namen voor de widgets
    protected array $widgetLabels = [
        UserStatsOverview::class          => 'Gebruikersstatistieken',
        PremiumStatsWidget::class         => 'Premium statistieken',
        BannedUsersWidget::class          => 'Verbannen gebruikers',
        NewUsersChart::class              => 'Nieuwe gebruikers (grafiek)',
        CategoryStatsOverview::class      => 'Categoriestatistieken',
        TopCategoriesWidget::class        => 'Top categorieën',
        ListingStatsOverview::class       => 'Advertentiestatistieken',
        SoftDeletedListingsWidget::class  => 'Verwijderde advertenties',
        NewListingsChart::class           => 'Nieuwe advertenties (grafiek)',
        ListingsByLocationWidget::class   => 'Advertenties per locatie',
        RecentActivityWidget::class       => 'Recente activiteit',
        BidStatsOverview::class           => 'Biedingsstatistieken',
        BidsOverTimeChart::class          => 'Biedingen over tijd (grafiek)',
        ReviewStatsOverview::class        => 'Reviewstatistieken',
        ReviewRatingDistributionWidget::class => 'Ratingverdeling (grafiek)',
        ConversationStatsWidget::class    => 'Gespreksstatistieken',
    ];

    public string $selectedPage = 'users';
    public array $enabledWidgets = [];

    public function mount(): void
    {
        $this->selectedPage  = session('dashboard_page', 'users');
        $this->enabledWidgets = session('dashboard_enabled_widgets', $this->widgetMap[$this->selectedPage] ?? []);
    }

    public function updatedSelectedPage(string $value): void
    {
        $this->selectedPage   = $value;
        $this->enabledWidgets = $this->widgetMap[$value] ?? [];
        session(['dashboard_page' => $value, 'dashboard_enabled_widgets' => $this->enabledWidgets]);
    }

    public function toggleWidget(string $widget): void
    {
        if (in_array($widget, $this->enabledWidgets)) {
            $this->enabledWidgets = array_values(array_filter(
                $this->enabledWidgets,
                fn($w) => $w !== $widget
            ));
        } else {
            $this->enabledWidgets[] = $widget;
        }
        session(['dashboard_enabled_widgets' => $this->enabledWidgets]);
    }

    public function toggleAll(): void
    {
        $all = $this->widgetMap[$this->selectedPage] ?? [];
        if (count($this->enabledWidgets) === count($all)) {
            $this->enabledWidgets = [];
        } else {
            $this->enabledWidgets = $all;
        }
        session(['dashboard_enabled_widgets' => $this->enabledWidgets]);
    }

    public function getWidgets(): array
    {
        return $this->enabledWidgets;
    }

    public function getAvailableWidgets(): array
    {
        return $this->widgetMap[$this->selectedPage] ?? [];
    }

    public function getWidgetLabel(string $widget): string
    {
        return $this->widgetLabels[$widget] ?? class_basename($widget);
    }

    public function getPageOptions(): array
    {
        return [
            'users'         => 'Gebruikers',
            'categories'    => 'Categorieën',
            'listings'      => 'Advertenties',
            'bids'          => 'Biedingen',
            'reviews'       => 'Reviews',
            'conversations' => 'Gesprekken',
        ];
    }
}