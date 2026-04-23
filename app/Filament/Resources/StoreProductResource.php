<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreProductResource\Pages;
use App\Models\StoreProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoreProductResource extends Resource
{
    protected static ?string $model = StoreProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Store';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return (string) StoreProduct::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'sku', 'description'];
    }

    // ═══════════════════════════════════════════
    // FORM (Create / Edit)
    // ═══════════════════════════════════════════

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Product Information ──
                Forms\Components\Section::make('Product Information')
                    ->description('Basic product details and pricing.')
                    ->icon('heroicon-o-shopping-bag')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. NSG Tactical Polo')
                                ->prefixIcon('heroicon-o-shopping-bag')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                    if ($state) {
                                        $slug = Str::slug($state);
                                        $set('slug', $slug);
                                        // Auto-generate SKU: NSG-SLUG-XXX
                                        $skuBase = 'NSG-' . Str::upper(Str::limit(Str::slug($state, '-'), 10, ''));
                                        $nextNum = (StoreProduct::where('sku', 'like', $skuBase . '-%')->count()) + 1;
                                        $set('sku', $skuBase . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT));
                                    }
                                }),

                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->prefixIcon('heroicon-o-link')
                                ->readOnly()
                                ->helperText('Auto-generated from name.'),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('store_category_id')
                                ->relationship('category', 'name')
                                ->required()
                                ->native(false)
                                ->prefixIcon('heroicon-o-tag')
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                    Forms\Components\TextInput::make('slug')->required(),
                                    Forms\Components\Toggle::make('is_active')->default(true),
                                ])
                                ->searchable()
                                ->preload(),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->maxLength(100)
                                ->placeholder('Auto-generated from name')
                                ->prefixIcon('heroicon-o-qr-code')
                                ->helperText('Auto-generated. Editable if needed.'),

                            Forms\Components\TextInput::make('sort_order')
                                ->numeric()
                                ->default(fn () => (StoreProduct::max('sort_order') ?? 0) + 1)
                                ->prefixIcon('heroicon-o-arrows-up-down')
                                ->helperText('Auto-incremented.'),
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(2000)
                            ->placeholder('Product description...')
                            ->columnSpanFull(),
                    ]),

                // ── Pricing & Inventory ──
                Forms\Components\Section::make('Pricing & Inventory')
                    ->description('Set the price and stock levels.')
                    ->icon('heroicon-o-currency-dollar')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->prefix('$')
                                ->required()
                                ->minValue(0)
                                ->step(0.01)
                                ->placeholder('0.00')
                                ->prefixIcon('heroicon-o-currency-dollar'),

                            Forms\Components\TextInput::make('inventory')
                                ->numeric()
                                ->default(0)
                                ->minValue(0)
                                ->prefixIcon('heroicon-o-archive-box')
                                ->helperText('0 = Out of stock'),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->helperText('Show in store')
                                ->onColor('success')
                                ->offColor('danger')
                                ->inline(false),
                        ]),
                    ]),

                // ── Variants & Media ──
                Forms\Components\Section::make('Variants & Media')
                    ->description('Product sizes, colors, and images.')
                    ->icon('heroicon-o-swatch')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TagsInput::make('sizes')
                                ->placeholder('Add size (e.g. S, M, L, XL)')
                                ->helperText('Press Enter to add each size.'),

                            Forms\Components\TagsInput::make('colors')
                                ->placeholder('Add color (e.g. Black, Navy)')
                                ->helperText('Press Enter to add each color.'),
                        ]),

                        Forms\Components\FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('store/products')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->maxFiles(6)
                            ->reorderable()
                            ->appendFiles()
                            ->previewable(false)
                            ->deletable()
                            ->columnSpanFull()
                            ->helperText('Upload up to 6 product images (max 5MB each).'),
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
                Tables\Columns\ImageColumn::make('images')
                    ->label('Photo')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=P&background=1d345d&color=fff')
                    ->width(40)
                    ->height(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (StoreProduct $record): string => $record->sku ?? '—'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-tag'),

                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('inventory')
                    ->label('Stock')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match(true) {
                        $state <= 0 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success',
                    })
                    ->icon(fn (int $state): string => match(true) {
                        $state <= 0 => 'heroicon-o-x-circle',
                        $state <= 5 => 'heroicon-o-exclamation-triangle',
                        default => 'heroicon-o-check-circle',
                    })
                    ->formatStateUsing(fn (int $state): string => $state <= 0 ? 'Out of Stock' : $state . ' units'),

                Tables\Columns\TextColumn::make('sizes')
                    ->label('Sizes')
                    ->badge()
                    ->color('gray')
                    ->separator(',')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('store_category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('out_of_stock')
                    ->label('Out of Stock')
                    ->query(fn ($query) => $query->where('inventory', '<=', 0))
                    ->toggle(),

                Tables\Filters\Filter::make('low_stock')
                    ->label('Low Stock (≤ 5)')
                    ->query(fn ($query) => $query->where('inventory', '>', 0)->where('inventory', '<=', 5))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (StoreProduct $record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->icon(fn (StoreProduct $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn (StoreProduct $record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn (StoreProduct $record) => $record->update(['is_active' => !$record->is_active])),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreProducts::route('/'),
            'create' => Pages\CreateStoreProduct::route('/create'),
            'edit' => Pages\EditStoreProduct::route('/{record}/edit'),
        ];
    }
}
