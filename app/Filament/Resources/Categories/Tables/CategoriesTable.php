<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CATEGORY_NAME)
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CATEGORY_SLUG)
                    ->label(__('Slug'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::PARENT_ID)
                    ->label(__('Parent ID'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::CREATED_AT)
                    ->label(__('Created At'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make(Category::UPDATED_AT)
                    ->label(__('Updated At'))
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
