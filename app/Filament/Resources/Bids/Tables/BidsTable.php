<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use Filament\Tables\Filters\SelectFilter;
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

                TextColumn::make(Bid::LISTING_ID)
                    ->label('ADVERTENTIE')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Bid::BUYER_ID)
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
                        'pending'  => 'warning',
                        'declined' => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'  => 'In afwachting',
                        'accepted' => 'Geaccepteerd',
                        'declined' => 'Afgewezen',
                        default    => ucfirst($state),
                    })
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

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Bieding afwijzen')
                    ->modalDescription('Weet je zeker dat je deze bieding wilt afwijzen? De status wordt aangepast naar "Afgewezen".')
                    ->modalSubmitActionLabel('Ja, wijs bieding af')
                    ->action(function (Bid $record) {
                        $record->update([Bid::STATUS => 'declined']);

                        Notification::make()
                            ->title('Bieding afgewezen')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Selectie afwijzen')
                        ->modalHeading('Geselecteerde biedingen afwijzen')
                        ->action(function (Collection $records) {
                            $records->each(fn (Bid $record) => $record->update([
                                Bid::STATUS => 'declined',
                            ]));

                            Notification::make()
                                ->title('Biedingen afgewezen')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}