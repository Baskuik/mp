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
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;

class Dashboard extends \Filament\Pages\Dashboard implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.dashboard';

    protected array $widgetMap = [
        'users' => [
            UserStatsOverview::class  => 'Gebruikersstatistieken',
            PremiumStatsWidget::class => 'Premium statistieken',
            BannedUsersWidget::class  => 'Verbannen gebruikers',
            NewUsersChart::class      => 'Nieuwe gebruikers (grafiek)',
        ],
        'categories' => [
            CategoryStatsOverview::class => 'Categoriestatistieken',
            TopCategoriesWidget::class   => 'Top categorieën',
        ],
        'listings' => [
            ListingStatsOverview::class       => 'Advertentiestatistieken',
            SoftDeletedListingsWidget::class  => 'Verwijderde advertenties',
            NewListingsChart::class           => 'Nieuwe advertenties (grafiek)',
            ListingsByLocationWidget::class   => 'Advertenties per locatie',
            RecentActivityWidget::class       => 'Recente activiteit',
        ],
        'bids' => [
            BidStatsOverview::class  => 'Biedingsstatistieken',
            BidsOverTimeChart::class => 'Biedingen over tijd (grafiek)',
        ],
        'reviews' => [
            ReviewStatsOverview::class            => 'Reviewstatistieken',
            ReviewRatingDistributionWidget::class => 'Ratingverdeling (grafiek)',
        ],
        'conversations' => [
            ConversationStatsWidget::class => 'Gespreksstatistieken',
        ],
    ];

    public string $selectedPage   = 'users';
    public array  $enabledWidgets = [];

    public array $data = [];

    public function mount(): void
{
    $this->selectedPage   = session('dashboard_page', 'users');
    $this->enabledWidgets = session(
        'dashboard_enabled_widgets',
        array_keys($this->widgetMap[$this->selectedPage] ?? [])
    );

    $this->form->fill([
        'selectedPage'   => $this->selectedPage,
        'enabledWidgets' => $this->enabledWidgets,
    ]);
}

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('🗂️ Widget Selector')
                    ->description('Kies een sectie en schakel widgets in of uit.')
                    ->schema([
                        Select::make('selectedPage')
                            ->label('Selecteer een pagina')
                            ->options([
                                'users'         => '👤 Gebruikers',
                                'categories'    => '📂 Categorieën',
                                'listings'      => '📋 Advertenties',
                                'bids'          => '💰 Biedingen',
                                'reviews'       => '⭐ Reviews',
                                'conversations' => '💬 Gesprekken',
                            ])
                            ->live()
                            ->afterStateUpdated(function (string $state) {
                                $this->selectedPage   = $state;
                                $this->enabledWidgets = array_keys($this->widgetMap[$state] ?? []);
                                session([
                                    'dashboard_page'            => $state,
                                    'dashboard_enabled_widgets' => $this->enabledWidgets,
                                ]);
                                $this->form->fill([
                                    'selectedPage'   => $this->selectedPage,
                                    'enabledWidgets' => $this->enabledWidgets,
                                ]);
                            }),

                        CheckboxList::make('enabledWidgets')
                            ->label('Zichtbare widgets')
                            ->options(fn () => $this->widgetMap[$this->selectedPage] ?? [])
                            ->live()
                            ->afterStateUpdated(function (array $state) {
                                $this->enabledWidgets = $state;
                                session(['dashboard_enabled_widgets' => $state]);
                            })
                            ->columns(3),
                    ]),
            ])
            ->statePath('data');
    }

    public function getWidgets(): array
    {
        return $this->enabledWidgets;
    }
}