<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $modelLabel = 'About Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section Configuration')
                    ->schema([
                        Forms\Components\Select::make('tab_key')
                            ->label('Tab')
                            ->options([
                                'who' => 'Who We Are',
                                'vision' => 'Vision',
                                'mission' => 'Mission',
                            ])
                            ->required()
                            ->live(),
                        Forms\Components\TextInput::make('label_en')
                            ->label('Tab Label (EN)')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('label_es')
                            ->label('Tab Label (ES)')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\AboutSection::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Media')
                    ->description('Upload images and videos for this section')
                    ->schema([
                        Forms\Components\TextInput::make('video_url')
                            ->label('YouTube Video URL')
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Used for "Who We Are" tab — the video shown below the text.')
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'who')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Section Image')
                            ->directory('about-sections')
                            ->previewable(false)
                            ->deletable()
                            ->helperText(fn (Forms\Get $get) => match($get('tab_key')) {
                                'vision' => 'The image shown below the Vision text.',
                                'mission' => 'The image shown below the Mission text.',
                                default => 'Section image.',
                            })
                            ->visible(fn (Forms\Get $get) => in_array($get('tab_key'), ['vision', 'mission']))
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('carousel_images')
                            ->label('Carousel Images')
                            ->directory('about-sections/who')
                            ->previewable(false)
                            ->deletable()
                            ->multiple()
                            ->reorderable()
                            ->helperText('Upload multiple images for the "Who We Are" inline carousel. You can drag to reorder.')
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'who')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content_en')
                            ->label('Content (English)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Spanish Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content_es')
                            ->label('Content (Spanish)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tab_key')
                    ->label('Tab')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'who' => 'info',
                        'vision' => 'success',
                        'mission' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'who' => 'Who We Are',
                        'vision' => 'Vision',
                        'mission' => 'Mission',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('label_en')
                    ->label('Label (EN)'),
                Tables\Columns\TextColumn::make('label_es')
                    ->label('Label (ES)'),
                Tables\Columns\TextColumn::make('video_url')
                    ->label('Video')
                    ->limit(30)
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
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
