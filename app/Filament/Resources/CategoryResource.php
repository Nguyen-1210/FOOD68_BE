<?php

namespace App\Filament\Resources;

use App\Enums\CategoryType;
use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Categories;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class CategoryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Categories::class;

    protected static ?string $label = 'Danh mục món ăn';

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Tên danh mục')
                    ->placeholder('Nhập tên danh mục')
                    ->required(),
                Select::make('type')
                    ->label('Loại danh mục')
                    ->required()
                    ->default(0)
                    ->options(CategoryType::class),
                FileUpload::make('thumbnail')
                    ->label('Hình ảnh')
                    ->image()
                    ->imageEditor()
                    ->imagePreviewHeight('300')
                    ->nullable()
                    ->columnSpanFull(),
                Toggle::make('active')
                    ->label('Ẩn hiện')
                    ->offIcon('heroicon-s-lock-open')
                    ->onIcon('heroicon-o-lock-closed')
                    ->onColor('primary')
                    ->offColor('green'),
            ]);
    }

    public static function table(Table $table)
    : Table {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Tên danh mục'),
                ImageColumn::make('thumbnail')
                    ->label('Hình ảnh')
                    ->size(75)
                    ->circular(),
                TextColumn::make('type')
                    ->label('Loại danh mục')
                    ->badge(),
                ToggleColumn::make('active')
                    ->label('Trạng thái')
                    ->offIcon('heroicon-s-lock-open')
                    ->onIcon('heroicon-o-lock-closed')
                    ->onColor('primary')
                    ->offColor('green')
                    ->tooltip(fn($record) => $record->active === 0 ? 'Sử dụng' : 'Ngưng sử dụng')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->color('green'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->successNotificationTitle('Xóa thành công'),
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateIcon('heroicon-o-bookmark')
            ->searchable(false)
            ->paginated(false);
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
        ? strval(static::getEloquentQuery()->count())
        : null;
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
            'index' => Pages\ListCategories::route('/'),
        ];
    }
}