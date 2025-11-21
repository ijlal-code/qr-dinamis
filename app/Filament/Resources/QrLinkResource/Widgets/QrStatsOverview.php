<?php

namespace App\Filament\Resources\QrLinkResource\Widgets;

use App\Models\QrVisit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QrStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Scans All Time', QrVisit::count())
                ->description('Total interactions')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy chart background kecil

            Stat::make('Scans Today', QrVisit::whereDate('created_at', today())->count())
                ->description('Real-time visits')
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Most Popular OS', QrVisit::select('os')
                ->groupBy('os')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(1)
                ->value('os') ?? 'N/A')
                ->description('Dominant Platform')
                ->color('warning'),
        ];
    }
}