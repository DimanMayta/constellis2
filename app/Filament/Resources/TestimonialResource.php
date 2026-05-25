<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Testimonials';
    protected static ?string $modelLabel = 'Testimonial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Testimonial Details')
                    ->schema([
                        Forms\Components\TextInput::make('country_en')
                            ->label('Country (English)')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('country_es')
                            ->label('Country (Spanish)')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('country_emoji')
                            ->label('Country Emoji')
                            ->placeholder('🇦🇫')
                            ->maxLength(10),
                    ])->columns(3),

                Forms\Components\Section::make('Author & Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Testimonial Image')
                            ->directory('testimonials')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a photo related to this testimonial.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('author_name')
                            ->label('Author Name')
                            ->placeholder('e.g. John Doe')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('author_role_en')
                            ->label('Author Role (English)')
                            ->placeholder('e.g. Former Military Advisor')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('author_role_es')
                            ->label('Author Role (Spanish)')
                            ->placeholder('e.g. Ex Asesor Militar')
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Video (Optional)')
                    ->description('Add a video file or a YouTube URL. If both are provided, the uploaded video takes priority.')
                    ->schema([
                        Forms\Components\FileUpload::make('video')
                            ->label('Upload Video File')
                            ->directory('testimonials/videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(102400) // 100MB
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Max 100MB. Supports MP4, WebM, MOV.'),
                        Forms\Components\TextInput::make('video_url')
                            ->label('YouTube Video URL')
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->url()
                            ->helperText('Paste a YouTube URL. Supports standard, short, and Shorts links.'),
                    ])->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\Testimonial::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content_en')
                            ->label('Testimonial Content (English)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Spanish Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content_es')
                            ->label('Testimonial Content (Spanish)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Photo')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('country_emoji')
                    ->label('')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('country_en')
                    ->label('Country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content_en')
                    ->label('Content Preview')
                    ->html()
                    ->limit(80),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
