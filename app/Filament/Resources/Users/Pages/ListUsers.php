<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        $options = [
            'actief'        => 'Actief',
            'gedeactiveerd' => 'Gedeactiveerd',
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
            $newTabs  = $isActive
                ? array_filter($activeTabs, fn ($t) => $t !== $value)
                : array_merge($activeTabs, [$value]);

            $actions[] = Actions\Action::make("tab-{$value}")
                ->label($label)
                ->url('?' . http_build_query(['tab' => array_values($newTabs)]))
                ->color('success')
                ->outlined(!$isActive)
                ->size('sm');
        }

        $actions[] = Actions\CreateAction::make()->label('User aanmaken');

        return $actions;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\UserStatsOverview::class,
        ];
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
                if (in_array('actief', $activeTabs) && !in_array('gedeactiveerd', $activeTabs)) {
                    $query->where('is_active', 1);
                } elseif (in_array('gedeactiveerd', $activeTabs) && !in_array('actief', $activeTabs)) {
                    $query->where('is_active', 0);
                }
                return $query;
            });
        }

        return $table;
    }
}