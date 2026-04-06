<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisitorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $todayCount = Visitor::today()->count();
        $todayUnique = Visitor::today()->distinct('ip_address')->count('ip_address');
        $weekCount = Visitor::thisWeek()->count();
        $monthCount = Visitor::thisMonth()->count();

        // Calculate trend (compare today vs yesterday)
        $yesterdayCount = Visitor::whereDate('created_at', today()->subDay())->count();
        $trend = $yesterdayCount > 0
            ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100, 1)
            : ($todayCount > 0 ? 100 : 0);

        // Top country today
        $topCountry = Visitor::today()
            ->whereNotNull('country')
            ->where('country', '!=', 'Local')
            ->selectRaw('country, count(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->first();

        // Top browser today
        $topBrowser = Visitor::today()
            ->whereNotNull('browser')
            ->selectRaw('browser, count(*) as total')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->first();

        // Avg response time today
        $avgResponseTime = Visitor::today()->avg('response_time');

        return [
            Stat::make('Today\'s Visits', number_format($todayCount))
                ->description($trend >= 0 ? "+{$trend}% vs yesterday" : "{$trend}% vs yesterday")
                ->descriptionIcon($trend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($trend >= 0 ? 'success' : 'danger')
                ->chart($this->getLast7DaysCounts()),

            Stat::make('Unique Visitors Today', number_format($todayUnique))
                ->description('Distinct IPs')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),

            Stat::make('This Week', number_format($weekCount))
                ->description('Page views')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('This Month', number_format($monthCount))
                ->description('Page views')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            Stat::make('Top Country', $topCountry?->country ?? '—')
                ->description($topCountry ? "{$topCountry->total} visits" : 'No data')
                ->descriptionIcon('heroicon-m-flag')
                ->color('success'),

            Stat::make('Avg Response', $avgResponseTime ? round($avgResponseTime) . ' ms' : '—')
                ->description($topBrowser ? "Top: {$topBrowser->browser}" : 'No data')
                ->descriptionIcon('heroicon-m-clock')
                ->color($avgResponseTime && $avgResponseTime > 1000 ? 'warning' : 'success'),
        ];
    }

    protected function getLast7DaysCounts(): array
    {
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $counts[] = Visitor::whereDate('created_at', today()->subDays($i))->count();
        }
        return $counts;
    }
}
