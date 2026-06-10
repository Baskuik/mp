<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class NewUsersChart extends ChartWidget
{
    protected ?string $heading = 'Nieuwe gebruikers';
    protected static ?int $sort = 3;
    public ?string $filter = 'month';

    protected function getFilters(): ?array
    {
        return [
            'week'  => 'Per week (laatste 12 weken)',
            'month' => 'Per maand (laatste 12 maanden)',
        ];
    }

    protected function getData(): array
    {
        if ($this->filter === 'week') {
            $labels = [];
            $data   = [];

            for ($i = 11; $i >= 0; $i--) {
                $start    = Carbon::now()->subWeeks($i)->startOfWeek();
                $end      = Carbon::now()->subWeeks($i)->endOfWeek();
                $labels[] = 'Week ' . $start->format('W');
                $data[]   = User::whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            $labels = [];
            $data   = [];

            for ($i = 11; $i >= 0; $i--) {
                $month    = Carbon::now()->subMonths($i);
                $labels[] = $month->translatedFormat('M Y');
                $data[]   = User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Nieuwe gebruikers',
                    'data'            => $data,
                    'borderColor'     => '#6366f1',
                    'backgroundColor' => 'rgba(99,102,241,0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
