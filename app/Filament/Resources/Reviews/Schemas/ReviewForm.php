<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Models\User;
use App\Models\Listing;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('reviewer_id')
                    ->label('Reviewer')
                    ->placeholder('Zoek een gebruiker…')
                    ->prefixIcon('heroicon-o-user')
                    ->options(fn() => User::all()->pluck('name', 'user_id'))
                    ->searchable()
                    ->required()
                    ->helperText('De gebruiker die de review heeft geschreven.'),

Select::make('reviewee_id')
    ->label('Reviewee')
    ->placeholder('Zoek een gebruiker…')
    ->prefixIcon('heroicon-o-user-circle')
    ->options(fn() => User::all()->pluck('name', 'user_id'))
    ->searchable()
    ->required()
    ->live() // ← triggert herlaad van advertenties
    ->helperText('De gebruiker over wie de review gaat.'),

Select::make('listing_id')
    ->label('Advertentie')
    ->placeholder('Kies eerst een reviewee…')
    ->prefixIcon('heroicon-o-shopping-bag')
    ->options(function (callable $get) {
        $revieweeId = $get('reviewee_id');

        if (!$revieweeId) {
            return [];
        }

        return Listing::where('user_id', $revieweeId)
            ->pluck('title', 'listing_id');
    })
    ->searchable()
    ->required()
    ->helperText('Alleen advertenties van de geselecteerde reviewee worden getoond.'),



                Select::make('rating')
                    ->label('Beoordeling')
                    ->placeholder('Kies een beoordeling…')
                    ->prefixIcon('heroicon-o-star')
                    ->options([
                        1 => '⭐ 1 — Zeer slecht',
                        2 => '⭐⭐ 2 — Slecht',
                        3 => '⭐⭐⭐ 3 — Gemiddeld',
                        4 => '⭐⭐⭐⭐ 4 — Goed',
                        5 => '⭐⭐⭐⭐⭐ 5 — Uitstekend',
                    ])
                    ->searchable()
                    ->required()
                    ->helperText('Geef een beoordeling van 1 tot 5 sterren.'),

                Textarea::make('comment')
                    ->label('Opmerking')
                    ->placeholder('Schrijf hier een toelichting op de beoordeling…')
                    ->rows(4)
                    ->nullable()
                    ->maxLength(2000)
                    ->columnSpanFull()
                    ->helperText('Maximaal 2000 tekens. Optioneel.'),
            ]);
    }
}