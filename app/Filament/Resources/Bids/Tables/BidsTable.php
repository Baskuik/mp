<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class BidsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Bid::BID_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Bid::LISTING_ID) // Toont de titel van de advertentie
                    ->label('ADVERTENTIE')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Bid::BUYER_ID) // Toont de naam van de bieder
                    ->label('BIEDER')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::AMOUNT)
                    ->label('BEDRAG')
                    ->money('EUR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->toggleable(),

                TextColumn::make(Bid::STATUS)
                    ->label('STATUS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'success',
                        'pending' => 'warning',
                        'rejected', 'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::CREATED_AT)
                    ->label('DATUM')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::UPDATED_AT)
                    ->label('LAATSTE UPDATE')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                // "Soft Delete" voor Biedingen
                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Bieding annuleren')
                    ->modalDescription('Weet je zeker dat je deze bieding wilt annuleren? De status wordt aangepast naar "cancelled".')
                    ->modalSubmitActionLabel('Ja, annuleer bieding')
                    ->action(function (Bid $record) {
                        // Pas 'cancelled' aan naar de waarde die jij gebruikt in je database
                        $record->update([Bid::STATUS => 'cancelled']);

                        Notification::make()
                            ->title('Bieding geannuleerd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Selectie annuleren')
                        ->modalHeading('Geselecteerde biedingen annuleren')
                        ->action(function (Collection $records) {
                            $records->each(fn (Bid $record) => $record->update([
                                Bid::STATUS => 'cancelled'
                            ]));

                            Notification::make()
                                ->title('Biedingen geannuleerd')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}