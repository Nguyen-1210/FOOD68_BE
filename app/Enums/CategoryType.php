<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CategoryType: string implements HasLabel, HasColor, HasIcon {

    case main_dishes = '0';
    case appetizer = '1';
    case desserts = '2';

    public function getLabel()
    : ?string {
        return match ($this) {
            self::main_dishes => 'Món chính',
            self::appetizer => 'Món ăn kèm',
            self::desserts => 'Món Tráng miệng'
        };
    }

    public function getColor()
    : string {
        return match ($this) {
            self::main_dishes => 'green',
            self::appetizer => 'purple',
            self::desserts => 'yellow'
        };
    }

    public function getIcon()
    : ?string {
        return match ($this) {
            self::main_dishes => 'heroicon-o-sparkles',
            self::appetizer => 'heroicon-o-star',
            self::desserts => 'heroicon-o-cake'
        };
    }
}