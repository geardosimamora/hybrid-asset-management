<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('category_id')
                    ->required(),
                TextInput::make('location_id')
                    ->required(),
                TextInput::make('purchase_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                DatePicker::make('purchase_date')
                    ->required(),
                TextInput::make('useful_life_years')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
