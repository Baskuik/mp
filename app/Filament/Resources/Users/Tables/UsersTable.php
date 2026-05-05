<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

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

                TextColumn::make('id')
                    ->label('ID')
                    ->prefix('#')
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('name')
                    ->label('NAAM')
                    ->description(fn(User $record): string => $record->email)
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('email')
                    ->label('EMAIL')
                    ->searchable(),

                TextColumn::make('email_verified_at')
                    ->label('EMAIL GEVERIFIEERD')
                    ->badge()
                    ->getStateUsing(fn(User $record) => !is_null($record->email_verified_at))
                    ->formatStateUsing(fn($state) => $state ? '✓ Ja' : '✗ Nee')
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('is_admin')
                    ->label('IS ADMIN')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? '★ Admin' : 'Nee')
                    ->color(fn($state) => $state ? 'warning' : 'gray'),

                TextColumn::make('is_active')
                    ->label('IS ACTIEF')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Actief' : 'Gedeactiveerd')
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('username')
                    ->label('USERNAME')
                    ->color('gray'),
            ])
            ->actions([
                EditAction::make()->label(false)->icon('heroicon-m-pencil-square')->color('gray'),
                DeleteAction::make()->label(false)->icon('heroicon-m-trash')->color('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}