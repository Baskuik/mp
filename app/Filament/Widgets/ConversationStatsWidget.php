<?php

namespace App\Filament\Widgets;

use App\Models\Conversation;
use App\Models\Message;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ConversationStatsWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalConversations  = Conversation::count();
        $totalMessages       = Message::count();
        $activeToday         = Conversation::whereHas('messages', function ($q) {
            $q->where('created_at', '>=', Carbon::today());
        })->count();

        $avgMessagesPerConvo = $totalConversations > 0
            ? round($totalMessages / $totalConversations, 1)
            : 0;

        return [
            Stat::make('Gesprekken', $totalConversations)
                ->description('Totaal aantal gesprekken')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary')
                ->icon('heroicon-o-chat-bubble-left-right'),

            Stat::make('Berichten', $totalMessages)
                ->description('Gemiddeld ' . $avgMessagesPerConvo . ' per gesprek')
                ->descriptionIcon('heroicon-m-chat-bubble-left')
                ->color('info')
                ->icon('heroicon-o-chat-bubble-left'),

            Stat::make('Actief vandaag', $activeToday)
                ->description('Gesprekken met bericht vandaag')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('success')
                ->icon('heroicon-o-bolt'),
        ];
    }
}
