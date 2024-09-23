<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TableResource\Pages;
use App\Models\Floor;
use App\Models\SettingSystem;
use App\Models\Table as TableModel;
use App\Models\TableOrder;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TableResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = TableModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Bàn';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin bàn')
                    ->schema([
                        TextInput::make('name')
                            ->label('Tên bàn')
                            ->required()
                            ->maxLength(25)
                            ->columnSpan(3),
                        Select::make('floor_id')
                            ->label('Tầng')
                            ->placeholder('Chọn tầng')
                            ->relationship('floor', 'name')
                            ->required()
                            ->options(Floor::all()->pluck('name', 'id'))
                            ->columnSpan(1),
                    ])
                    ->columns(4)
                    ->columnSpan(2),
            ]);
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
        ? strval(static::getEloquentQuery()->count())
        : null;
    }

    public static function table(Table $table)
    : Table {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên bàn')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('floor.name')
                    ->label('Tầng')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('')
                    ->label('Trạng thái')
                    ->getStateUsing(function ($record) {
                        return self::tableQuery($record);
                    })
                    ->searchable()
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state)
                        : string => match ($state) {
                            'Bàn trống' => 'primary',
                            'Bàn đã được đặt' => 'success',
                        })
                    ->limit(50),
                ToggleColumn::make('active')
                    ->label('Ẩn hiện')
                    ->offIcon('heroicon-s-lock-open')
                    ->onIcon('heroicon-o-lock-closed')
                    ->onColor('primary')
                    ->offColor('green')
                    ->tooltip(fn(TableModel $record) => $record->active === 0 ? 'Hiện' : 'Ẩn')
                    ->disabled(function ($record) {
                        return $record->table_order()->exists();
                    }),
            ])
            ->filters([
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->searchable(false)
            ->emptyStateIcon('heroicon-o-bookmark');
    }

    public static function getHourTable()
    {
        $timeSetting = SettingSystem::getHourTable();
        $hours = substr($timeSetting, 0, 2);
        $minutes = substr($timeSetting, 3, 2);
        $seconds = substr($timeSetting, 6, 2);

        $totalHours = (int) $hours + ((int) $minutes / 60) + ((int) $seconds / 3600);
        return $totalHours;
    }

    public static function tableQuery($record)
    {
        $timeTableSetting = self::getHourTable();
        $tableOrders = TableOrder::where('table_id', $record->id)
            ->whereRaw('NOW() > DATE_SUB(order_date, INTERVAL ' . $timeTableSetting . ' HOUR)')
            ->where('order_date', '>', now())
            ->exists();
        $tableStatus = $tableOrders ? 'Bàn đã được đặt' : 'Bàn trống';
        return $tableStatus;
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
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}