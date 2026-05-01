<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEWER_ID)
                    ->label(__('Reviewer ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEWEE_ID)
                    ->label(__('Reviewee ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEW_RATING)
                    ->label(__('Rating'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label(__('Comment'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::CREATED_AT)
                    ->label(__('Created At'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Review::UPDATED_AT)
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
