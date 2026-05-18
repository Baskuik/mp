<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction; // De specifieke BulkAction klasse
use Filament\Forms\Components\Select;   // Voor de select dropdown
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('')
                    ->getStateUsing(fn($record) => $record->profile_photo_path ? asset('storage/' . $record->profile_photo_path) : null)
                    ->defaultImageUrl(
                        asset('images/default-avatar.png')
                    )
                    ->circular()
                    ->size(36),

                TextColumn::make(User::USER_ID)
                    ->label(__('ID'))
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(User::USER_NAME)
                    ->label(__('NAAM'))
                    ->description(fn(User $record): string => $record->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make(User::USER_EMAIL_VERIFIED_AT)
                    ->label(__('EMAIL GEVERIFIEERD'))
                    ->badge()
                    ->getStateUsing(fn(User $record) => !is_null($record->email_verified_at))
                    ->formatStateUsing(fn($state) => $state ? '✓ Ja' : '✗ Nee')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ADMIN)
                    ->label(__('IS ADMIN'))
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? '★ Admin' : 'User')
                    ->color(fn($state) => $state ? 'warning' : 'gray')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ACTIVE)
                    ->label(__('IS ACTIEF'))
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Actief' : 'Gedeactiveerd')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_BANNED)
                    ->label(__('VERBANNEN'))
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? '⛔ Verbannen' : 'Niet verbannen')
                    ->color(fn($state) => $state ? 'danger' : 'gray')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_USERNAME)
                    ->label(__('USERNAME'))
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make(User::USER_BIO)
                    ->label(__('ACCOUNT BIO'))
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make(User::USER_CREATED_AT)
                    ->label(__('AANGEMAAKT OP'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_UPDATED_AT)
                    ->label(__('LAATSTE UPDATE'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                // Aangepaste Delete actie (Soft)
                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading(__('Gebruiker deactiveren'))
                    ->modalDescription(__('Weet je zeker dat je deze gebruiker op inactief wilt zetten?'))
                    ->modalSubmitActionLabel(__('Ja, deactiveer'))
                    ->action(function (User $record) {
                        $record->update(['is_active' => false]);

                        Notification::make()
                            ->title(__('Gebruiker gedeactiveerd'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('change_status')
                    ->label(__('Status wijzigen'))
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->form([
                        Select::make('status')
                            ->label(__('Kies nieuwe status'))
                            ->options([
                                'active' => 'Actief maken',
                                'deactivate' => 'Deactiveren (Soft delete)',
                                'ban' => 'Verbannen',
                            ])
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        $records->each(function (User $record) use ($data) {
                            if ($data['status'] === 'active') {
                                $record->update(['is_active' => true, 'is_banned' => false]);
                            } elseif ($data['status'] === 'deactivate') {
                                $record->update(['is_active' => false]);
                            } elseif ($data['status'] === 'ban') {
                                $record->update(['is_banned' => true]);
                            }
                        });

                        Notification::make()
                            ->title(__('Status succesvol bijgewerkt voor selectie'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}