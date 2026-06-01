<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    private static function badge(string $label, string $color, string $textColor = 'white'): string
    {
        $colors = [
            'green'  => 'linear-gradient(135deg,#22c55e,#16a34a)',
            'red'    => 'linear-gradient(135deg,#ef4444,#dc2626)',
            'darkred'=> 'linear-gradient(135deg,#dc2626,#991b1b)',
            'amber'  => 'linear-gradient(135deg,#f59e0b,#d97706)',
            'blue'   => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
            'orange' => 'linear-gradient(135deg,#f97316,#ea580c)',
            'indigo' => 'linear-gradient(135deg,#6366f1,#4f46e5)',
            'gray'   => 'linear-gradient(135deg,#6b7280,#4b5563)',
        ];

        $shadows = [
            'green'  => 'rgba(34,197,94,0.4)',
            'red'    => 'rgba(239,68,68,0.4)',
            'darkred'=> 'rgba(220,38,38,0.5)',
            'amber'  => 'rgba(245,158,11,0.4)',
            'blue'   => 'rgba(14,165,233,0.4)',
            'orange' => 'rgba(249,115,22,0.4)',
            'indigo' => 'rgba(99,102,241,0.3)',
            'gray'   => 'rgba(107,114,128,0.3)',
        ];

        $bg     = $colors[$color]  ?? $colors['gray'];
        $shadow = $shadows[$color] ?? $shadows['gray'];

        return sprintf(
            '<span style="background:%s;color:%s;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:0.5px;box-shadow:0 2px 4px %s;white-space:nowrap;">%s</span>',
            $bg, $textColor, $shadow, $label
        );
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->label('')
                    ->getStateUsing(fn($record) => $record->profile_photo_path
                        ? asset('storage/' . $record->profile_photo_path)
                        : null)
                    ->defaultImageUrl(asset('images/default-avatar.png'))
                    ->circular()
                    ->size(40),

                TextColumn::make('user_id')
                    ->label('ID')
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make('name')
                    ->label(__('admin.col_name'))
                    ->description(fn(User $record): string => $record->email)
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('is_admin')
                    ->label(__('admin.col_rol'))
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_admin
                        ? self::badge(__('admin.badge_admin'), 'amber')
                        : self::badge(__('admin.badge_user'), 'indigo'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('is_active')
                    ->label(__('admin.col_status'))
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_active
                        ? self::badge(__('admin.badge_active'), 'green')
                        : self::badge(__('admin.badge_deactivated'), 'red'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('is_banned')
                    ->label(__('admin.col_ban'))
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->is_banned
                        ? self::badge(__('admin.badge_ban_yes'), 'green')
                        : self::badge(__('admin.badge_ban_no'), 'darkred'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->label(__('admin.col_email'))
                    ->html()
                    ->getStateUsing(fn(User $record): string => $record->email_verified_at
                        ? self::badge(__('admin.badge_verified'), 'blue')
                        : self::badge(__('admin.badge_not_verified'), 'orange'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('username')
                    ->label(__('admin.col_username'))
                    ->color('gray')
                    ->sortable()
                    ->toggleable()
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('bio')
                    ->label(__('admin.col_bio'))
                    ->color('gray')
                    ->limit(40)
                    ->toggleable()
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label(__('admin.col_created_at'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('admin.col_updated_at'))
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('email_verified')
                    ->label(__('admin.col_email_verified'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),

                Filter::make('email_not_verified')
                    ->label(__('admin.col_email_not_verified'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNull('email_verified_at')),

                Filter::make('is_admin')
                    ->label(__('admin.col_admin'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_admin', true)),

                Filter::make('is_active')
                    ->label(__('admin.col_active'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_active', true)),

                Filter::make('is_not_active')
                    ->label(__('admin.col_not_active'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_active', false)),

                Filter::make('is_banned')
                    ->label(__('admin.col_banned'))
                    ->toggle()
                    ->query(fn(Builder $query) => $query->where('is_banned', true)),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-trash')
                    ->modalHeading(__('admin.col_modalheaddelete'))
                    ->modalDescription(__('admin.col_modalheadasure'))
                    ->modalSubmitActionLabel(__('admin.col_modalheadsure'))
                    ->action(function (User $record) {
                        $record->update(['is_active' => false]);
                        Notification::make()
                            ->title(__('admin.notify_deleted'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkAction::make('bulk_delete')
                    ->label(__('admin.bulk_delete_label'))
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.col_modalheadmultiple'))
                    ->modalDescription(__('admin.col_modalheadmultiple_desc'))
                    ->modalSubmitActionLabel(__('admin.bulk_delete_confirm'))
                    ->action(function (Collection $records) {
                        $records->each(fn(User $record) => $record->update(['is_active' => false]));

                        Notification::make()
                            ->title(__('admin.notify_bulk_deleted'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),

                BulkAction::make('change_status')
                    ->label(__('admin.col_bulkactionstatus'))
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->form([
                        Select::make('status')
                            ->label(__('admin.col_bulkstatuschoosen'))
                            ->options([
                                'active'     => __('admin.col_bulkstatusactive_desc'),
                                'deactivate' => __('admin.col_bulkstatusinactive_desc'),
                                'ban'        => __('admin.col_bulkstatusban_desc'),
                            ])
                            ->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        $records->each(function (User $record) use ($data) {
                            match ($data['status']) {
                                'active'     => $record->update(['is_active' => true,  'is_banned' => false]),
                                'deactivate' => $record->update(['is_active' => false, 'is_banned' => false]),
                                'ban'        => $record->update(['is_banned' => true,  'is_active' => false]),
                            };
                        });

                        Notification::make()
                            ->title(__('admin.col_statussucess'))
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}