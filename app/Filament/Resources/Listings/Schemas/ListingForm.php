<?php

namespace App\Filament\Resources\Listings\Schemas;

use App\Models\Category;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Verkoper')
                    ->placeholder('Zoek een gebruiker…')
                    ->prefixIcon('heroicon-o-user')
                    ->options(fn() => ['' => 'Geen selectie'] + User::query()->orderBy('name')->pluck('name', 'user_id')->toArray())
                    ->searchable()
                    ->native(false)
                    ->selectablePlaceholder()
                    ->optionsLimit(50)
                    ->required()
                    ->helperText('De gebruiker die deze advertentie heeft geplaatst.'),

                Select::make('category_id')
                    ->label('Categorie')
                    ->placeholder('Selecteer een categorie…')
                    ->prefixIcon('heroicon-o-tag')
                    ->options(fn() => ['' => 'Geen selectie'] + Category::where('category_active', true)->orderBy('name')->pluck('name', 'category_id')->toArray())
                    ->searchable()
                    ->native(false)
                    ->selectablePlaceholder()
                    ->required()
                    ->helperText('Alleen actieve categorieën worden getoond.'),

                TextInput::make('title')
                    ->label('Titel')
                    ->placeholder('bijv. iPhone 14 Pro – 256 GB Spacezwart')
                    ->prefixIcon('heroicon-o-document-text')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Maximaal 255 tekens.'),

                Textarea::make('description')
                    ->label('Beschrijving')
                    ->placeholder('Geef een duidelijke omschrijving van het product of de dienst…')
                    ->rows(4)
                    ->nullable()
                    ->maxLength(5000)
                    ->columnSpanFull()
                    ->helperText('Maximaal 5000 tekens.'),

                TextInput::make('price')
                    ->label('Prijs (€)')
                    ->placeholder('bijv. 249.99')
                    ->prefixIcon('heroicon-o-currency-euro')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Voer de prijs in euro\'s in (zonder valutasymbool).'),

                Select::make('status')
                    ->label('Status')
                    ->placeholder('Kies een status…')
                    ->prefixIcon('heroicon-o-signal')
                    ->options([
                        '' => 'Geen selectie',
                        'active' => 'Actief',
                        'sold' => 'Verkocht',
                        'archived' => 'Gearchiveerd',
                        'inactive' => 'Inactief',
                    ])
                    ->required()
                    ->default('active')
                    ->native(false)
                    ->selectablePlaceholder()
                    ->helperText('Alleen actieve advertenties zijn zichtbaar voor klanten.'),

                TextInput::make('location')
                    ->label('Locatie')
                    ->placeholder('bijv. Amsterdam')
                    ->prefixIcon('heroicon-o-map-pin')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Stad of regio waar het product zich bevindt.'),

                FileUpload::make('images')
                    ->label('Afbeeldingen')
                    ->multiple()
                    ->disk('public')
                    ->directory('listings')
                    ->maxSize(5120)
                    ->maxFiles(10)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->columnSpanFull()
                    ->helperText('Upload tot 10 afbeeldingen (max 5MB per afbeelding). Ondersteunde formaten: JPG, PNG, WebP'),
            ]);
    }
}