<?php

namespace App\Filament\Widgets;

use App\Models\Bid;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class BidsOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Biedingen over tijd';
    protected static ?int $sort = 5;
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
                $data[]   = Bid::whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            $labels = [];
            $data   = [];

            for ($i = 11; $i >= 0; $i--) {
                $month    = Carbon::now()->subMonths($i);
                $labels[] = $month->translatedFormat('M Y');
                $data[]   = Bid::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Biedingen',
                    'data'            => $data,
                    'borderColor'     => '#f59e0b',
                    'backgroundColor' => 'rgba(245,158,11,0.1)',
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
