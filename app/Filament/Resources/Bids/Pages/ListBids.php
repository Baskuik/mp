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

        $allowedTabs = ['pending', 'accepted', 'rejected', 'cancelled'];  
        $activeTabs = request()->query('tab', []);  
        $activeTabs = is_string($activeTabs) ? [$activeTabs] : (is_array($activeTabs) ? $activeTabs : []);  
        $activeTabs = array_values(array_filter(  
            $activeTabs,  
            fn ($tab) => is_string($tab) && in_array($tab, $allowedTabs, true),  
        ));  

        if (!empty($activeTabs)) {
            $table->modifyQueryUsing(fn($query) => $query->whereIn(Bid::STATUS, $activeTabs));
        }

        return $table;
    }
}