<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(Category::CATEGORY_ID)
                    ->label(__('ID'))
                    ->placeholder('Geen ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CATEGORY_NAME)
                    ->label(__('Name'))
                    ->placeholder('Geen naam beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CATEGORY_SLUG)
                    ->label(__('Slug'))
                    ->placeholder('Geen slug beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::PARENT_ID)
                    ->label(__('Parent ID'))
                    ->placeholder('Geen parent ID beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CREATED_AT)
                    ->label(__('Created At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::UPDATED_AT)
                    ->label(__('Updated At'))
                    ->placeholder('Geen datum beschikbaar')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
