<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Category::CATEGORY_ID)
                    ->label(__('ID'))
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Category::CATEGORY_NAME)
                    ->label(__('CATEGORIE NAAM'))
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make(Category::CATEGORY_SLUG)
                    ->label(__('TITEL'))
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('parent.name')
                    ->label(__('BOVENLIGGENDE CATEGORIE'))
                    ->placeholder('Geen (hoofdcategorie)')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Category::CATEGORY_ACTIVE)
                    ->label(__('IS ACTIEF'))
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Ja' : 'Nee')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(Category::CREATED_AT)
                    ->label(__('AANGEMAAKT OP'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Category::UPDATED_AT)
                    ->label(__('LAATSTE UPDATE'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('category_name')
                    ->label(__('Categorie'))
                    ->multiple()
                    ->native(false)      // ✅ Gebruik de Filament-stijl dropdown
                    ->searchable()       // ✅ Voegt de zoekbalk toe
                    ->options(
                        Category::query()
                            ->pluck(Category::CATEGORY_NAME, Category::CATEGORY_NAME)
                            ->toArray()
                    )
                    ->query(function ($query, array $data) {
                        if (!empty($data['values'])) {
                            $query->whereIn(Category::CATEGORY_NAME, $data['values']);
                        }
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading(__('Categorie deactiveren'))
                    ->modalDescription(__('Deze categorie wordt onzichtbaar voor klanten.'))
                    ->action(function (Category $record) {
                        $record->update([Category::CATEGORY_ACTIVE => false]);

                        Notification::make()
                            ->title(__('Categorie gedeactiveerd'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('Selectie deactiveren'))
                        ->action(function (Collection $records) {
                            $records->each(fn(Category $record) => $record->update([
                                Category::CATEGORY_ACTIVE => false,
                            ]));

                            Notification::make()
                                ->title(__('Categorieën gedeactiveerd'))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}