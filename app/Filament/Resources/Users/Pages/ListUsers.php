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
        $activeTab = request()->query('tab');

        $options = [
            'actief' => 'Actief',
            'gedeactiveerd' => 'Gedeactiveerd',
            'verbannen' => 'Verbannen',
        ];

        $actions = [
            Actions\Action::make('tab-alle')
                ->label('Alle')
                ->url('?')
                ->color('success')
                ->outlined(!empty($activeTab))
                ->size('sm'),
        ];

        foreach ($options as $value => $label) {
            $isActive = $activeTab === $value;
            // Mutually exclusive: set this tab as the only active one
            $actions[] = Actions\Action::make("tab-{$value}")
                ->label($label)
                ->url('?' . http_build_query(['tab' => $value]))
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

        $activeTab = request()->query('tab');

        $table->modifyQueryUsing(function ($query) use ($activeTab) {
            // Standaard: toon alles
            if (empty($activeTab)) {
                return $query;
            }

            switch ($activeTab) {
                case 'actief':
                    $query->where('is_banned', 0)->where('is_active', 1);
                    break;
                case 'gedeactiveerd':
                    $query->where('is_banned', 0)->where('is_active', 0);
                    break;
                case 'verbannen':
                    $query->where('is_banned', 1);
                    break;
            }

            return $query;
        });

        return $table;
    }
}