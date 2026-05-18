<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Traits\HasQueryTabActions;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    use HasQueryTabActions;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\CategoryStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        $tabOptions = [
            'actief' => 'Actief',
            'inactief' => 'Inactief',
        ];

        $actions = $this->buildTabActions($tabOptions);
        $actions[] = Actions\CreateAction::make()->label('Categorie aanmaken');

        return $actions;
    }

    public function getTable(): \Filament\Tables\Table
    {
        $table = parent::getTable();

        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        if (!empty($activeTabs)) {
            $table->modifyQueryUsing(function ($query) use ($activeTabs) {
                if (in_array('actief', $activeTabs) && !in_array('inactief', $activeTabs)) {
                    $query->where('category_active', true);
                } elseif (in_array('inactief', $activeTabs) && !in_array('actief', $activeTabs)) {
                    $query->where('category_active', false);
                }
                return $query;
            });
        }

        return $table;
    }
}