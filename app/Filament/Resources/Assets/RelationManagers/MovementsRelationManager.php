<?php

namespace App\Filament\Resources\Assets\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'movements';

    protected static ?string $title = 'Riwayat Pergerakan Aset';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([ // MENGGUNAKAN COMPONENTS (ATURAN BARU)
                Select::make('from_location_id')
                    ->label('Lokasi Asal')
                    ->relationship('fromLocation', 'name')
                    ->searchable()
                    ->required(),

                Select::make('to_location_id')
                    ->label('Pindah Ke Lokasi Tujuan')
                    ->relationship('toLocation', 'name')
                    ->searchable()
                    ->required(),

                DateTimePicker::make('moved_at')
                    ->label('Waktu Perpindahan')
                    ->default(now())
                    ->required(),

                Hidden::make('moved_by')
                    ->default(auth()->id()),

                Textarea::make('notes')
                    ->label('Catatan / Alasan Pindah')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('moved_at')
            ->columns([
                TextColumn::make('fromLocation.name')
                    ->label('Lokasi Asal')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('toLocation.name')
                    ->label('Lokasi Tujuan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mover.name')
                    ->label('Dipindahkan Oleh')
                    ->searchable(),
                TextColumn::make('moved_at')
                    ->label('Waktu Perpindahan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->defaultSort('moved_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Catat Mutasi Baru'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([ // MENGGUNAKAN TOOLBAR (ATURAN BARU)
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}