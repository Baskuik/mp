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
                    ->options(fn() => User::all()->pluck('name', 'user_id'))
                    ->searchable()
                    ->required(),

                Select::make('reviewee_id')
                    ->label('Reviewee')
                    ->options(fn() => User::all()->pluck('name', 'user_id'))
                    ->searchable()
                    ->required(),

                Select::make('listing_id')
                    ->label('Listing')
                    ->options(fn() => Listing::all()->pluck('title', 'listing_id'))
                    ->searchable()
                    ->required(),

                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '⭐ 1',
                        2 => '⭐⭐ 2',
                        3 => '⭐⭐⭐ 3',
                        4 => '⭐⭐⭐⭐ 4',
                        5 => '⭐⭐⭐⭐⭐ 5',
                    ])
                    ->required(),

                Textarea::make('comment')
                    ->label('Opmerking')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}