<?php

namespace App\Filament\Resources\Listings\Tables;

use App\Models\Listing;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Listing::LISTING_ID)
                    ->label(__('ID'))
                    ->placeholder('Geen ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::USER_ID)
                    ->label(__('Seller ID'))
                    ->placeholder('Geen seller ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CATEGORY_ID)
                    ->label(__('Category ID'))
                    ->placeholder('Geen category ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_TITLE)
                    ->label(__('Title'))
                    ->placeholder('Geen titel beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label(__('Description'))
                    ->placeholder('Geen beschrijving beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_PRICE)
                    ->label(__('Price'))
                    ->placeholder('Geen prijs beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_STATUS)
                    ->label(__('Status'))
                    ->placeholder('Geen status beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label(__('Location'))
                    ->placeholder('Geen locatie beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::UPDATED_AT)
                    ->label(__('Updated At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
