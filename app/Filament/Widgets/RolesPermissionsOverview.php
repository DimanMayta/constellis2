<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class RolesPermissionsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = $totalUsers - $activeUsers;

        // Role counts
        $admins = User::where('role', 'admin')->where('is_active', true)->count();
        $employees = User::where('role', 'employee')->where('is_active', true)->count();
        $contractors = User::where('role', 'contractor')->where('is_active', true)->count();

        // Access level counts
        $fullAccess = User::where('access_level', 'full')->where('is_active', true)->count();
        $elevatedAccess = User::where('access_level', 'elevated')->where('is_active', true)->count();
        $basicAccess = User::where('access_level', 'basic')->where('is_active', true)->count();

        // Online now (seen in last 30 seconds)
        $onlineNow = User::where('is_active', true)
            ->where('last_seen_at', '>=', Carbon::now()->subSeconds(30))
            ->count();

        // Departments
        $departments = User::whereNotNull('department')
            ->where('is_active', true)
            ->distinct('department')
            ->count('department');

        // Newest user
        $newestUser = User::latest()->first();

        return [
            Stat::make('Total Users', $totalUsers)
                ->description("{$activeUsers} active · {$inactiveUsers} inactive")
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([$admins, $employees, $contractors]),

            Stat::make('Online Now', $onlineNow)
                ->description("{$activeUsers} total active users")
                ->descriptionIcon('heroicon-m-signal')
                ->color($onlineNow > 0 ? 'success' : 'gray'),

            Stat::make('Admins', $admins)
                ->description('Full system control')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Employees', $employees)
                ->description('Internal staff')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('info'),

            Stat::make('Contractors', $contractors)
                ->description('External access')
                ->descriptionIcon('heroicon-m-identification')
                ->color('warning'),

            Stat::make('Departments', $departments)
                ->description("Full: {$fullAccess} · Elevated: {$elevatedAccess} · Basic: {$basicAccess}")
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
        ];
    }
}
