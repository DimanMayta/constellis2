<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class VisitorChart extends ChartWidget
{
    protected static ?string $heading = 'Visitors — Last 14 Days';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '60s';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $days = collect();
        $pageViews = collect();
        $uniqueVisitors = collect();

        for ($i = 13; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $days->push($date->format('M d'));

            $pageViews->push(
                Visitor::whereDate('created_at', $date)->count()
            );

            $uniqueVisitors->push(
                Visitor::whereDate('created_at', $date)->distinct('ip_address')->count('ip_address')
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Page Views',
                    'data' => $pageViews->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Unique Visitors',
                    'data' => $uniqueVisitors->toArray(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $days->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
