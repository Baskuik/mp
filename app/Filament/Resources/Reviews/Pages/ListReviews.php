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

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ReviewStatsOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        // Validate and normalize date parameters
        $normalizeDate = static function (mixed $value): ?string {
            if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                return null;
            }

            [$year, $month, $day] = array_map('intval', explode('-', $value));

            return checkdate($month, $day, $year) ? $value : null;
        };

        $dateFrom = $normalizeDate(request()->query('date_from'));
        $dateTo = $normalizeDate(request()->query('date_to'));

        $hasFilter = $dateFrom || $dateTo;

        $actions = [];

        // "Alle" reset-knop — altijd zichtbaar, maar behoudt andere query params
        $baseParams = array_diff_key(request()->query(), ['date_from' => true, 'date_to' => true]);
        $actions[] = Actions\Action::make('filter-reset')
            ->label('Alle')
            ->url('?' . http_build_query($baseParams))
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
                    ->maxDate(fn(callable $get) => $get('date_to') ?: now()),
                DatePicker::make('date_to')
                    ->label('Tot en met')
                    ->default($dateTo)
                    ->minDate(fn(callable $get) => $get('date_from'))
                    ->maxDate(now()),
            ])
            ->action(function (array $data): void {
                $params = array_filter([
                    'date_from' => $data['date_from'] ?? null,
                    'date_to' => $data['date_to'] ?? null,
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
        // Validate and normalize date parameters
        $normalizeDate = static function (mixed $value): ?string {
            if (!is_string($value) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                return null;
            }

            [$year, $month, $day] = array_map('intval', explode('-', $value));

            return checkdate($month, $day, $year) ? $value : null;
        };

        $dateFrom = $normalizeDate(request()->query('date_from'));
        $dateTo = $normalizeDate(request()->query('date_to'));

        $table = parent::getTable();

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