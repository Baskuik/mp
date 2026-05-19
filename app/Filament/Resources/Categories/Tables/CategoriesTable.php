<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Models\Category;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CategoriesTable
{
    private static function badge(string $label, string $color, string $textColor = 'white'): string
    {
        $colors = [
            'green'   => 'linear-gradient(135deg,#22c55e,#16a34a)',
            'red'     => 'linear-gradient(135deg,#ef4444,#dc2626)',
            'darkred' => 'linear-gradient(135deg,#dc2626,#991b1b)',
            'amber'   => 'linear-gradient(135deg,#f59e0b,#d97706)',
            'blue'    => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
            'orange'  => 'linear-gradient(135deg,#f97316,#ea580c)',
            'indigo'  => 'linear-gradient(135deg,#6366f1,#4f46e5)',
            'gray'    => 'linear-gradient(135deg,#6b7280,#4b5563)',
            'teal'    => 'linear-gradient(135deg,#14b8a6,#0d9488)',
        ];

        $shadows = [
            'green'   => 'rgba(34,197,94,0.4)',
            'red'     => 'rgba(239,68,68,0.4)',
            'darkred' => 'rgba(220,38,38,0.5)',
            'amber'   => 'rgba(245,158,11,0.4)',
            'blue'    => 'rgba(14,165,233,0.4)',
            'orange'  => 'rgba(249,115,22,0.4)',
            'indigo'  => 'rgba(99,102,241,0.3)',
            'gray'    => 'rgba(107,114,128,0.3)',
            'teal'    => 'rgba(20,184,166,0.3)',
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
                TextColumn::make(Category::CATEGORY_ID)
                    ->label('ID')
                    ->prefix('#')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Category::CATEGORY_NAME)
                    ->label('CATEGORIE NAAM')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-tag')
                    ->iconColor('gray'),

                TextColumn::make(Category::CATEGORY_SLUG)
                    ->label('SLUG')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->icon('heroicon-m-link')
                    ->iconColor('gray')
                    ->color('gray'),

                TextColumn::make('parent.name')
                    ->label('BOVENLIGGENDE CATEGORIE')
                    ->placeholder('— Hoofdcategorie')
                    ->toggleable()
                    ->sortable()
                    ->icon('heroicon-m-folder')
                    ->iconColor('gray')
                    ->color('gray'),

                TextColumn::make(Category::CATEGORY_ACTIVE)
                    ->label('STATUS')
                    ->html()
                    ->getStateUsing(fn(Category $record): string => $record->category_active
                        ? self::badge('✓ ACTIEF', 'green')
                        : self::badge('○ INACTIEF', 'red'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make(Category::CREATED_AT)
                    ->label('AANGEMAAKT OP')
                    ->dateTime('d-m-Y H:i')
                    ->icon('heroicon-m-calendar')
                    ->iconColor('gray')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),

                TextColumn::make(Category::UPDATED_AT)
                    ->label('LAATSTE UPDATE')
                    ->dateTime('d-m-Y H:i')
                    ->toggleable()
                    ->sortable()
                    ->color('gray'),
            ])
            ->filters([
                Filter::make('hoofdcategorie')
                    ->label('Alleen hoofdcategorieën')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNull('parent_id')),

                Filter::make('subcategorie')
                    ->label('Alleen subcategorieën')
                    ->toggle()
                    ->query(fn(Builder $query) => $query->whereNotNull('parent_id')),
            ])
            ->actions([
                EditAction::make()
                    ->label(false)
                    ->icon('heroicon-m-pencil-square')
                    ->color('blue'),

                DeleteAction::make()
                    ->label(false)
                    ->icon('heroicon-m-eye-slash')
                    ->modalHeading('Categorie deactiveren')
                    ->modalDescription('Deze categorie wordt onzichtbaar voor klanten.')
                    ->modalSubmitActionLabel('Ja, deactiveer')
                    ->action(function (Category $record) {
                        $record->update([Category::CATEGORY_ACTIVE => false]);

                        Notification::make()
                            ->title('Categorie gedeactiveerd')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Action::make('deactivate')
                    ->label('Selectie deactiveren')
                    ->icon('heroicon-m-eye-slash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Geselecteerde categorieën deactiveren')
                    ->action(function (Collection $records) {
                        $records->each(fn(Category $record) => $record->update([
                            Category::CATEGORY_ACTIVE => false,
                        ]));

                        Notification::make()
                            ->title('Categorieën gedeactiveerd')
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}