<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Review::REVIEW_ID)
                    ->label(__('ID'))
                    ->placeholder(__('Geen ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEWER_ID)
                    ->label(__('Reviewer ID'))
                    ->placeholder(__('Geen reviewer ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEWEE_ID)
                    ->label(__('Reviewee ID'))
                    ->placeholder(__('Geen reviewee ID beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEW_RATING)
                    ->label(__('Rating'))
                    ->placeholder(__('Geen rating beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label(__('Comment'))
                    ->placeholder(__('Geen commentaar beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder(__('Geen datum beschikbaar'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::UPDATED_AT)
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
