<?php

namespace App\Filament\Resources\Assets\Pages;

use App\Filament\Resources\Assets\AssetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    // PASTIKAN NAMA FUNGSINYA ADALAH getRedirectUrl
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}