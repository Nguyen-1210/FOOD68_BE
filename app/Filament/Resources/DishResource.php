<?php

namespace App\Filament\Resources;

use App\Enums\DishStatus;
use App\Filament\Resources\DishResource\Pages;
use App\Http\Helpers\FormatHelper;
use App\Models\Categories;
use App\Models\Dish;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
  
class DishResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Dish::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Danh sách món ăn';
  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Tên món ăn')
                    ->placeholder('Nhập tên món ăn')
                    ->columnSpan(1)
                    ->required(),
                TextInput::make('original_price')
                    ->label('Giá gốc')
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(10000000)
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'dish_id')
                    ->multiple(true)
                    ->options(function () {
                        return Categories::all()->where('active', 0)->pluck('name', 'id');
                    })
                    ->label('Danh mục món ăn')
                    ->placeholder('Chọn danh mục')
                    ->required(),
                FileUpload::make('thumbnail')
                    ->label('Hình ảnh')
                    ->image()
                    ->directory('dishes')
                    ->storeFileNamesIn('original_filename')
                    ->imageEditor()
                    ->imagePreviewHeight('300')
                    ->nullable()
                    ->columnSpanFull(),
                Toggle::make('status')
                    ->label('Trạng thái')
                    ->offIcon('heroicon-s-lock-open')
                    ->onIcon('heroicon-o-lock-closed')
                    ->onColor('primary')
                    ->offColor('green'),
            ])
            ->columns(3);
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
                    ->label('Tên món ăn')
                    ->searchable(),
                ImageColumn::make('thumbnail')
                    ->label('Hình ảnh')
                    ->size(75)
                    ->circular(),
                TextColumn::make('original_price')
                    ->label('Giá gốc')
                    ->formatStateUsing(function ($state) {
                        $formatHelper = new FormatHelper();
                        return $formatHelper->formatPrice($state);
                    }),
                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->searchable(),
                SelectColumn::make('status')
                    ->label('Trạng thái')
                    ->options(DishStatus::class),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDishes::route('/'),
            'create' => Pages\CreateDish::route('/create'),
            'edit' => Pages\EditDish::route('/{record}/edit'),
        ];
    }
}