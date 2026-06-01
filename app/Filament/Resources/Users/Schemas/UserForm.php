<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Naam')
                    ->placeholder('Jan de Vries')
                    ->prefixIcon('heroicon-o-user')
                    ->required()
                    ->maxLength(255),

                TextInput::make('username')
                    ->label('Gebruikersnaam')
                    ->placeholder('jandevries')
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->required()
                    ->unique(User::class, 'username', ignoreRecord: true)
                    ->maxLength(50)
                    ->alphaDash()
                    ->helperText('Alleen letters, cijfers, koppeltekens en underscores.'),

                TextInput::make('email')
                    ->label('E-mailadres')
                    ->placeholder('jan@voorbeeld.nl')
                    ->prefixIcon('heroicon-o-envelope')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->maxLength(255),

                FileUpload::make('profile_photo_path')
                    ->label('Profielfoto')
                    ->avatar()
                    ->disk('public')
                    ->directory('profile-photos')
                    ->image()
                    ->maxSize(5 * 1024)
                    ->nullable(),

                Textarea::make('bio')
                    ->label('Bio')
                    ->placeholder('Vertel iets over deze gebruiker...')
                    ->rows(3)
                    ->nullable()
                    ->maxLength(1000)
                    ->helperText('Maximaal 1000 tekens.'),

                TextInput::make('password')
                    ->label('Wachtwoord')
                    ->placeholder('Minimaal 8 tekens')
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrated(fn(?string $state) => filled($state))
                    ->minLength(8)
                    ->helperText(fn(string $operation) => $operation === 'edit'
                        ? 'Laat leeg om het huidige wachtwoord te behouden.'
                        : null),

                TextInput::make('password_confirmation')
                    ->label('Wachtwoord bevestigen')
                    ->placeholder('Herhaal het wachtwoord')
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation) => $operation === 'create')
                    ->dehydrated(false)
                    ->same('password'),
Toggle::make('is_admin')
    ->label('Admin')
    ->default(false)
    ->helperText('Geeft beheerderrechten op het platform.'),

Toggle::make('is_active')
    ->label('Actief')
    ->default(true)
    ->disabled(fn($get) => $get('is_banned') === true)
    ->helperText(fn($get) => $get('is_banned')
        ? 'Verbannen gebruikers kunnen niet actief zijn.'
        : 'Inactieve gebruikers kunnen niet inloggen.'),

Toggle::make('is_banned')
    ->label('Verbannen')
    ->default(false)
    ->afterStateUpdated(function ($set, $state) {
        if ($state === true) {
            $set('is_active', false);
        }
    })
    ->helperText('Verbannen gebruikers kunnen niet meer inloggen en hun account zien.'),
            ]);
}
}