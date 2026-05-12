<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class BidsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Bid::BID_ID)
                    ->label(__('ID'))
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Bid::LISTING_ID)
                    ->label(__('ADVERTENTIE'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Bid::BUYER_ID)
                    ->label(__('BIEDER'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::AMOUNT)
                    ->label(__('BEDRAG'))
                    ->money('EUR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->toggleable(),

                TextColumn::make(Bid::STATUS)
                    ->label(__('STATUS'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'accepted' => 'success',
                        'pending' => 'warning',
                        'declined' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'In afwachting',
                        'accepted' => 'Geaccepteerd',
                        'declined' => 'Afgewezen',
                        default => ucfirst($state),
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::CREATED_AT)
                    ->label(__('DATUM'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::UPDATED_AT)
                    ->label(__('LAATSTE UPDATE'))
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

                Action::make('decline')
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('Bieding afwijzen'))
                    ->modalDescription(__('Weet je zeker dat je deze bieding wilt afwijzen? De status wordt aangepast naar "Afgewezen".'))
                    ->modalSubmitActionLabel(__('Ja, wijs bieding af'))
                    ->action(function (Bid $record) {
                        $record->update([Bid::STATUS => 'declined']);

                        Notification::make()
                            ->title(__('Bieding afgewezen'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('decline')
                        ->label(__('Selectie afwijzen'))
                        ->icon('heroicon-m-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading(__('Geselecteerde biedingen afwijzen'))
                        ->action(function (Collection $records) {
                            $records->each(fn(Bid $record) => $record->update([
                                Bid::STATUS => 'declined',
                            ]));

                            Notification::make()
                                ->title(__('Biedingen afgewezen'))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}