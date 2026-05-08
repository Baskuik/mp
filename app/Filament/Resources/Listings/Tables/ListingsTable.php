<?php

namespace App\Filament\Resources\Listings\Tables;

use App\Models\Listing;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class ListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Listing::LISTING_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Listing::USER_ID)
                    ->label('VERKOPER')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Listing::CATEGORY_ID)
                    ->label('CATEGORIE')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_TITLE)
                    ->label('TITEL')
                    ->limit(30)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label('BESCHRIJVING')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_PRICE)
                    ->label('PRIJS')
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_STATUS)
                    ->label('STATUS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active'            => 'success',
                        'sold', 'archived'  => 'danger',
                        default             => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label('LOCATIE')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(Listing::CREATED_AT)
                    ->label('AANGEMAAKT')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::UPDATED_AT)
                    ->label('LAATSTE UPDATE')
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Advertentie archiveren')
                    ->modalDescription('Weet je zeker dat je deze advertentie wilt archiveren? Hij blijft bewaard in het systeem.')
                    ->modalSubmitActionLabel('Ja, archiveer')
                    ->action(function (Listing $record) {
                        $record->update([Listing::LISTING_STATUS => 'archived']);

                        Notification::make()
                            ->title('Advertentie gearchiveerd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Selectie archiveren')
                        ->modalHeading('Geselecteerde advertenties archiveren')
                        ->action(function (Collection $records) {
                            $records->each(fn (Listing $record) => $record->update([
                                Listing::LISTING_STATUS => 'archived',
                            ]));

                            Notification::make()
                                ->title('Advertenties gearchiveerd')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}