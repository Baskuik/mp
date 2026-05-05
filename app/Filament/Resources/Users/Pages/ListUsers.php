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
        $currentTab = request()->query('tab', 'alle');

        return [
            // Tab buttons (styled as badges/pills)
            Actions\Action::make('tab-alle')
                ->label('Alle')
                ->url('?tab=alle')
                ->color($currentTab === 'alle' ? 'info' : 'gray')
                ->size('sm'),

            Actions\Action::make('tab-admins')
                ->label('Admins')
                ->url('?tab=admins')
                ->color($currentTab === 'admins' ? 'warning' : 'gray')
                ->size('sm'),

            Actions\Action::make('tab-actief')
                ->label('Actief')
                ->url('?tab=actief')
                ->color($currentTab === 'actief' ? 'info' : 'gray')
                ->size('sm'),

            // Create action
            Actions\CreateAction::make()
                ->label('User aanmaken'),
        ];
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

        // Get the active tab from query string
        $tab = request()->query('tab', 'alle');

        // Apply filtering based on the tab
        if ($tab === 'admins') {
            $table->modifyQueryUsing(function ($query) {
                return $query->where('is_admin', true);
            });
        } elseif ($tab === 'actief') {
            $table->modifyQueryUsing(function ($query) {
                return $query->where('is_active', true);
            });
        }

        return $table;
    }
}