<?php

namespace App\Filament\Resources\GeoDataResource\Pages;

use App\Filament\Resources\GeoDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeoData extends EditRecord
{
    protected static string $resource = GeoDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
