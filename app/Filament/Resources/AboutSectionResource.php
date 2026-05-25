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

                        // --- Mission: single image EN + ES ---
                        Forms\Components\FileUpload::make('image')
                            ->label('Section Image (English)')
                            ->directory('about-sections')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('The image shown below the Mission text.')
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'mission')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image_es')
                            ->label('Section Image (Spanish) — Optional')
                            ->helperText('If set, this image will show when the site is in Spanish. Leave empty to use the same image.')
                            ->directory('about-sections')
                            ->previewable(false)
                            ->deletable()
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'mission')
                            ->columnSpanFull(),

                        // --- Vision: carousel positions ---
                        Forms\Components\Placeholder::make('vision_carousel_info')
                            ->label('🖼️ Vision Carousel — English Images (fixed)')
                            ->content(new \Illuminate\Support\HtmlString(
                                '<div style="display:flex;gap:24px;flex-wrap:wrap;">' .
                                '<div style="text-align:center;"><strong>Position 1</strong><br><img src="' . asset('images/carrusel7.png') . '" style="width:180px;height:100px;object-fit:cover;border-radius:8px;border:2px solid #cbd5e1;" /><br><span style="font-size:12px;color:#64748b;">carrusel7.png</span></div>' .
                                '<div style="text-align:center;"><strong>Position 2</strong><br><img src="' . asset('images/carrusel8.png') . '" style="width:180px;height:100px;object-fit:cover;border-radius:8px;border:2px solid #cbd5e1;" /><br><span style="font-size:12px;color:#64748b;">carrusel8.png</span></div>' .
                                '<div style="text-align:center;"><strong>Position 3</strong><br><img src="' . asset('images/carrusel6.png') . '" style="width:180px;height:100px;object-fit:cover;border-radius:8px;border:2px solid #cbd5e1;" /><br><span style="font-size:12px;color:#64748b;">carrusel6.png</span></div>' .
                                '</div>'
                            ))
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'vision')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('carousel_images_es')
                            ->label('🇪🇸 Spanish Carousel Images (upload in same order: Position 1, 2, 3)')
                            ->helperText('Upload 3 images in the same order as above. Drag to reorder. When the site is in Spanish, these replace the English carousel.')
                            ->directory('about-sections/vision-es')
                            ->previewable(false)
                            ->deletable()
                            ->multiple()
                            ->reorderable()
                            ->maxFiles(3)
                            ->visible(fn (Forms\Get $get) => $get('tab_key') === 'vision')
                            ->columnSpanFull(),

                        // --- Who We Are: inline carousel ---
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

                Forms\Components\Section::make('Image Caption')
                    ->description('Text that appears over the image/carousel at the bottom')
                    ->schema([
                        Forms\Components\TextInput::make('caption_en')
                            ->label('Caption (English)')
                            ->placeholder('e.g. Transforming nations through development, opportunity, and global collaboration.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('caption_es')
                            ->label('Caption (Spanish)')
                            ->placeholder('e.g. Transformando naciones a través del desarrollo, la oportunidad y la colaboración global.')
                            ->maxLength(255),
                    ])
                    ->visible(fn (Forms\Get $get) => in_array($get('tab_key'), ['vision', 'mission']))
                    ->columns(1),
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
