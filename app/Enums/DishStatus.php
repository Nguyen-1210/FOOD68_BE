<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DishStatus: string implements HasLabel, HasColor, HasIcon {

    case ready = '0';
    case is_over = '1';

    public function getLabel()
    : ?string {
        return match ($this) {
            self::ready => 'Sẳn sàng',
            self::is_over => 'Đã hết'
        };
    }

    public function getColor()
    : string {
        return match ($this) {
            self::ready => 'green',
            self::is_over => 'purple'
        };
    }

    public function getIcon()
    : ?string {
        return match ($this) {
            self::ready => 'heroicon-o-sparkles',
            self::is_over => 'heroicon-o-star',
        };
    }
}