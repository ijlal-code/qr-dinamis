<?php

namespace App\Filament\Resources\QrLinkResource\Pages;

use App\Filament\Resources\QrLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQrLinks extends ListRecords
{
    protected static string $resource = QrLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Tambahkan method ini agar widget muncul di atas tabel
    protected function getHeaderWidgets(): array
    {
        return [
            QrLinkResource\Widgets\QrStatsOverview::class,
            QrLinkResource\Widgets\QrVisitsChart::class,
        ];
    }
}