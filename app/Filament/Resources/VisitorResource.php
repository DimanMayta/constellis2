<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorResource\Pages;
use App\Models\Visitor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Visitor Log';

    protected static ?string $modelLabel = 'Visitor';

    protected static ?string $pluralModelLabel = 'Visitors';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Request Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('url')
                            ->label('URL')
                            ->columnSpanFull()
                            ->copyable(),
                        Infolists\Components\TextEntry::make('method')
                            ->badge()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('status_code')
                            ->badge()
                            ->color(fn ($state) => match (true) {
                                $state >= 500 => 'danger',
                                $state >= 400 => 'warning',
                                $state >= 300 => 'info',
                                default => 'success',
                            }),
                        Infolists\Components\TextEntry::make('response_time')
                            ->suffix(' ms')
                            ->color(fn ($state) => match (true) {
                                $state > 3000 => 'danger',
                                $state > 1000 => 'warning',
                                default => 'success',
                            }),
                        Infolists\Components\TextEntry::make('referrer')
                            ->placeholder('Direct')
                            ->copyable(),
                    ])->columns(3),

                Infolists\Components\Section::make('Visitor Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->copyable()
                            ->icon('heroicon-o-globe-alt'),
                        Infolists\Components\TextEntry::make('country')
                            ->icon('heroicon-o-flag')
                            ->placeholder('Unknown'),
                        Infolists\Components\TextEntry::make('city')
                            ->icon('heroicon-o-map-pin')
                            ->placeholder('Unknown'),
                        Infolists\Components\TextEntry::make('region')
                            ->placeholder('Unknown'),
                    ])->columns(4),

                Infolists\Components\Section::make('Device & Browser')
                    ->schema([
                        Infolists\Components\TextEntry::make('browser')
                            ->icon('heroicon-o-window'),
                        Infolists\Components\TextEntry::make('browser_version')
                            ->label('Version'),
                        Infolists\Components\TextEntry::make('platform')
                            ->icon('heroicon-o-computer-desktop'),
                        Infolists\Components\TextEntry::make('device_type')
                            ->label('Device')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'desktop' => 'info',
                                'mobile' => 'success',
                                'tablet' => 'warning',
                                'bot' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(4),

                Infolists\Components\Section::make('Raw User Agent')
                    ->schema([
                        Infolists\Components\TextEntry::make('user_agent')
                            ->columnSpanFull()
                            ->copyable(),
                    ])->collapsed(),

                Infolists\Components\Section::make('Session')
                    ->schema([
                        Infolists\Components\TextEntry::make('session_id')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Authenticated User')
                            ->placeholder('Guest'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Visited At'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M d, H:i:s')
                    ->sortable()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->copyable()
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->icon('heroicon-o-flag')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('url')
                    ->label('Page')
                    ->searchable()
                    ->limit(45)
                    ->tooltip(fn ($record) => $record->url)
                    ->formatStateUsing(function (string $state) {
                        $parsed = parse_url($state);
                        return ($parsed['path'] ?? '/') . (isset($parsed['query']) ? '?' . $parsed['query'] : '');
                    }),
                Tables\Columns\TextColumn::make('browser')
                    ->searchable()
                    ->icon('heroicon-o-window')
                    ->description(fn ($record) => $record->browser_version),
                Tables\Columns\TextColumn::make('platform')
                    ->searchable()
                    ->icon('heroicon-o-computer-desktop'),
                Tables\Columns\TextColumn::make('device_type')
                    ->label('Device')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'desktop' => 'info',
                        'mobile' => 'success',
                        'tablet' => 'warning',
                        'bot' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status_code')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 500 => 'danger',
                        $state >= 400 => 'warning',
                        $state >= 300 => 'info',
                        default => 'success',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('response_time')
                    ->label('Time (ms)')
                    ->numeric(0)
                    ->suffix(' ms')
                    ->sortable()
                    ->color(fn ($state) => match (true) {
                        $state > 3000 => 'danger',
                        $state > 1000 => 'warning',
                        default => 'success',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referrer')
                    ->label('Referrer')
                    ->limit(30)
                    ->placeholder('Direct')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('15s')
            ->filters([
                Tables\Filters\SelectFilter::make('device_type')
                    ->options([
                        'desktop' => 'Desktop',
                        'mobile' => 'Mobile',
                        'tablet' => 'Tablet',
                        'bot' => 'Bot',
                    ]),
                Tables\Filters\SelectFilter::make('browser')
                    ->options(fn () => Visitor::distinct()->whereNotNull('browser')->pluck('browser', 'browser')->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('platform')
                    ->options(fn () => Visitor::distinct()->whereNotNull('platform')->pluck('platform', 'platform')->toArray())
                    ->searchable(),
                Tables\Filters\SelectFilter::make('country')
                    ->options(fn () => Visitor::distinct()->whereNotNull('country')->pluck('country', 'country')->toArray())
                    ->searchable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
                Tables\Filters\TernaryFilter::make('bots')
                    ->label('Include Bots')
                    ->queries(
                        true: fn ($q) => $q,
                        false: fn ($q) => $q->where('device_type', '!=', 'bot'),
                        blank: fn ($q) => $q->where('device_type', '!=', 'bot'),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitors::route('/'),
            'view' => Pages\ViewVisitor::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::today()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
