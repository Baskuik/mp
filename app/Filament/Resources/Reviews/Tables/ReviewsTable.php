<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Review::REVIEW_ID)
                    ->label(__('ID'))
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Review::REVIEWER_ID) // De persoon die de review schreef
                    ->label(__('REVIEWER ID'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make(Review::REVIEWEE_ID) // De persoon over wie de review gaat
                    ->label(__('REVIEWEE ID'))
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Review::LISTING_ID)
                    ->label(__('LISTING ID'))
                    ->placeholder('Geen advertentie ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_RATING) // De listing waar de review betrekking op heeft
                    ->label(__('RATING'))
                    ->icon('heroicon-m-star')
                    ->iconColor('warning')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label(__('COMMENTAAR'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Review::CREATED_AT)
                    ->label(__('DATUM'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Review::UPDATED_AT)
                    ->label(__('LAATSTE UPDATE'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make(Review::REVIEW_RATING)
                    ->label(__('RATING'))
                    ->native(false)      // ✅ Gebruik de Filament-stijl dropdown
                    ->searchable()       // ✅ Voegt de zoekbalk toe bovenaan
                    ->options([
                        1 => '⭐ 1 ster',
                        2 => '⭐⭐ 2 sterren',
                        3 => '⭐⭐⭐ 3 sterren',
                        4 => '⭐⭐⭐⭐ 4 sterren',
                        5 => '⭐⭐⭐⭐⭐ 5 sterren',
                    ]),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                // Deactiveer actie voor een enkele review
                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading(__('Review verbergen'))
                    ->modalDescription(__('Weet je zeker dat je deze review wilt deactiveren? De tekst blijft in de database, maar wordt niet meer getoond.'))
                    ->modalSubmitActionLabel(__('Ja, verberg review'))
                    ->action(function (Review $record) {
                        // We gaan er even vanuit dat je een 'is_active' of 'status' kolom hebt
                        // Als je die niet hebt, kun je deze kolom toevoegen aan je reviews tabel
                        $record->update(['is_active' => false]);

                        Notification::make()
                            ->title(__('Review gedeactiveerd'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Action::make('delete')
                    ->label(__('Selectie verbergen'))
                    ->modalHeading(__('Geselecteerde reviews verbergen'))
                    ->action(function (Collection $records) {
                        $records->each(fn(Review $record) => $record->update(['is_active' => false]));

                        Notification::make()
                            ->title(__('Reviews succesvol verborgen'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}