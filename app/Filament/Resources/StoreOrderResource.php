<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreOrderResource\Pages;
use App\Models\StoreOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreOrderResource extends Resource
{
    protected static ?string $model = StoreOrder::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Store';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Order Details')->schema([
                Forms\Components\TextInput::make('order_number')->disabled(),
                Forms\Components\Select::make('user_id')->relationship('user', 'name')->disabled(),
                Forms\Components\Select::make('status')->options([
                    'pending' => 'Pending', 'processing' => 'Processing',
                    'shipped' => 'Shipped', 'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ])->required(),
                Forms\Components\TextInput::make('subtotal')->disabled()->prefix('$'),
                Forms\Components\TextInput::make('tax')->disabled()->prefix('$'),
                Forms\Components\TextInput::make('total')->disabled()->prefix('$'),
                Forms\Components\Textarea::make('shipping_address')->disabled()->columnSpanFull(),
                Forms\Components\Textarea::make('notes')->rows(2)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
            Tables\Columns\TextColumn::make('total')->money('usd')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state) => match($state) {
                'pending' => 'warning', 'processing' => 'info',
                'shipped' => 'primary', 'delivered' => 'success',
                'cancelled' => 'danger', default => 'gray',
            }),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date'),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreOrders::route('/'),
            'edit' => Pages\EditStoreOrder::route('/{record}/edit'),
        ];
    }
}
