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
use App\Models\UserWidgetPreference;
use Illuminate\Support\Facades\Auth;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected string $view = 'filament.pages.dashboard';
    
    protected array $widgetMap = [
        'users' => [
            UserStatsOverview::class  => 'Gebruikersstatistieken',
            PremiumStatsWidget::class => 'Premium statistieken',
            BannedUsersWidget::class  => 'Verbannen gebruikers',
            NewUsersChart::class      => 'Nieuwe gebruikers',
        ],
        'categories' => [
            CategoryStatsOverview::class => 'Categoriestatistieken',
            TopCategoriesWidget::class   => 'Top categorieën',
        ],
        'listings' => [
            ListingStatsOverview::class      => 'Advertentiestatistieken',
            SoftDeletedListingsWidget::class => 'Verwijderde advertenties',
            NewListingsChart::class          => 'Nieuwe advertenties',
            ListingsByLocationWidget::class  => 'Per locatie',
            RecentActivityWidget::class      => 'Recente activiteit',
        ],
        'bids' => [
            BidStatsOverview::class  => 'Biedingsstatistieken',
            BidsOverTimeChart::class => 'Biedingen over tijd',
        ],
        'reviews' => [
            ReviewStatsOverview::class            => 'Reviewstatistieken',
            ReviewRatingDistributionWidget::class => 'Ratingverdeling',
        ],
        'conversations' => [
            ConversationStatsWidget::class => 'Gespreksstatistieken',
        ],
    ];

    // ──────────────────────────────────────────────────────────────
    // Livewire state
    // ──────────────────────────────────────────────────────────────
    public string $selectedPage = 'users';

    /**
     * enabledWidgets = array van widget-classnames die momenteel AAN staan
     * voor de geselecteerde pagina.
     * @var array<string>
     */
    public array $enabledWidgets = [];

    // ──────────────────────────────────────────────────────────────
    // Boot
    // ──────────────────────────────────────────────────────────────
    public function mount(): void
    {
        $this->selectedPage = 'users';
        $this->loadEnabledWidgets();
    }

    // ──────────────────────────────────────────────────────────────
    // Livewire lifecycle — reageert op wire:model.live="selectedPage"
    // ──────────────────────────────────────────────────────────────
    public function updatedSelectedPage(string $value): void
    {
        $this->loadEnabledWidgets();
    }

    // ──────────────────────────────────────────────────────────────
    // Widget-toggles — aangeroepen vanuit de view via Livewire action
    // ──────────────────────────────────────────────────────────────

    /**
     * Zet een widget aan of uit en persisteer de keuze in de DB.
     */
    public function toggleWidget(string $widgetClass): void
    {
        $isEnabled = in_array($widgetClass, $this->enabledWidgets, true);
        $newState  = ! $isEnabled;

        UserWidgetPreference::setWidget(
            userId:  Auth::id(),
            page:    $this->selectedPage,
            widget:  $widgetClass,
            enabled: $newState,
        );

        // Update lokale state
        if ($newState) {
            // Voeg toe op de originele positie (volgorde uit widgetMap bewaren)
            $ordered = array_keys($this->widgetMap[$this->selectedPage] ?? []);
            $this->enabledWidgets = array_values(
                array_filter($ordered, fn ($w) => $w === $widgetClass || in_array($w, $this->enabledWidgets, true))
            );
        } else {
            $this->enabledWidgets = array_values(
                array_filter($this->enabledWidgets, fn ($w) => $w !== $widgetClass)
            );
        }
    }

    // ──────────────────────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────────────────────

    /**
     * Laad de enabled-widgets voor de huidige pagina vanuit de DB.
     */
    protected function loadEnabledWidgets(): void
    {
        $all = array_keys($this->widgetMap[$this->selectedPage] ?? []);

        $this->enabledWidgets = array_values(
            UserWidgetPreference::enabledForPage(Auth::id(), $this->selectedPage, $all)
        );
    }

    /**
     * Geeft alle widgets voor de geselecteerde pagina terug,
     * inclusief of ze enabled zijn — voor de toggle-UI in de view.
     *
     * @return array<array{class: string, label: string, enabled: bool}>
     */
    public function getWidgetRows(): array
    {
        $rows = [];
        foreach ($this->widgetMap[$this->selectedPage] ?? [] as $class => $label) {
            $rows[] = [
                'class'   => $class,
                'label'   => $label,
                'enabled' => in_array($class, $this->enabledWidgets, true),
            ];
        }
        return $rows;
    }

    /**
     * Filament roept dit aan om te weten welke widgets te renderen.
     * Wij retourneren alleen de enabled widgets.
     *
     * @return array<string>
     */
    public function getWidgets(): array
    {
        return $this->enabledWidgets;
    }
}