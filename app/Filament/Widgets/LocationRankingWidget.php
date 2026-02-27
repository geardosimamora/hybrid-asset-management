<?php

namespace App\Filament\Widgets;

use App\Models\Location;
use App\Services\AnalyticsService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LocationRankingWidget extends BaseWidget
{
    // Mengatur agar widget ini mengambil lebar penuh di dashboard
    protected int | string | array $columnSpan = 'full';
    
    // Judul tabel di dashboard
    protected static ?string $heading = 'Location Ranking by Total Asset Value';

    public function table(Table $table): Table
    {
        // 1. Panggil Service Analytics yang Anda buat kemarin
        $analyticsService = new AnalyticsService();
        $rankingData = $analyticsService->getLocationRanking();
        
        // 2. Jadikan hasil raw query PostgreSQL sebagai Collection Laravel
        $query = collect($rankingData);
        $locationNames = $query->pluck('location_name')->toArray();

        return $table
            ->query(
                // Kita kaitkan model Location dengan data nama lokasi dari hasil Analytics
                Location::query()->whereIn('name', $locationNames)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Location Name'),
                
                // Menampilkan hasil kalkulasi SUM(purchase_price) dari service
                Tables\Columns\TextColumn::make('total_asset_value')
                    ->label('Total Asset Value')
                    ->money('IDR')
                    ->state(function ($record) use ($query) {
                        $data = $query->firstWhere('location_name', $record->name);
                        return $data ? $data->total_asset_value : 0;
                    }),

                // Menampilkan hasil DENSE_RANK() dari service
                Tables\Columns\TextColumn::make('location_rank')
                    ->label('Rank')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'warning',
                        '3' => 'info',
                        default => 'gray',
                    })
                    ->state(function ($record) use ($query) {
                        $data = $query->firstWhere('location_name', $record->name);
                        return $data ? $data->location_rank : '-';
                    })
            ])
            // Matikan pagination karena ini widget ranking top level
            ->paginated(false); 
    }
}