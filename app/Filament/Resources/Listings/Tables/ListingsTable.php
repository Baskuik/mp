<?php

namespace App\Filament\Resources\Listings\Tables;

use App\Models\Listing;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::USER_ID)
                    ->label(__('Seller ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CATEGORY_ID)
                    ->label(__('Category ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_TITLE)
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label(__('Description'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_PRICE)
                    ->label(__('Price'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_STATUS)
                    ->label(__('Status'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label(__('Location'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::CREATED_AT)
                    ->label(__('Created At'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Listing::UPDATED_AT)
                    ->label(__('Updated At'))
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
