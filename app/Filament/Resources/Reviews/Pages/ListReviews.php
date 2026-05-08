<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use App\Models\Review;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        $actions = [
            Actions\Action::make('tab-alle')
                ->label('Alle')
                ->url('?')
                ->color('success')
                ->outlined(!empty($activeTabs))
                ->size('sm'),
        ];

        foreach (range(1, 5) as $star) {
            $isActive = in_array((string) $star, $activeTabs);

            $newTabs = $isActive
                ? array_filter($activeTabs, fn ($t) => $t !== (string) $star)
                : array_merge($activeTabs, [(string) $star]);

            $query = http_build_query(['tab' => array_values($newTabs)]);

            $actions[] = Actions\Action::make("tab-{$star}")
                ->label("⭐ {$star}")
                ->url('?' . $query)
                ->color('success')
                ->outlined(!$isActive)
                ->size('sm');
        }

        $actions[] = Actions\CreateAction::make()
            ->label('Review aanmaken');

        return $actions;
    }

    public function getTable(): \Filament\Tables\Table
    {
        $table = parent::getTable();

        $activeTabs = request()->query('tab', []);

        if (is_string($activeTabs)) {
            $activeTabs = [$activeTabs];
        }

        $ratings = array_map('intval', $activeTabs);

        if (!empty($ratings)) {
            $table->modifyQueryUsing(fn ($query) => $query->whereIn(Review::REVIEW_RATING, $ratings));
        }

        return $table;
    }
}