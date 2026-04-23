<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreOrderResource\Pages;
use App\Models\StoreOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class StoreOrderResource extends Resource
{
    protected static ?string $model = StoreOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $navigationGroup = 'Store';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function getNavigationBadge(): ?string
    {
        $pending = StoreOrder::where('status', 'pending')->count();
        return $pending > 0 ? (string) $pending : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['order_number', 'user.name', 'user.email'];
    }

    // ═══════════════════════════════════════════
    // FORM (Edit — Orders are not created from admin)
    // ═══════════════════════════════════════════

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Order Header ──
                Forms\Components\Section::make('Order Information')
                    ->description('Core order details — most fields are read-only.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('order_number')
                                ->disabled()
                                ->prefixIcon('heroicon-o-hashtag')
                                ->dehydrated(false),

                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')
                                ->disabled()
                                ->prefixIcon('heroicon-o-user')
                                ->dehydrated(false),

                            Forms\Components\Select::make('status')
                                ->options([
                                    'pending' => '🟡 Pending',
                                    'confirmed' => '🔵 Confirmed',
                                    'processing' => '🔵 Processing',
                                    'shipped' => '📦 Shipped',
                                    'delivered' => '✅ Delivered',
                                    'cancelled' => '❌ Cancelled',
                                ])
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-o-signal'),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('subtotal')
                                ->disabled()
                                ->prefix('$')
                                ->prefixIcon('heroicon-o-currency-dollar')
                                ->dehydrated(false),

                            Forms\Components\TextInput::make('tax')
                                ->disabled()
                                ->prefix('$')
                                ->prefixIcon('heroicon-o-receipt-percent')
                                ->dehydrated(false),

                            Forms\Components\TextInput::make('total')
                                ->disabled()
                                ->prefix('$')
                                ->prefixIcon('heroicon-o-banknotes')
                                ->dehydrated(false)
                                ->extraAttributes(['class' => 'font-bold']),
                        ]),
                    ]),

                // ── Shipping ──
                Forms\Components\Section::make('Shipping & Notes')
                    ->description('Delivery address and internal notes.')
                    ->icon('heroicon-o-truck')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Textarea::make('shipping_address')
                            ->disabled()
                            ->rows(2)
                            ->columnSpanFull()
                            ->dehydrated(false),

                        Forms\Components\Textarea::make('notes')
                            ->rows(2)
                            ->maxLength(1000)
                            ->placeholder('Internal notes about this order...')
                            ->columnSpanFull()
                            ->helperText('Admin notes — visible only in the admin panel.'),
                    ]),
            ]);
    }

    // ═══════════════════════════════════════════
    // INFOLIST (View — shows order items)
    // ═══════════════════════════════════════════

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // ── Order Header ──
                Infolists\Components\Section::make('Order Information')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('order_number')
                            ->label('Order #')
                            ->badge()
                            ->color('primary')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-o-hashtag')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Customer')
                            ->icon('heroicon-o-user'),

                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'confirmed', 'processing' => 'info',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'pending' => 'heroicon-o-clock',
                                'confirmed' => 'heroicon-o-check',
                                'processing' => 'heroicon-o-cog-6-tooth',
                                'shipped' => 'heroicon-o-truck',
                                'delivered' => 'heroicon-o-check-circle',
                                'cancelled' => 'heroicon-o-x-circle',
                                default => 'heroicon-o-question-mark-circle',
                            }),
                    ]),

                // ── Financial ──
                Infolists\Components\Section::make('Financial Summary')
                    ->icon('heroicon-o-currency-dollar')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('subtotal')
                            ->money('usd')
                            ->icon('heroicon-o-calculator'),

                        Infolists\Components\TextEntry::make('tax')
                            ->money('usd')
                            ->icon('heroicon-o-receipt-percent'),

                        Infolists\Components\TextEntry::make('total')
                            ->money('usd')
                            ->weight('bold')
                            ->size('lg')
                            ->color('success')
                            ->icon('heroicon-o-banknotes'),
                    ]),

                // ── Order Items ──
                Infolists\Components\Section::make('Order Items')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        Infolists\Components\TextEntry::make('items')
                            ->label('')
                            ->formatStateUsing(function ($state) {
                                if (!is_array($state) || empty($state)) {
                                    return 'No items';
                                }

                                $html = '<div class="overflow-x-auto">';
                                $html .= '<table class="w-full text-sm">';
                                $html .= '<thead><tr class="border-b border-gray-200 dark:border-gray-700">';
                                $html .= '<th class="text-left py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Product</th>';
                                $html .= '<th class="text-center py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Size</th>';
                                $html .= '<th class="text-center py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Color</th>';
                                $html .= '<th class="text-center py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Qty</th>';
                                $html .= '<th class="text-right py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Price</th>';
                                $html .= '<th class="text-right py-2 px-3 font-semibold text-gray-600 dark:text-gray-400">Subtotal</th>';
                                $html .= '</tr></thead><tbody>';

                                foreach ($state as $item) {
                                    $name = $item['name'] ?? 'Unknown';
                                    $price = number_format($item['price'] ?? 0, 2);
                                    $qty = $item['quantity'] ?? 1;
                                    $size = $item['size'] ?? '—';
                                    $color = $item['color'] ?? '—';
                                    $subtotal = number_format(($item['price'] ?? 0) * $qty, 2);

                                    $html .= '<tr class="border-b border-gray-100 dark:border-gray-800">';
                                    $html .= "<td class='py-2 px-3 font-medium text-gray-900 dark:text-gray-100'>{$name}</td>";
                                    $html .= "<td class='py-2 px-3 text-center text-gray-500'>{$size}</td>";
                                    $html .= "<td class='py-2 px-3 text-center text-gray-500'>{$color}</td>";
                                    $html .= "<td class='py-2 px-3 text-center font-medium'>{$qty}</td>";
                                    $html .= "<td class='py-2 px-3 text-right text-gray-500'>\${$price}</td>";
                                    $html .= "<td class='py-2 px-3 text-right font-semibold text-gray-900 dark:text-gray-100'>\${$subtotal}</td>";
                                    $html .= '</tr>';
                                }

                                $html .= '</tbody></table></div>';
                                return new HtmlString($html);
                            })
                            ->html()
                            ->columnSpanFull(),
                    ]),

                // ── Shipping ──
                Infolists\Components\Section::make('Shipping & Notes')
                    ->icon('heroicon-o-truck')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('shipping_address')
                            ->label('Shipping Address')
                            ->placeholder('No address provided')
                            ->icon('heroicon-o-map-pin')
                            ->columnSpan(1),

                        Infolists\Components\TextEntry::make('notes')
                            ->placeholder('No notes')
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->columnSpan(1),
                    ]),

                // ── Timestamps ──
                Infolists\Components\Section::make('Timeline')
                    ->icon('heroicon-o-clock')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Order Placed')
                            ->dateTime('M d, Y — g:i A')
                            ->icon('heroicon-o-calendar'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->since()
                            ->icon('heroicon-o-pencil-square'),
                    ]),
            ]);
    }

    // ═══════════════════════════════════════════
    // TABLE (List)
    // ═══════════════════════════════════════════

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->copyable()
                    ->icon('heroicon-o-hashtag'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->description(fn (StoreOrder $record): string => $record->user?->email ?? '—')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('items')
                    ->label('Items')
                    ->formatStateUsing(function ($state) {
                        if (!is_array($state)) return '0';
                        $count = array_sum(array_column($state, 'quantity'));
                        return $count . ' item' . ($count !== 1 ? 's' : '');
                    })
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('total')
                    ->money('usd')
                    ->sortable()
                    ->weight('bold')
                    ->color('success')
                    ->icon('heroicon-o-banknotes'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed', 'processing' => 'info',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'confirmed' => 'heroicon-o-check',
                        'processing' => 'heroicon-o-cog-6-tooth',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y — g:i A')
                    ->sortable()
                    ->description(fn (StoreOrder $record): string => $record->created_at->diffForHumans()),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Status'),

                Tables\Filters\Filter::make('pending_only')
                    ->label('⚡ Pending Orders')
                    ->query(fn (Builder $query) => $query->where('status', 'pending'))
                    ->toggle(),

                Tables\Filters\Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query) => $query->whereDate('created_at', today()))
                    ->toggle(),

                Tables\Filters\Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query) => $query->where('created_at', '>=', now()->startOfWeek()))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('confirm')
                        ->label('Confirm')
                        ->icon('heroicon-o-check')
                        ->color('info')
                        ->requiresConfirmation()
                        ->visible(fn (StoreOrder $record) => $record->status === 'pending')
                        ->action(fn (StoreOrder $record) => $record->update(['status' => 'confirmed'])),

                    Tables\Actions\Action::make('ship')
                        ->label('Mark as Shipped')
                        ->icon('heroicon-o-truck')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->visible(fn (StoreOrder $record) => in_array($record->status, ['confirmed', 'processing']))
                        ->action(fn (StoreOrder $record) => $record->update(['status' => 'shipped'])),

                    Tables\Actions\Action::make('deliver')
                        ->label('Mark as Delivered')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (StoreOrder $record) => $record->status === 'shipped')
                        ->action(fn (StoreOrder $record) => $record->update(['status' => 'delivered'])),

                    Tables\Actions\Action::make('cancel')
                        ->label('Cancel Order')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Cancel this order?')
                        ->modalDescription('This action cannot be undone.')
                        ->visible(fn (StoreOrder $record) => !in_array($record->status, ['delivered', 'cancelled']))
                        ->action(fn (StoreOrder $record) => $record->update(['status' => 'cancelled'])),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreOrders::route('/'),
            'view' => Pages\ViewStoreOrder::route('/{record}'),
            'edit' => Pages\EditStoreOrder::route('/{record}/edit'),
        ];
    }
}
