<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ReviewRatingDistributionWidget extends ChartWidget
{
    protected static ?string $heading = 'Verdeling beoordelingen (1-5 ster)';
    protected static ?int $sort = 7;

    protected function getData(): array
    {
        $ratings = Review::query()
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $data[] = $ratings[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Aantal reviews',
                    'data'            => $data,
                    'backgroundColor' => [
                        'rgba(239,68,68,0.8)',   // 1 ster - rood
                        'rgba(249,115,22,0.8)',   // 2 ster - oranje
                        'rgba(234,179,8,0.8)',    // 3 ster - geel
                        'rgba(132,204,22,0.8)',   // 4 ster - lichtgroen
                        'rgba(16,185,129,0.8)',   // 5 ster - groen
                    ],
                    'borderRadius' => 4,
                ],
            ],
            'labels' => ['⭐', '⭐⭐', '⭐⭐⭐', '⭐⭐⭐⭐', '⭐⭐⭐⭐⭐'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
