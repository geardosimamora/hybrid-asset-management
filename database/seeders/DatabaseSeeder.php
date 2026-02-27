<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert User (Admin)
        $userId = DB::table('users')->insertGetId([
            'name' => 'Geardo Admin',
            'email' => 'admin@hybridasset.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Insert Categories
        $catIT = Str::uuid()->toString();
        $catKendaraan = Str::uuid()->toString();
        
        DB::table('categories')->insert([
            ['id' => $catIT, 'name' => 'IT Equipment', 'created_at' => now()],
            ['id' => $catKendaraan, 'name' => 'Kendaraan Dinas', 'created_at' => now()],
        ]);

        // 3. Insert Locations
        $locGudang = Str::uuid()->toString();
        $locOperasional = Str::uuid()->toString();

        DB::table('locations')->insert([
            ['id' => $locGudang, 'name' => 'Gudang Utama', 'building' => 'Gedung A', 'created_at' => now()],
            ['id' => $locOperasional, 'name' => 'Ruang Operasional', 'building' => 'Gedung B', 'created_at' => now()],
        ]);

        // 4. Insert Assets
        $asset1 = Str::uuid()->toString(); // Server
        $asset2 = Str::uuid()->toString(); // Mobil Dinas

        DB::table('assets')->insert([
            [
                'id' => $asset1,
                'asset_code' => 'IT-2023-001',
                'name' => 'Server Dell PowerEdge',
                'category_id' => $catIT,
                'location_id' => $locOperasional,
                'purchase_price' => 150000000.00, // 150 Juta
                'purchase_date' => Carbon::now()->subYears(2)->format('Y-m-d'), // Beli 2 tahun lalu
                'useful_life_years' => 5, // Umur 5 tahun
                'status' => 'active',
                'created_at' => now(),
            ],
            [
                'id' => $asset2,
                'asset_code' => 'KND-2025-001',
                'name' => 'Toyota Hilux Double Cabin',
                'category_id' => $catKendaraan,
                'location_id' => $locGudang,
                'purchase_price' => 450000000.00, // 450 Juta
                'purchase_date' => Carbon::now()->subMonths(6)->format('Y-m-d'), // Beli 6 bulan lalu
                'useful_life_years' => 10, // Umur 10 tahun
                'status' => 'maintenance',
                'created_at' => now(),
            ]
        ]);

        // 5. Insert Asset Movements (Riwayat)
        DB::table('asset_movements')->insert([
            [
                'id' => Str::uuid()->toString(),
                'asset_id' => $asset1,
                'moved_by' => $userId,
                'from_location_id' => $locGudang,
                'to_location_id' => $locOperasional,
                'moved_at' => Carbon::now()->subMonths(10),
                'notes' => 'Pemasangan server baru di ruang operasional',
                'created_at' => now(),
            ]
        ]);
    }
}