<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;   // Voor de select dropdown
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

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
                    ->state(fn(User $record) => !is_null($record->email_verified_at) ? 'verified' : 'not_verified')
                    ->formatStateUsing(fn($state) => $state === 'verified' ? '✓ Ja' : '✗ Nee')
                    ->color(fn($state) => $state === 'verified' ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ADMIN)
                    ->label(__('IS ADMIN'))
                    ->badge()
                    ->state(fn(User $record) => $record->is_admin ? 'admin' : 'user')
                    ->formatStateUsing(fn($state) => $state === 'admin' ? '★ Admin' : 'User')
                    ->color(fn($state) => $state === 'admin' ? 'warning' : 'gray')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ACTIVE)
                    ->label(__('IS ACTIEF'))
                    ->badge()
                    ->state(fn(User $record) => $record->is_active ? 'active' : 'inactive')
                    ->formatStateUsing(fn($state) => $state === 'active' ? 'Actief' : 'Gedeactiveerd')
                    ->color(fn($state) => $state === 'active' ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_BANNED)
                    ->label(__('VERBANNEN'))
                    ->badge()
                    ->state(fn(User $record) => $record->is_banned ? 'banned' : 'not_banned')
                    ->formatStateUsing(fn($state) => $state === 'banned' ? '⛔ Verbannen' : 'Niet verbannen')
                    ->color(fn($state) => $state === 'banned' ? 'danger' : 'gray')
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
            ->filters([
                Filter::make(User::USER_EMAIL_VERIFIED_AT)
                    ->label(__('EMAIL GEVERIFIEERD'))
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),

                Filter::make('email_not_verified')
                    ->label(__('EMAIL NIET GEVERIFIEERD'))
                    ->query(fn(Builder $query) => $query->whereNull('email_verified_at')),

                Filter::make(User::USER_IS_ADMIN)
                    ->label(__('IS ADMIN'))
                    ->query(fn(Builder $query) => $query->where('is_admin', true)),

                Filter::make(User::USER_IS_ACTIVE)
                    ->label(__('IS ACTIEF'))
                    ->query(fn(Builder $query) => $query->where('is_active', true)),

                Filter::make('is_not_active')
                    ->label(__('GEDEACTIVEERD'))
                    ->query(fn(Builder $query) => $query->where('is_active', false)),

                Filter::make(User::USER_IS_BANNED)
                    ->label(__('VERBANNEN'))
                    ->query(fn(Builder $query) => $query->where('is_banned', true)),
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