<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ListingsByLocationWidget extends ChartWidget
{
    protected ?string $heading = 'Advertenties per locatie (top 8)';
    protected static ?int $sort = 9;

    protected function getData(): array
    {
        $data = Listing::query()
            ->select('location', DB::raw('count(*) as total'))
            ->whereNotNull('location')
            ->where('location', '!=', '')
            ->whereNull('deleted_at')
            ->where('status', 'active')
            ->groupBy('location')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $colors = [
            'rgba(99,102,241,0.8)',
            'rgba(16,185,129,0.8)',
            'rgba(245,158,11,0.8)',
            'rgba(239,68,68,0.8)',
            'rgba(59,130,246,0.8)',
            'rgba(168,85,247,0.8)',
            'rgba(236,72,153,0.8)',
            'rgba(20,184,166,0.8)',
        ];

        return [
            'datasets' => [
                [
                    'label'           => 'Advertenties',
                    'data'            => $data->pluck('total')->toArray(),
                    'backgroundColor' => $colors,
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $data->pluck('location')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}