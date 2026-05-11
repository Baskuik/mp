<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use App\Models\Review;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        $dateFrom = request()->query('date_from');
        $dateTo   = request()->query('date_to');

        $hasFilter = $dateFrom || $dateTo;

        $actions = [];

        // "Alle" reset-knop — altijd zichtbaar
        $actions[] = Actions\Action::make('filter-reset')
            ->label('Alle')
            ->url('?')
            ->color('success')
            ->outlined($hasFilter)
            ->size('sm');

        // Kalender-filter actie met datepickers in een modal
        $actions[] = Actions\Action::make('filter-date')
            ->label($hasFilter
                ? 'Periode: ' . ($dateFrom ?? '…') . ' → ' . ($dateTo ?? '…')
                : 'Filter op periode')
            ->icon('heroicon-o-calendar')
            ->color($hasFilter ? 'success' : 'primary')
            ->outlined(true)
            ->size('sm')
            ->form([
                DatePicker::make('date_from')
                    ->label('Van')
                    ->default($dateFrom)
                    ->maxDate(fn (callable $get) => $get('date_to') ?: now()),
                DatePicker::make('date_to')
                    ->label('Tot en met')
                    ->default($dateTo)
                    ->minDate(fn (callable $get) => $get('date_from'))
                    ->maxDate(now()),
            ])
            ->action(function (array $data): void {
                $params = array_filter([
                    'date_from' => $data['date_from'] ?? null,
                    'date_to'   => $data['date_to']   ?? null,
                ]);

                $this->redirect('?' . http_build_query($params));
            })
            ->modalHeading('Filter op datum')
            ->modalSubmitActionLabel('Toepassen')
            ->modalCancelActionLabel('Annuleren');

        $actions[] = Actions\CreateAction::make()
            ->label('Review aanmaken');

        return $actions;
    }

    public function getTable(): \Filament\Tables\Table
    {
        $table = parent::getTable();

        $dateFrom = request()->query('date_from');
        $dateTo   = request()->query('date_to');

        if ($dateFrom || $dateTo) {
            $table->modifyQueryUsing(function ($query) use ($dateFrom, $dateTo) {
                if ($dateFrom) {
                    $query->whereDate(Review::CREATED_AT, '>=', $dateFrom);
                }
                if ($dateTo) {
                    $query->whereDate(Review::CREATED_AT, '<=', $dateTo);
                }
            });
        }

        return $table;
    }
}