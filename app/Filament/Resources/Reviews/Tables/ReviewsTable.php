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
                    ->label('REVIEWER ID')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Review::REVIEWEE_ID)
                    ->label('REVIEWEE ID')
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Review::LISTING_ID)
                    ->label('LISTING ID')
                    ->placeholder('Geen advertentie ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_RATING)
                    ->label('RATING')
                    ->icon('heroicon-m-star')
                    ->iconColor('warning')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label('COMMENTAAR')
                    ->searchable()
                    ->limit(50)
                    ->placeholder('—')
                    ->toggleable(),

                IconColumn::make('reviews_active')
                    ->label('ACTIEF')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(Review::CREATED_AT)
                    ->label('DATUM')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Review::UPDATED_AT)
                    ->label('LAATSTE UPDATE')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make(Review::REVIEW_RATING)
                    ->label('RATING')
                    ->native(false)
                    ->searchable()
                    ->options([
                        1 => '⭐ 1 ster',
                        2 => '⭐⭐ 2 sterren',
                        3 => '⭐⭐⭐ 3 sterren',
                        4 => '⭐⭐⭐⭐ 4 sterren',
                        5 => '⭐⭐⭐⭐⭐ 5 sterren',
                    ]),

                Filter::make('actief')
                    ->label('Alleen actieve reviews')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('reviews_active', true)),

                Filter::make('verwijderd')
                    ->label('Alleen verwijderde reviews')
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
                    ->modalHeading('Review verwijderen')
                    ->modalDescription('Weet je zeker dat je deze review wilt verwijderen? De review blijft bewaard in de database maar wordt niet meer getoond.')
                    ->modalSubmitActionLabel('Ja, verwijder review')
                    ->action(function (Review $record) {
                        $record->update(['reviews_active' => false]);

                        Notification::make()
                            ->title('Review verwijderd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('bulk_delete')
                    ->label('Selectie verwijderen')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Geselecteerde reviews verwijderen')
                    ->modalDescription('Weet je zeker dat je de geselecteerde reviews wilt verwijderen? Ze blijven bewaard in de database maar worden niet meer getoond.')
                    ->modalSubmitActionLabel('Ja, verwijder selectie')
                    ->action(function (Collection $records) {
                        $records->each(fn(Review $record) => $record->update(['reviews_active' => false]));

                        Notification::make()
                            ->title('Reviews verwijderd')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}