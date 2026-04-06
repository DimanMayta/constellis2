<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;

class UsersTableWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'System Users';

    protected static ?string $pollingInterval = '30s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->where('is_active', true)->orderByDesc('last_seen_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('employee_code')
                    ->label('Code')
                    ->sortable()
                    ->placeholder('—')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'employee' => 'info',
                        'contractor' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('department')
                    ->label('Department')
                    ->sortable()
                    ->placeholder('—')
                    ->icon('heroicon-o-building-office'),

                Tables\Columns\TextColumn::make('access_level')
                    ->label('Access')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'full' => 'danger',
                        'elevated' => 'warning',
                        'basic' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_seen_at')
                    ->label('Last Seen')
                    ->sortable()
                    ->since()
                    ->placeholder('Never')
                    ->color(fn ($state) => $state && Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'success' : 'gray')
                    ->icon(fn ($state) => $state && Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'heroicon-o-signal' : 'heroicon-o-signal-slash')
                    ->description(fn ($state) => $state && Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'Online' : null),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date('M d, Y')
                    ->sortable()
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                        'contractor' => 'Contractor',
                    ]),
                Tables\Filters\SelectFilter::make('access_level')
                    ->label('Access Level')
                    ->options([
                        'full' => 'Full',
                        'elevated' => 'Elevated',
                        'basic' => 'Basic',
                    ]),
            ])
            ->defaultSort('last_seen_at', 'desc')
            ->striped()
            ->paginated([5, 10, 25]);
    }
}
