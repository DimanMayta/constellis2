<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreCategoryResource\Pages;
use App\Models\StoreCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StoreCategoryResource extends Resource
{
    protected static ?string $model = StoreCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $navigationGroup = 'Store';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return (string) StoreCategory::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    // ═══════════════════════════════════════════
    // FORM (Create / Edit)
    // ═══════════════════════════════════════════

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->description('Configure the store category information.')
                    ->icon('heroicon-o-tag')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('e.g. Apparel, Gear & Equipment')
                                ->prefixIcon('heroicon-o-tag')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->prefixIcon('heroicon-o-link')
                                ->helperText('Auto-generated from name.'),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('icon')
                                ->maxLength(255)
                                ->placeholder('e.g. heroicon-o-shopping-bag')
                                ->prefixIcon('heroicon-o-sparkles')
                                ->helperText('Heroicon name for the category icon.'),

                            Forms\Components\TextInput::make('sort_order')
                                ->numeric()
                                ->default(fn () => (StoreCategory::max('sort_order') ?? 0) + 1)
                                ->prefixIcon('heroicon-o-arrows-up-down')
                                ->helperText('Lower number = appears first.'),
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('Brief description of this category...')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive categories are hidden from the store.')
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (StoreCategory $record): string => $record->description ?? '—')
                    ->icon('heroicon-o-tag'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-shopping-bag'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (StoreCategory $record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->icon(fn (StoreCategory $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn (StoreCategory $record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn (StoreCategory $record) => $record->update(['is_active' => !$record->is_active])),
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
            'index' => Pages\ListStoreCategories::route('/'),
            'create' => Pages\CreateStoreCategory::route('/create'),
            'edit' => Pages\EditStoreCategory::route('/{record}/edit'),
        ];
    }
}
