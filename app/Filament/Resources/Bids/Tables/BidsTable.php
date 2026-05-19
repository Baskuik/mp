<?php

namespace App\Filament\Resources\Bids\Tables;

use App\Models\Bid;
use App\Models\Listing;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BidsTable
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
            'purple'  => 'linear-gradient(135deg,#a855f7,#9333ea)',
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
            'purple'  => 'rgba(168,85,247,0.3)',
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
                TextColumn::make(Bid::BID_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray')
                    ->toggleable(),

                TextColumn::make('listing.title')
                    ->label('ADVERTENTIE')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-tag')
                    ->iconColor('gray')
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('buyer.name')
                    ->label('BIEDER')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('gray')
                    ->description(fn(Bid $record): string => $record->buyer?->email ?? '')
                    ->toggleable(),

                TextColumn::make(Bid::AMOUNT)
                    ->label('BEDRAG')
                    ->money('EUR')
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-banknotes')
                    ->iconColor('gray')
                    ->toggleable(),

                TextColumn::make(Bid::STATUS)
                    ->label('STATUS')
                    ->html()
                    ->getStateUsing(fn(Bid $record): string => match ($record->status) {
                        'pending'   => self::badge('⏳ IN BEHANDELING', 'amber'),
                        'accepted'  => self::badge('✓ GEACCEPTEERD', 'green'),
                        'declined',
                        'rejected'  => self::badge('✗ AFGEWEZEN', 'red'),
                        'cancelled' => self::badge('○ GEANNULEERD', 'gray'),
                        default     => self::badge(strtoupper($record->status), 'gray'),
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(Bid::CREATED_AT)
                    ->label('DATUM')
                    ->dateTime('d-m-Y H:i')
                    ->icon('heroicon-m-calendar')
                    ->iconColor('gray')
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

                Action::make('decline')
                    ->label(false)
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Bieding afwijzen')
                    ->modalDescription('Weet je zeker dat je deze bieding wilt afwijzen? De status wordt aangepast naar "Afgewezen".')
                    ->modalSubmitActionLabel('Ja, wijs bieding af')
                    ->action(function (Bid $record) {
                        $record->update([Bid::STATUS => 'rejected']);

                        Notification::make()
                            ->title('Bieding afgewezen')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Action::make('decline')
                    ->label('Selectie afwijzen')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Geselecteerde biedingen afwijzen')
                    ->action(function (Collection $records) {
                        $records->each(fn(Bid $record) => $record->update([
                            Bid::STATUS => 'rejected',
                        ]));

                        Notification::make()
                            ->title('Biedingen afgewezen')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}