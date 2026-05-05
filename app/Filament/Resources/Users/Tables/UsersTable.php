<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->defaultImageUrl(
                        fn(User $record) => 'https://ui-avatars.com/api/?name='
                        . urlencode($record->name)
                        . '&background=2d6a4f&color=fff&bold=true'
                    )
                    ->circular()
                    ->size(36),

                TextColumn::make(User::USER_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(User::USER_NAME)
                    ->label('NAAM')
                    ->description(fn(User $record): string => $record->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make(User::USER_EMAIL_VERIFIED_AT)
                    ->label('EMAIL GEVERIFIEERD')
                    ->badge()
                    ->getStateUsing(fn(User $record) => !is_null($record->email_verified_at))
                    ->formatStateUsing(fn($state) => $state ? '✓ Ja' : '✗ Nee')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ADMIN)
                    ->label('IS ADMIN')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? '★ Admin' : 'User')
                    ->color(fn($state) => $state ? 'warning' : 'gray')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_IS_ACTIVE)
                    ->label('IS ACTIEF')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Actief' : 'Gedeactiveerd')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(User::USER_USERNAME)
                    ->label('USERNAME')
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                
                TextColumn::make(User::USER_BIO)
                    ->label('ACCOUNT BIO')
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),

                TextColumn::make(User::USER_CREATED_AT)
                    ->label('AANGEMAAKT OP')
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),
                
                TextColumn::make(User::USER_UPDATED_AT)
                    ->label('LAATSTE UPDATE')
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
                    ->modalHeading('Gebruiker deactiveren')
                    ->modalDescription('Weet je zeker dat je deze gebruiker op inactief wilt zetten?')
                    ->modalSubmitActionLabel('Ja, deactiveer')
                    ->action(function (User $record) {
                        $record->update(['is_active' => false]);

                        Notification::make()
                            ->title('Gebruiker gedeactiveerd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // Aangepaste Bulk Delete actie (Soft)
                    DeleteBulkAction::make()
                        ->label('Selectie deactiveren')
                        ->modalHeading('Geselecteerde gebruikers deactiveren')
                        ->action(function (Collection $records) {
                            $records->each(fn (User $record) => $record->update(['is_active' => false]));

                            Notification::make()
                                ->title('Gebruikers gedeactiveerd')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}