<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use App\Models\User;
use App\Models\Bid;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivityWidget extends BaseWidget
{
    protected static ?string $heading = 'Recente activiteit';
    protected static ?int $sort = 10;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Listing::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Advertentie')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Gebruiker')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categorie')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prijs')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actief')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Geplaatst')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
