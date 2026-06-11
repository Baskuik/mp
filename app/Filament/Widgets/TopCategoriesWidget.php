<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCategoriesWidget extends BaseWidget
{
    protected static ?string $heading = 'Top categorieën';
    protected static ?int $sort = 8;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Category::query()
                    ->withCount(['listings' => function ($q) {
                        $q->whereNull('deleted_at')->where('status', 'active');
                    }])
                    ->orderByDesc('listings_count')
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Categorie')
                    ->searchable(),

                Tables\Columns\TextColumn::make('listings_count')
                    ->label('Actieve advertenties')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}