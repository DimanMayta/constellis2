<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionCategoryResource\Pages;
use App\Models\PositionCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PositionCategoryResource extends Resource
{
    protected static ?string $model = PositionCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Position Categories';
    protected static ?string $pluralModelLabel = 'Position Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Position Category')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Name (Spanish)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('icon_svg')
                            ->label('Icon SVG Path')
                            ->rows(2)
                            ->default('M13 10V3L4 14h7v7l9-11h-7z')
                            ->helperText('SVG path data (d attribute). Has a default icon.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (PositionCategory::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Upload Image')
                            ->directory('position-categories')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a JPG/PNG image. If upload fails, use the URL field below instead.'),
                        Forms\Components\TextInput::make('image_url')
                            ->label('Or paste Image URL')
                            ->url()
                            ->placeholder('https://example.org/image.png')
                            ->helperText('Alternative: paste an external image URL here.'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_es')
                    ->label('Name (ES)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositionCategories::route('/'),
            'create' => Pages\CreatePositionCategory::route('/create'),
            'edit' => Pages\EditPositionCategory::route('/{record}/edit'),
        ];
    }
}
