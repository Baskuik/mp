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
                    ->placeholder(__('Geen ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::USER_ID)
                    ->label(__('Seller ID'))
                    ->placeholder(__('Geen seller ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CATEGORY_ID)
                    ->label(__('Category ID'))
                    ->placeholder(__('Geen category ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_TITLE)
                    ->label(__('Title'))
                    ->placeholder(__('Geen titel beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label(__('Description'))
                    ->placeholder(__('Geen beschrijving beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_PRICE)
                    ->label(__('Price'))
                    ->placeholder(__('Geen prijs beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_STATUS)
                    ->label(__('Status'))
                    ->placeholder(__('Geen status beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label(__('Location'))
                    ->placeholder(__('Geen locatie beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder(__('Geen datum beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::UPDATED_AT)
                    ->label(__('Updated At'))
                    ->placeholder(__('Geen datum beschikbaar'))
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
