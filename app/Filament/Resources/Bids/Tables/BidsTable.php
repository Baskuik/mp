<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BidsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Bid::BID_ID)
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::LISTING_ID)
                    ->label(__('Listing ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::BUYER_ID)
                    ->label(__('Buyer ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::AMOUNT)
                    ->label(__('Amount'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::STATUS)
                    ->label(__('Status'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::CREATED_AT)
                    ->label(__('Created At'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::UPDATED_AT)
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
