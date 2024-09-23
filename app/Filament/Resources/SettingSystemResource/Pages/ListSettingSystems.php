<?php

namespace App\Filament\Resources\SettingSystemResource\Pages;

use App\Filament\Resources\SettingSystemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettingSystems extends ListRecords
{
    protected static string $resource = SettingSystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
