<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportedProjectResource\Pages;
use App\Models\SupportedProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupportedProjectResource extends Resource
{
    protected static ?string $model = SupportedProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Projects We Support';
    protected static ?string $modelLabel = 'Supported Project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Details')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. All Secure Foundation'),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Name (Spanish)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Fundación All Secure'),
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(3)
                            ->placeholder('Brief description of the organization...'),
                        Forms\Components\Textarea::make('description_es')
                            ->label('Description (Spanish)')
                            ->rows(3)
                            ->placeholder('Breve descripción de la organización...'),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Link')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Upload Image')
                            ->directory('supported-projects')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a JPG/PNG image. If upload fails, use the URL field below instead.'),
                        Forms\Components\TextInput::make('image_url')
                            ->label('Or paste Image URL')
                            ->url()
                            ->placeholder('https://example.org/logo.png')
                            ->helperText('Alternative: paste an external image URL here.'),
                        Forms\Components\TextInput::make('website_url')
                            ->label('Website URL')
                            ->url()
                            ->placeholder('https://www.example.org/'),
                    ])->columns(1),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\SupportedProject::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('name_es')
                    ->label('Name (ES)')
                    ->searchable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('website_url')
                    ->label('Website')
                    ->limit(40)
                    ->url(fn ($record) => $record->website_url, shouldOpenInNewTab: true),
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
            'index' => Pages\ListSupportedProjects::route('/'),
            'create' => Pages\CreateSupportedProject::route('/create'),
            'edit' => Pages\EditSupportedProject::route('/{record}/edit'),
        ];
    }
}
