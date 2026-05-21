<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    private static function badge(string $label, string $color, string $textColor = 'white'): string
    {
        $colors = [
            'green'  => 'linear-gradient(135deg,#22c55e,#16a34a)',
            'red'    => 'linear-gradient(135deg,#ef4444,#dc2626)',
            'darkred'=> 'linear-gradient(135deg,#dc2626,#991b1b)',
            'amber'  => 'linear-gradient(135deg,#f59e0b,#d97706)',
            'blue'   => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
            'orange' => 'linear-gradient(135deg,#f97316,#ea580c)',
            'indigo' => 'linear-gradient(135deg,#6366f1,#4f46e5)',
            'gray'   => 'linear-gradient(135deg,#6b7280,#4b5563)',
        ];

        $shadows = [
            'green'  => 'rgba(34,197,94,0.4)',
            'red'    => 'rgba(239,68,68,0.4)',
            'darkred'=> 'rgba(220,38,38,0.5)',
            'amber'  => 'rgba(245,158,11,0.4)',
            'blue'   => 'rgba(14,165,233,0.4)',
            'orange' => 'rgba(249,115,22,0.4)',
            'indigo' => 'rgba(99,102,241,0.3)',
            'gray'   => 'rgba(107,114,128,0.3)',
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
                ImageColumn::make('profile_photo_path')
                    ->label('')
                    ->getStateUsing(fn($record) => $record->profile_photo_path
                        ? asset('storage/' . $record->profile_photo_path)
                        : null)
                    ->defaultImageUrl(asset('images/default-avatar.png'))
                    ->circular()
                    ->size(40),

                TextColumn::make('user_id')
                    ->label('ID')
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('name')
                    ->label('NAAM')
                    ->description(fn(User $record): string => $record->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('is_admin')
                    ->label('ROL')
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_admin
                        ? self::badge('★ ADMIN', 'amber')
                        : self::badge('👤 GEBRUIKER', 'indigo'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('is_active')
                    ->label('STATUS')
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_active
                        ? self::badge('● ACTIEF', 'green')
                        : self::badge('✗ GEDEACTIVEERD', 'red'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('is_banned')
                    ->label('BAN')
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_banned
                        ? self::badge('JA ', 'green')
                        : self::badge('NEE ', 'darkred'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label('EMAIL')
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->email_verified_at
                        ? self::badge('✓ GEVERIFIEERD', 'blue')
                        : self::badge('✗ NIET GEVERIFIEERD', 'orange'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('username')
                    ->label('USERNAME')
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('bio')
                    ->label('BIO')
                    ->color('gray')
                    ->limit(40)
                    ->toggleable()
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('AANGEMAAKT')
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('BIJGEWERKT')
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('email_verified')
                    ->label('Email geverifieerd')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),

                Filter::make('email_not_verified')
                    ->label('Email niet geverifieerd')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNull('email_verified_at')),

                Filter::make('is_admin')
                    ->label('Admins')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_admin', true)),

                Filter::make('is_active')
                    ->label('Actief')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_active', true)),

                Filter::make('is_not_active')
                    ->label('Verwijderd')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_active', false)),

                Filter::make('is_banned')
                    ->label('Verbannen')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_banned', true)),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading('Gebruiker verwijderen')
                    ->modalDescription('Weet je zeker dat je deze gebruiker wilt verwijderen? De gebruiker blijft bewaard in de database maar kan niet meer inloggen.')
                    ->modalSubmitActionLabel('Ja, verwijder')
                    ->action(function (User $record) {
                        $record->update(['is_active' => false]);
                        Notification::make()
                            ->title('Gebruiker verwijderd')
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
                    ->modalHeading('Geselecteerde gebruikers verwijderen')
                    ->modalDescription('Weet je zeker dat je de geselecteerde gebruikers wilt verwijderen? Ze blijven bewaard in de database maar kunnen niet meer inloggen.')
                    ->modalSubmitActionLabel('Ja, verwijder selectie')
                    ->action(function (Collection $records) {
                        $records->each(fn(User $record) => $record->update(['is_active' => false]));

                        Notification::make()
                            ->title('Gebruikers verwijderd')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),

                BulkAction::make('change_status')
                    ->label('Status wijzigen')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->form([
                        Select::make('status')
                            ->label('Kies nieuwe status')
                            ->options([
                                'active'     => 'Actief maken',
                                'deactivate' => 'Deactiveren',
                                'ban'        => 'Verbannen',
                            ])
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        $records->each(function (User $record) use ($data) {
                            match ($data['status']) {
                                'active'     => $record->update(['is_active' => true,  'is_banned' => false]),
                                'deactivate' => $record->update(['is_active' => false, 'is_banned' => false]),
                                'ban'        => $record->update(['is_banned' => true,  'is_active' => false]),
                            };
                        });

                        Notification::make()
                            ->title('Status bijgewerkt voor selectie')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}