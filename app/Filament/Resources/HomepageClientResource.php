<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageClientResource\Pages;
use App\Models\HomepageClient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageClientResource extends Resource
{
    protected static ?string $model = HomepageClient::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Our Partners';
    protected static ?string $modelLabel = 'Client';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Client Details')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                $set('name', $state);
                            })
                            ->placeholder('e.g. Special Operations Command (SOCOM)'),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Name (Spanish)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Comando de Operaciones Especiales (SOCOM)'),
                        Forms\Components\Hidden::make('name'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\HomepageClient::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Upload Image')
                            ->directory('homepage-clients')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a JPG/PNG image. If upload fails, use the URL field below instead.'),
                        Forms\Components\TextInput::make('image_url')
                            ->label('Or paste Image URL')
                            ->url()
                            ->placeholder('https://example.org/logo.png')
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
                    ->sortable()
                    ->limit(60),
                Tables\Columns\TextColumn::make('name_es')
                    ->label('Name (ES)')
                    ->searchable()
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListHomepageClients::route('/'),
            'create' => Pages\CreateHomepageClient::route('/create'),
            'edit' => Pages\EditHomepageClient::route('/{record}/edit'),
        ];
    }
}
