<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrLinkResource\Pages;
use App\Models\QrLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;

class QrLinkResource extends Resource
{
    protected static ?string $model = QrLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';
    protected static ?string $navigationLabel = 'Manage QR Links';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Input Nama Link
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                // Input URL Tujuan
                TextInput::make('target_url')
                    ->label('Destination URL')
                    ->url()
                    ->required()
                    ->columnSpanFull() // Agar lebar full
                    ->placeholder('https://example.com'),

                // Input Slug (Otomatis terisi acak, tapi bisa diedit)
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => Str::random(6)) // Generate 6 karakter acak
                    ->label('Unique Code'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom 1: Nama Link
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                // Kolom 2: Target URL (Disingkat agar rapi)
                TextColumn::make('target_url')
                    ->limit(30)
                    ->icon('heroicon-m-link'),

                // Kolom 3: Counter Scan
                TextColumn::make('visit_count')
                    ->label('Scans')
                    ->sortable()
                    ->alignCenter()
                    ->badge(),

                
            ])
            ->filters([
                //
            ])
            ->actions([
    Tables\Actions\EditAction::make(),
    
    // Tambahkan Action Custom ini:
    Tables\Actions\Action::make('qr_code')
        ->label('Scan')
        ->icon('heroicon-o-qr-code')
        ->modalHeading('Scan QR Code')
        ->modalSubmitAction(false) // Hilangkan tombol submit
        ->modalCancelAction(false) // Hilangkan tombol cancel
        ->modalContent(fn (QrLink $record) => view('filament.columns.qr-code', ['getRecord' => fn() => $record])),
        
    Tables\Actions\DeleteAction::make(),
])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQrLinks::route('/'),
            'create' => Pages\CreateQrLink::route('/create'),
            'edit' => Pages\EditQrLink::route('/{record}/edit'),
        ];
    }
}