<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema; // Moet matchen met UserResource
use Filament\Forms\Components\TextInput;

class UserForm 
{
    public static function configure(Schema $schema): Schema 
    {
        return $schema
            ->components([ // Let op: in deze versie is het vaak 'components' ipv 'schema'
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required(),
            ]);
    }
}