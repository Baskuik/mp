<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class BannedUsersWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $totalBanned     = User::where('is_banned', true)->count();
        $bannedThisWeek  = User::where('is_banned', true)
            ->where('updated_at', '>=', Carbon::now()->subWeek())
            ->count();
        $bannedThisMonth = User::where('is_banned', true)
            ->where('updated_at', '>=', Carbon::now()->subMonth())
            ->count();

        return [
            Stat::make('Verbannen gebruikers', $totalBanned)
                ->description('Totaal aantal gebande accounts')
                ->descriptionIcon('heroicon-m-no-symbol')
                ->color('danger')
                ->icon('heroicon-o-no-symbol'),

            Stat::make('Geband deze week', $bannedThisWeek)
                ->description('Bans in de afgelopen 7 dagen')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Geband deze maand', $bannedThisMonth)
                ->description('Bans in de afgelopen 30 dagen')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info')
                ->icon('heroicon-o-calendar'),
        ];
    }
}
