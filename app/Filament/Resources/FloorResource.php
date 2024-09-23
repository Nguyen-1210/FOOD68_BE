<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FloorResource\Pages;
use App\Models\Floor;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class FloorResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Floor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Tầng';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Tầng')
                    ->required(),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
        ? strval(static::getEloquentQuery()->count())
        : null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tầng'),
                TextInputColumn::make('ordering')
                    ->label('Vị trí'),
            ])
            ->defaultSort('ordering', 'asc')
            ->actions([
                EditAction::make(),
            ])
            ->emptyStateIcon('heroicon-o-bookmark')
            ->searchable(false)
            ->reorderable('ordering')
            ->paginated(false);
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFloors::route('/'),
        ];
    }
}