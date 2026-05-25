<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageEventResource\Pages;
use App\Models\HomepageEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageEventResource extends Resource
{
    protected static ?string $model = HomepageEvent::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Relevant Events';
    protected static ?string $modelLabel = 'Event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event Details')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Name (Spanish)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emoji')
                            ->label('Country Emoji')
                            ->placeholder('🇺🇦')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('gradient_classes')
                            ->label('Gradient CSS Classes')
                            ->placeholder('bg-gradient-to-br from-blue-600 to-yellow-400')
                            ->default('bg-gradient-to-br from-slate-700 to-slate-500')
                            ->helperText('Tailwind gradient classes for the card background')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\HomepageEvent::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Media Content')
                    ->description('Add a YouTube video, uploaded video/image to display when clicking this event card.')
                    ->schema([
                        Forms\Components\Select::make('media_type')
                            ->label('Media Type')
                            ->options([
                                'none' => 'None',
                                'youtube' => 'YouTube Video',
                                'video' => 'Uploaded Video',
                                'image' => 'Uploaded Image',
                            ])
                            ->default('none')
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('media_url', null))
                            ->columnSpanFull(),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('media_url')
                                    ->label('YouTube URL')
                                    ->placeholder('https://www.youtube.com/watch?v=XXXXX')
                                    ->helperText('Paste a full YouTube URL (e.g. https://www.youtube.com/watch?v=... or https://youtu.be/...)'),
                            ])
                            ->visible(fn (Forms\Get $get) => $get('media_type') === 'youtube')
                            ->columnSpanFull(),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\FileUpload::make('media_url')
                                    ->label(fn (Forms\Get $get) => $get('media_type') === 'video' ? 'Upload Video' : 'Upload Image')
                                    ->directory(fn (Forms\Get $get) => $get('media_type') === 'video' ? 'events/videos' : 'events/images')
                                    ->previewable(false)
                                    ->deletable()
                                    ->helperText(fn (Forms\Get $get) => $get('media_type') === 'video'
                                        ? 'Upload MP4, WebM, or OGG video'
                                        : 'Upload JPG, PNG, WebP, or GIF image'),
                            ])
                            ->visible(fn (Forms\Get $get) => in_array($get('media_type'), ['video', 'image']))
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Card Thumbnail')
                    ->description('Upload a custom image to display on the event card. If set, this image will be shown instead of the auto-generated video/YouTube thumbnail.')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail_image')
                            ->label('Thumbnail Image')
                            ->directory('events/thumbnails')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a JPG, PNG, or WebP image to use as the card preview. The video will still play when clicked.'),
                    ])
                    ->visible(fn (Forms\Get $get) => in_array($get('media_type'), ['youtube', 'video']))
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('emoji')
                    ->label('')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_es')
                    ->label('Name (ES)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gradient_classes')
                    ->label('Gradient')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('media_type')
                    ->label('Media')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'youtube' => 'danger',
                        'video' => 'info',
                        'image' => 'success',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListHomepageEvents::route('/'),
            'create' => Pages\CreateHomepageEvent::route('/create'),
            'edit' => Pages\EditHomepageEvent::route('/{record}/edit'),
        ];
    }
}
