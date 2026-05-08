<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Review::REVIEWER_ID) // De persoon die de review schreef
                    ->label('REVIEWER ID')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make(Review::REVIEWEE_ID) // De persoon over wie de review gaat
                    ->label('REVIEWEE ID')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Review::LISTING_ID)
                    ->label('LISTING ID')
                    ->limit(50) // Zorgt dat de tabel compact blijft
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Review::REVIEW_RATING) // De listing waar de review betrekking op heeft
                    ->label('RATING')
                    ->icon('heroicon-m-star')
                    ->iconColor('warning')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make(Review::REVIEW_COMMENT)
                    ->label('COMMENTAAR')
                    ->searchable()
                    ->toggleable(),

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
                    ->options([
                        1 => '1 ster',
                        2 => '2 sterren',
                        3 => '3 sterren',
                        4 => '4 sterren',
                        5 => '5 sterren',
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
                    ->modalHeading('Review verbergen')
                    ->modalDescription('Weet je zeker dat je deze review wilt deactiveren? De tekst blijft in de database, maar wordt niet meer getoond.')
                    ->modalSubmitActionLabel('Ja, verberg review')
                    ->action(function (Review $record) {
                        // We gaan er even vanuit dat je een 'is_active' of 'status' kolom hebt
                        // Als je die niet hebt, kun je deze kolom toevoegen aan je reviews tabel
                        $record->update(['is_active' => false]);

                        Notification::make()
                            ->title('Review gedeactiveerd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Selectie verbergen')
                        ->modalHeading('Geselecteerde reviews verbergen')
                        ->action(function (Collection $records) {
                            $records->each(fn(Review $record) => $record->update(['is_active' => false]));

                            Notification::make()
                                ->title('Reviews succesvol verborgen')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}