<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(User::USER_NAME)
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(User::USER_EMAIL)
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                IconColumn::make(User::USER_EMAIL_VERIFIED_AT)
                    ->label(__('Verified'))
                    ->boolean()
                    ->toggleable(),

                IconColumn::make(User::USER_IS_ADMIN)
                    ->label(__('Admin'))
                    ->boolean()
                    ->toggleable(),

                IconColumn::make(User::USER_IS_ACTIVE)
                    ->label(__('Active'))
                    ->boolean()
                    ->toggleable(),

                TextColumn::make(User::USER_USERNAME)
                    ->label(__('Username'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make(User::USER_BIO)
                    ->label(__('Bio'))
                    ->limit(50)
                    ->toggleable(),

                ImageColumn::make(User::USER_PROFILE_PHOTO_PATH)
                    ->label(__('Profile Photo'))
                    ->circular()
                    ->disk('public')
                    ->toggleable(),

                TextColumn::make(User::CREATED_AT)
                    ->label(__('Created At'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make(User::UPDATED_AT)
                    ->label(__('Updated At'))
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),

                // BELANGRIJK: we vervangen delete door deactivate logica
                DeleteAction::make()
                    ->label('Deactivate')
                    ->action(function (User $record) {
                        $record->update([
                            'is_active' => 0,
                        ]);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    // simpele bulk deactivate zonder extra classes
                    BulkAction::make('deactivate')
                        ->label('Deactivate selected')
                        ->icon('heroicon-o-user-minus')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_active' => 0,
                                ]);
                            }
                        }),
                ]),
            ]);
    }
}