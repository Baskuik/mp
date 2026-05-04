<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(User::USER_ID)
                    ->label(__('ID'))
                    ->placeholder('Geen ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(User::USER_NAME)
                    ->label(__('Name'))
                    ->placeholder('Geen naam beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(User::USER_EMAIL)
                    ->label(__('Email'))
                    ->placeholder('Geen email beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                IconColumn::make(User::USER_EMAIL_VERIFIED_AT)
                    ->label(__('Email Verified'))
                    ->boolean()
                    ->toggleable(),
                IconColumn::make(User::USER_IS_ADMIN)
                    ->label(__('Is Admin'))
                    ->boolean()
                    ->toggleable(),
                IconColumn::make(User::USER_IS_ACTIVE)
                    ->label(__('Is Active'))
                    ->boolean()
                    ->toggleable(),
                TextColumn::make(User::USER_USERNAME)
                    ->label(__('Username'))
                    ->placeholder('Geen username beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(User::USER_BIO)
                    ->label(__('Bio'))
                    ->placeholder('Geen bio beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                ImageColumn::make(User::USER_PROFILE_PHOTO_PATH)
                    ->label(__('Profile Photo'))
                    ->circular()
                    ->toggleable()
                    ->disk('public'),
                TextColumn::make(User::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(User::UPDATED_AT)
                    ->label(__('Updated At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->label('Deactivate')
                    ->modalHeading('Gebruiker deactiveren')
                    ->modalDescription('Weet je zeker dat je deze gebruiker wilt deactiveren?')
                    ->successNotificationTitle('Gebruiker gedeactiveerd')
                    ->action(function (User $record) {
                        $record->update(['is_active' => 0]);
                        $record->delete();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('deactivate')
                        ->label('Deactivate selected')
                        ->icon('heroicon-o-user-minus')
                        ->requiresConfirmation()
                        ->modalHeading('Gebruikers deactiveren')
                        ->modalDescription('Weet je zeker dat je de geselecteerde gebruikers wilt deactiveren?')
                        ->successNotificationTitle('Gebruikers gedeactiveerd')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => 0]);
                                $record->delete();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}