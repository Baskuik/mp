<?php

namespace App\Filament\Resources\Listings\Pages;

use App\Filament\Resources\Listings\ListingResource;
use App\Filament\Resources\Traits\HasQueryTabActions;
use App\Models\Listing;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListings extends ListRecords
{
    use HasQueryTabActions;

    protected static string $resource = ListingResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ListingStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        $tabOptions = [
            'active' => 'Actief',
            'sold' => 'Verkocht',
            'inactive' => 'Inactief',
            'archived' => 'Gearchiveerd',
        ];

        $actions = $this->buildTabActions($tabOptions);
        $actions[] = Actions\CreateAction::make()->label('Advertentie aanmaken');

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
            $table->modifyQueryUsing(fn($query) => $query->whereIn(Listing::LISTING_STATUS, $activeTabs));
        }

        return $table;
    }
}