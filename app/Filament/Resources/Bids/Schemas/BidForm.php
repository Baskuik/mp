<?php

namespace App\Filament\Resources\Bids\Schemas;

use App\Models\Listing;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BidForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('listing_id')
                    ->label('Aanbieding')
                    ->placeholder('Zoek een advertentie…')
                    ->prefixIcon('heroicon-o-shopping-bag')
                    ->options(fn() => Listing::all()->pluck('title', 'listing_id'))
                    ->searchable()
                    ->required()
                    ->helperText('De advertentie waarop deze bieding is gedaan.'),

                Select::make('buyer_id')
                    ->label('Koper')
                    ->placeholder('Zoek een gebruiker…')
                    ->prefixIcon('heroicon-o-user')
                    ->options(fn() => User::all()->pluck('name', 'user_id'))
                    ->searchable()
                    ->required()
                    ->helperText('De gebruiker die deze bieding heeft geplaatst.'),

                TextInput::make('amount')
                    ->label('Bedrag (€)')
                    ->placeholder('bijv. 150.00')
                    ->prefixIcon('heroicon-o-currency-euro')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Voer het biedingsbedrag in euro\'s in.'),

                Select::make('status')
                    ->label('Status')
                    ->placeholder('Kies een status…')
                    ->prefixIcon('heroicon-o-signal')
                    ->options([
                        'pending'   => 'In behandeling',
                        'accepted'  => 'Geaccepteerd',
                        'rejected'  => 'Afgewezen',
                        'cancelled' => 'Geannuleerd',
                    ])
                    ->required()
                    ->default('pending')
                    ->searchable()
                    ->helperText('Alleen geaccepteerde biedingen leiden tot een verkoop.'),
            ]);
    }
}