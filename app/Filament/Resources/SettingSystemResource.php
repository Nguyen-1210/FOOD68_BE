<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingSystemResource\Pages;
use App\Models\SettingSystem;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class SettingSystemResource extends Resource
{
    protected static ?string $model = SettingSystem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Cài đặt hệ thống';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('open_door')
                    ->label('Giờ mở cửa'),
                TextInputColumn::make('close_door')
                    ->label('Giờ đóng cửa'),
                TextInputColumn::make('hour_table')
                    ->label('Giờ đặt bàn'),
            ])
            ->searchable(false)
            ->paginated(false);
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
            'index' => Pages\ListSettingSystems::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}