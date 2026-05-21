<?php

namespace App\Filament\Resources\Listings\Tables;

use App\Models\Listing;
use App\Models\Category;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ListingsTable
{
    private static function badge(string $label, string $color, string $textColor = 'white'): string
    {
        $colors = [
            'green'   => 'linear-gradient(135deg,#22c55e,#16a34a)',
            'red'     => 'linear-gradient(135deg,#ef4444,#dc2626)',
            'darkred' => 'linear-gradient(135deg,#dc2626,#991b1b)',
            'amber'   => 'linear-gradient(135deg,#f59e0b,#d97706)',
            'blue'    => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
            'orange'  => 'linear-gradient(135deg,#f97316,#ea580c)',
            'indigo'  => 'linear-gradient(135deg,#6366f1,#4f46e5)',
            'gray'    => 'linear-gradient(135deg,#6b7280,#4b5563)',
            'teal'    => 'linear-gradient(135deg,#14b8a6,#0d9488)',
        ];

        $shadows = [
            'green'   => 'rgba(34,197,94,0.4)',
            'red'     => 'rgba(239,68,68,0.4)',
            'darkred' => 'rgba(220,38,38,0.5)',
            'amber'   => 'rgba(245,158,11,0.4)',
            'blue'    => 'rgba(14,165,233,0.4)',
            'orange'  => 'rgba(249,115,22,0.4)',
            'indigo'  => 'rgba(99,102,241,0.3)',
            'gray'    => 'rgba(107,114,128,0.3)',
            'teal'    => 'rgba(20,184,166,0.3)',
        ];

        $bg     = $colors[$color]  ?? $colors['gray'];
        $shadow = $shadows[$color] ?? $shadows['gray'];

        return sprintf(
            '<span style="background:%s;color:%s;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:0.5px;box-shadow:0 2px 4px %s;white-space:nowrap;">%s</span>',
            $bg, $textColor, $shadow, $label
        );
    }

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

                TextColumn::make('seller.name')
                    ->label('VERKOPER')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-user')
                    ->iconColor('gray')
                    ->description(fn(Listing $record): string => $record->seller?->email ?? '')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('CATEGORIE')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-tag')
                    ->iconColor('gray')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_TITLE)
                    ->label('TITEL')
                    ->limit(35)
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_PRICE)
                    ->label('PRIJS')
                    ->money('EUR')
                    ->sortable()
                    ->icon('heroicon-m-banknotes')
                    ->iconColor('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_STATUS)
                    ->label('STATUS')
                    ->html()
                    ->getStateUsing(fn(Listing $record): string => match ($record->listing_status ?? $record->status) {
                        'active'   => self::badge('● ACTIEF', 'green'),
                        'sold'     => self::badge('★ VERKOCHT', 'blue'),
                        'archived' => self::badge('○ GEARCHIVEERD', 'gray'),
                        'inactive' => self::badge('✗ VERWIJDERD', 'red'),
                        default    => self::badge(strtoupper($record->status ?? ''), 'gray'),
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label('LOCATIE')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray')
                    ->sortable()
                    ->searchable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label('BESCHRIJVING')
                    ->limit(40)
                    ->searchable()
                    ->color('gray')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make(Listing::CREATED_AT)
                    ->label('AANGEMAAKT')
                    ->dateTime('d-m-Y H:i')
                    ->icon('heroicon-m-calendar')
                    ->iconColor('gray')
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
                Filter::make('active')
                    ->label('Actief')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'active')),

                Filter::make('sold')
                    ->label('Verkocht')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'sold')),

                Filter::make('archived')
                    ->label('Gearchiveerd')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'archived')),

                Filter::make('inactive')
                    ->label('Verwijderd')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'inactive')),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Advertentie verwijderen')
                    ->modalDescription('Weet je zeker dat je deze advertentie wilt verwijderen? De advertentie blijft bewaard in de database maar wordt op inactief gezet.')
                    ->modalSubmitActionLabel('Ja, verwijder')
                    ->action(function (Listing $record) {
                        $record->update([Listing::LISTING_STATUS => 'inactive']);

                        Notification::make()
                            ->title('Advertentie verwijderd')
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
                    ->modalHeading('Geselecteerde advertenties verwijderen')
                    ->modalDescription('Weet je zeker dat je de geselecteerde advertenties wilt verwijderen? Ze blijven bewaard in de database maar worden op inactief gezet.')
                    ->modalSubmitActionLabel('Ja, verwijder selectie')
                    ->action(function (Collection $records) {
                        $records->each(fn(Listing $record) => $record->update([
                            Listing::LISTING_STATUS => 'inactive',
                        ]));

                        Notification::make()
                            ->title('Advertenties verwijderd')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),


            ]);
    }
}