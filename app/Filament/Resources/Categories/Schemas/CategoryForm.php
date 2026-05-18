<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Naam')
                    ->placeholder('bijv. Elektronica')
                    ->prefixIcon('heroicon-o-tag')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($set, $state, string $operation) {
                        // Automatisch slug genereren bij aanmaken
                        if ($operation === 'create' && filled($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->placeholder('bijv. elektronica')
                    ->prefixIcon('heroicon-o-link')
                    ->required()
                    ->unique(Category::class, 'slug', ignoreRecord: true)
                    ->maxLength(255)
                    ->alphaDash()
                    ->helperText('Alleen kleine letters, cijfers en koppeltekens. Wordt automatisch ingevuld op basis van de naam.'),

                Select::make('parent_id')
                    ->label('Bovenliggende categorie')
                    ->placeholder('Geen (hoofdcategorie)')
                    ->prefixIcon('heroicon-o-folder-open')
                    ->options(fn($get, $record) => Category::query()
                        ->where('category_id', '!=', $record?->category_id ?? null)
                        ->pluck('name', 'category_id')
                        ->toArray())
                    ->searchable()
                    ->nullable()
                    ->native(false)
                    ->helperText('Laat leeg om een hoofdcategorie aan te maken.'),

                Checkbox::make('category_active')
                    ->label('Actief')
                    ->default(true)
                    ->helperText('Inactieve categorieën zijn niet zichtbaar voor klanten.'),
            ]);
    }
}