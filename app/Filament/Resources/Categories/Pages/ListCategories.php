<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\CategoryStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        $options = [
            'actief' => 'Actief',
            'inactief' => 'Inactief',
        ];

        $actions = [
            Actions\Action::make('tab-alle')
                ->label('Alle')
                ->url('?')
                ->color('success')
                ->outlined(!empty($activeTabs))
                ->size('sm'),
        ];

        foreach ($options as $value => $label) {
            $isActive = in_array($value, $activeTabs);
            $newTabs = $isActive
                ? array_filter($activeTabs, fn($t) => $t !== $value)
                : array_merge($activeTabs, [$value]);

            $actions[] = Actions\Action::make("tab-{$value}")
                ->label($label)
                ->url('?' . http_build_query(['tab' => array_values($newTabs)]))
                ->color('success')
                ->outlined(!$isActive)
                ->size('sm');
        }

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