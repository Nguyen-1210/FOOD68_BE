<?php

namespace App\Filament\Resources\SettingSystemResource\Pages;

use App\Filament\Resources\SettingSystemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettingSystem extends EditRecord
{
    protected static string $resource = SettingSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
