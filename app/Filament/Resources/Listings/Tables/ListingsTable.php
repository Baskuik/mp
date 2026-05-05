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
                    ->money('EUR') // Formatteert automatisch als €
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_STATUS)
                    ->label('STATUS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'sold', 'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label('LOCATIE')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray')
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
                // Hier kun je later filters toevoegen voor status of categorie
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                // De "Soft Delete" actie voor Listings
                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Advertentie deactiveren')
                    ->modalDescription('Weet je zeker dat je deze advertentie op offline wilt zetten? Hij blijft bewaard in het systeem.')
                    ->modalSubmitActionLabel('Ja, zet offline')
                    ->action(function (Listing $record) {
                        // We zetten de status op 'inactive' in plaats van te deleten
                        $record->update([Listing::LISTING_STATUS => 'inactive']);

                        Notification::make()
                            ->title('Advertentie offline gezet')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Selectie deactiveren')
                        ->modalHeading('Geselecteerde advertenties offline zetten')
                        ->action(function (Collection $records) {
                            $records->each(fn (Listing $record) => $record->update([
                                Listing::LISTING_STATUS => 'inactive'
                            ]));

                            Notification::make()
                                ->title('Advertenties gedeactiveerd')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}