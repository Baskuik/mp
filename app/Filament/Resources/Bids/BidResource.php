<?php

namespace App\Filament\Resources\Bids;

use App\Filament\Resources\Bids\Pages\CreateBid;
use App\Filament\Resources\Bids\Pages\EditBid;
use App\Filament\Resources\Bids\Pages\ListBids;
use App\Filament\Resources\Bids\Schemas\BidForm;
use App\Filament\Resources\Bids\Tables\BidsTable;
use App\Models\Bid;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BidResource extends Resource
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';
    protected static \UnitEnum|string|null $navigationGroup = 'BEHEER';

    public static function form(Schema $schema): Schema
    {
        return BidForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BidsTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\BidStatsOverview::class,
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBids::route('/'),
            'create' => CreateBid::route('/create'),
            'edit' => EditBid::route('/{record}/edit'),
        ];
    }
}
