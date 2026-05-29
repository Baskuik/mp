<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Review::REVIEW_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Review::REVIEWER_ID)
                    ->label(__('reviews.col_reviewer_id'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Review::REVIEWEE_ID)
                    ->label(__('reviews.col_reviewee_id'))
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Review::LISTING_ID)
                    ->label(__('reviews.col_listing_id'))
                    ->placeholder(__('reviews.col_listing_placeholder'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_RATING)
                    ->label(__('reviews.col_rating'))
                    ->icon('heroicon-m-star')
                    ->iconColor('warning')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label(__('reviews.col_comment'))
                    ->searchable()
                    ->limit(50)
                    ->placeholder('—')
                    ->toggleable(),

                IconColumn::make('reviews_active')
                    ->label(__('reviews.col_active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(Review::CREATED_AT)
                    ->label(__('reviews.col_date'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Review::UPDATED_AT)
                    ->label(__('reviews.col_updated_at'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make(Review::REVIEW_RATING)
                    ->label(__('reviews.col_rating'))
                    ->native(false)
                    ->searchable()
                    ->options([
                        1 => __('reviews.rating_1'),
                        2 => __('reviews.rating_2'),
                        3 => __('reviews.rating_3'),
                        4 => __('reviews.rating_4'),
                        5 => __('reviews.rating_5'),
                    ]),

                Filter::make('actief')
                    ->label(__('reviews.filter_active'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('reviews_active', true)),

                Filter::make('verwijderd')
                    ->label(__('reviews.filter_inactive'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('reviews_active', false)),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading(__('reviews.delete_heading'))
                    ->modalDescription(__('reviews.delete_desc'))
                    ->modalSubmitActionLabel(__('reviews.delete_confirm'))
                    ->action(function (Review $record) {
                        $record->update(['reviews_active' => false]);

                        Notification::make()
                            ->title(__('reviews.notify_deleted'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('bulk_delete')
                    ->label(__('reviews.bulk_delete_label'))
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('reviews.bulk_delete_heading'))
                    ->modalDescription(__('reviews.bulk_delete_desc'))
                    ->modalSubmitActionLabel(__('reviews.bulk_delete_confirm'))
                    ->action(function (Collection $records) {
                        $records->each(fn(Review $record) => $record->update(['reviews_active' => false]));

                        Notification::make()
                            ->title(__('reviews.notify_bulk_deleted'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}