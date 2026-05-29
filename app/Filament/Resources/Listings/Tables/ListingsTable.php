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
                    ->label(__('listings.col_seller'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-user')
                    ->iconColor('gray')
                    ->description(fn(Listing $record): string => $record->seller?->email ?? '')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label(__('listings.col_category'))
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-tag')
                    ->iconColor('gray')
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_TITLE)
                    ->label(__('listings.col_title'))
                    ->limit(35)
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_PRICE)
                    ->label(__('listings.col_price'))
                    ->money('EUR')
                    ->sortable()
                    ->icon('heroicon-m-banknotes')
                    ->iconColor('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_STATUS)
                    ->label(__('listings.col_status'))
                    ->html()
                    ->getStateUsing(fn(Listing $record): string => match ($record->listing_status ?? $record->status) {
                        'active'   => self::badge(__('listings.badge_active'), 'green'),
                        'sold'     => self::badge(__('listings.badge_sold'), 'blue'),
                        'archived' => self::badge(__('listings.badge_archived'), 'gray'),
                        'inactive' => self::badge(__('listings.badge_inactive'), 'red'),
                        default    => self::badge(strtoupper($record->status ?? ''), 'gray'),
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_LOCATION)
                    ->label(__('listings.col_location'))
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray')
                    ->sortable()
                    ->searchable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make(Listing::LISTING_DESCRIPTION)
                    ->label(__('listings.col_description'))
                    ->limit(40)
                    ->searchable()
                    ->color('gray')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make(Listing::CREATED_AT)
                    ->label(__('listings.col_created_at'))
                    ->dateTime('d-m-Y H:i')
                    ->icon('heroicon-m-calendar')
                    ->iconColor('gray')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Listing::UPDATED_AT)
                    ->label(__('listings.col_updated_at'))
                    ->dateTime('d-m-Y H:i')
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('active')
                    ->label(__('listings.filter_active'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'active')),

                Filter::make('sold')
                    ->label(__('listings.filter_sold'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'sold')),

                Filter::make('archived')
                    ->label(__('listings.filter_archived'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('status', 'archived')),

                Filter::make('inactive')
                    ->label(__('listings.filter_inactive'))
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
                    ->modalHeading(__('listings.delete_heading'))
                    ->modalDescription(__('listings.delete_desc'))
                    ->modalSubmitActionLabel(__('listings.delete_confirm'))
                    ->action(function (Listing $record) {
                        $record->update([Listing::LISTING_STATUS => 'inactive']);

                        Notification::make()
                            ->title(__('listings.notify_deleted'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('bulk_delete')
                    ->label(__('listings.bulk_delete_label'))
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('listings.bulk_delete_heading'))
                    ->modalDescription(__('listings.bulk_delete_desc'))
                    ->modalSubmitActionLabel(__('listings.bulk_delete_confirm'))
                    ->action(function (Collection $records) {
                        $records->each(fn(Listing $record) => $record->update([
                            Listing::LISTING_STATUS => 'inactive',
                        ]));

                        Notification::make()
                            ->title(__('listings.notify_bulk_deleted'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}