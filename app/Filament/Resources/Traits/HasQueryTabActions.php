<?php

namespace App\Filament\Resources\Traits;

use Filament\Actions;

trait HasQueryTabActions
{
    /**
     * Build tab filter actions for list pages.
     * Preserves other query parameters while toggling tabs.
     *
     * @param array $options Tab options [value => label]
     * @param string $resetLabel Label for the "reset all tabs" button
     * @return array List of Action instances
     */
    protected function buildTabActions(array $options, string $resetLabel = 'Alle'): array
    {
        $activeTabs = (array) request()->query('tab', []);

        // Preserve all query params except 'tab'
        $baseParams = array_diff_key(request()->query(), ['tab' => true]);

        $actions = [
            Actions\Action::make('tab-alle')
                ->label($resetLabel)
                ->url('?' . http_build_query($baseParams))
                ->color('success')
                ->outlined(!empty($activeTabs))
                ->size('sm'),
        ];

        foreach ($options as $value => $label) {
            $isActive = in_array((string) $value, $activeTabs, true);
            $newTabs = $isActive
                ? array_filter($activeTabs, fn($t) => $t !== (string) $value)
                : array_merge($activeTabs, [(string) $value]);

            $params = array_merge($baseParams, ['tab' => array_values($newTabs)]);

            $actions[] = Actions\Action::make("tab-{$value}")
                ->label($label)
                ->url('?' . http_build_query($params))
                ->color('success')
                ->outlined(!$isActive)
                ->size('sm');
        }

        return $actions;
    }
}
