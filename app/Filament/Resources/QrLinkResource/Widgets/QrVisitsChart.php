<?php

namespace App\Filament\Resources\QrLinkResource\Widgets;

use App\Models\QrVisit;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class QrVisitsChart extends ChartWidget
{
    protected static ?string $heading = 'Traffic Trends (Per Hour)';
    
    // Lebar widget full
    protected int | string | array $columnSpan = 'full';
    
    // Update otomatis tiap 5 detik
    protected static ?string $pollingInterval = '5s';

    protected function getData(): array
    {
        // Ambil data 24 jam terakhir
        $data = Trend::model(QrVisit::class)
            ->between(
                start: now()->startOfDay(),
                end: now()->endOfDay(),
            )
            ->perHour()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Scans',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Warna biru
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}