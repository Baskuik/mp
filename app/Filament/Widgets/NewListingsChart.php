<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class NewListingsChart extends ChartWidget
{
    protected ?string $heading = 'Nieuwe advertenties';
    protected static ?int $sort = 4;
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
                $data[]   = Listing::whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            $labels = [];
            $data   = [];

            for ($i = 11; $i >= 0; $i--) {
                $month    = Carbon::now()->subMonths($i);
                $labels[] = $month->translatedFormat('M Y');
                $data[]   = Listing::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Advertenties',
                    'data'            => $data,
                    'backgroundColor' => 'rgba(16,185,129,0.8)',
                    'borderColor'     => '#10b981',
                    'borderRadius'    => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
