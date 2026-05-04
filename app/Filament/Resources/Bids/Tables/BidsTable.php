<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use function Laravel\Prompts\search;

class BidsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Bid::BID_ID)
                    ->label(__('ID'))
                    ->placeholder(__('Geen ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::LISTING_ID)
                    ->label(__('Listing ID'))
                    ->placeholder(__('Geen listing ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::BUYER_ID)
                    ->label(__('Buyer ID'))
                    ->placeholder(__('Geen buyer ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::AMOUNT)
                    ->label(__('Amount'))
                    ->placeholder(__('Geen bedrag beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::STATUS)
                    ->label(__('Status'))
                    ->placeholder(__('Geen status beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder(__('Geen datum beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Bid::UPDATED_AT)
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
