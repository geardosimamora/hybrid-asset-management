<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('asset_code')
                    ->label('Kode Aset')
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: AST-001') //Sesuaikan dengan format kode aset yang diinginkan
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Aset')
                    ->required(),

                //Category menjadi Dropdown Select yang mengambil data dari tabel categories
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name') // Mengambil nama kategori dari relasi
                    ->searchable() // Menambahkan fitur pencarian pada dropdown
                    ->preload() // Memuat semua kategori saat form dibuka untuk menghindari query tambahan saat memilih
                    ->required(),

                //Location menjadi Dropdown Select yang mengambil data dari tabel locations
                Select::make('location_id')
                    ->label('Lokasi Aset')
                    ->relationship('location', 'name') // Mengambil nama lokasi dari relasi 
                    ->searchable() // Menambahkan fitur pencarian pada dropdown
                    ->preload() // Memuat semua lokasi saat form dibuka untuk menghindari query tambahan saat memilih
                    ->required(),

                TextInput::make('purchase_price')
                    ->label('Harga Beli(Rp)')
                    ->required()
                    ->numeric()
                    ->minValue(0) // Validasi Tidak Boleh Minus
                    ->prefix('Rp'),
                DatePicker::make('purchase_date')
                    ->label('Tanggal Pembelian')
                    ->required()
                    ->maxDate(now()), // Validasi Tidak Boleh lebih dari hari ini
                TextInput::make('useful_life_years')
                    ->label('Umur Ekonomis (Tahun)')
                    ->required()
                    ->numeric()
                    ->minValue(1), // Validasi Minimal 1 Tahun
                Select::make('status')
                    ->label('Status Aset')
                    ->options([
                        'active' => 'Aktif Digunakan',
                        'maintenance' => 'Dalam Perbaikan',
                        'retired' => 'Tidak Digunakan',
                    ])
                    ->required()
                    ->default('active'),
            ]);
    }
}
