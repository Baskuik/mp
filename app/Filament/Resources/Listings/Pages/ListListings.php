<?php

namespace App\Filament\Resources\Listings\Pages;

use App\Filament\Resources\Listings\ListingResource;
use App\Models\Listing;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListings extends ListRecords
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        $options = [
            'active'   => 'Actief',
            'sold'     => 'Verkocht',
            'archived' => 'Gearchiveerd',
        ];

        $actions = [
            Actions\Action::make('tab-alle')
                ->label('Alle')
                ->url('?')
                ->color('success')
                ->outlined(!empty($activeTabs))
                ->size('sm'),
        ];

        foreach ($options as $value => $label) {
            $isActive = in_array($value, $activeTabs);
            $newTabs  = $isActive
                ? array_filter($activeTabs, fn ($t) => $t !== $value)
                : array_merge($activeTabs, [$value]);

            $actions[] = Actions\Action::make("tab-{$value}")
                ->label($label)
                ->url('?' . http_build_query(['tab' => array_values($newTabs)]))
                ->color('success')
                ->outlined(!$isActive)
                ->size('sm');
        }

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
            $table->modifyQueryUsing(fn ($query) => $query->whereIn(Listing::LISTING_STATUS, $activeTabs));
        }

        return $table;
    }
}