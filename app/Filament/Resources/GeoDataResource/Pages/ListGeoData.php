<?php

namespace App\Filament\Resources\GeoDataResource\Pages;

use App\Filament\Resources\GeoDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeoData extends ListRecords
{
    protected static string $resource = GeoDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
