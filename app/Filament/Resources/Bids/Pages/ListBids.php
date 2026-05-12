<?php

namespace App\Filament\Resources\Bids\Pages;

use App\Filament\Resources\Bids\BidResource;
use App\Filament\Resources\Traits\HasQueryTabActions;
use App\Models\Bid;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBids extends ListRecords
{
    use HasQueryTabActions;

    protected static string $resource = BidResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\BidStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        $tabOptions = [
            'pending' => 'In behandeling',
            'accepted' => 'Geaccepteerd',
            'rejected' => 'Afgewezen',
            'cancelled' => 'Geannuleerd',
        ];

        $actions = $this->buildTabActions($tabOptions);
        $actions[] = Actions\CreateAction::make()->label('Bieding aanmaken');

        return $actions;
    }

    public function getTable(): \Filament\Tables\Table
    {
        $table = parent::getTable();

        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        if (!empty($activeTabs)) {
            $table->modifyQueryUsing(fn($query) => $query->whereIn(Bid::STATUS, $activeTabs));
        }

        return $table;
    }
}