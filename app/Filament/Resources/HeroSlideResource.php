<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Hero Slides';
    protected static ?string $modelLabel = 'Hero Slide';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Slide Configuration')
                    ->description('Configure the hero carousel slide')
                    ->schema([
                        Forms\Components\FileUpload::make('bg_image')
                            ->label('Background Image (English)')
                            ->directory('slides')
                            ->previewable(false)
                            ->deletable()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('bg_image_es')
                            ->label('Background Image (Spanish) — Optional')
                            ->helperText('If set, this image will show when the site is in Spanish. Leave empty to use the same image for both languages.')
                            ->directory('slides')
                            ->previewable(false)
                            ->deletable()
                            ->columnSpanFull(),

                        Forms\Components\ViewField::make('bg_position')
                            ->view('filament.forms.image-position-editor')
                            ->default(50)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('cta_link')
                            ->label('CTA Link')
                            ->options([
                                'Homepage Sections' => [
                                    '#about' => 'About Us',
                                    '#services' => 'Services',
                                    '#opportunities' => 'Opportunities',
                                    '#events' => 'Events',
                                    '#testimonials' => 'Testimonials',
                                    '#clients' => 'Clients',
                                    '#contact' => 'Contact',
                                ],
                                'Pages' => [
                                    '/careers' => 'Careers',
                                    '/store/login' => 'Store',
                                    '/about/leadership' => 'Leadership',
                                    '/about/history' => 'History',
                                    '/about/divisions' => 'Divisions',
                                    '/about/ethics' => 'Ethics',
                                    '/services' => 'Services Page',
                                    '/news' => 'News',
                                    '/partners' => 'Partners',
                                    '/projects' => 'Projects',
                                    '/training' => 'Training',
                                    '/contracts' => 'Contracts',
                                ],
                            ])
                            ->searchable()
                            ->native(false),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\HeroSlide::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\TextInput::make('badge_en')
                            ->label('Badge')
                            ->placeholder('e.g. Global Security Solutions')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_a_en')
                            ->label('Title Line 1')
                            ->placeholder('e.g. Freedom Through')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_b_en')
                            ->label('Title Line 2 (accent color)')
                            ->placeholder('e.g. Strength')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description')
                            ->rows(2),
                        Forms\Components\TextInput::make('cta_en')
                            ->label('Button Text')
                            ->placeholder('e.g. Learn More')
                            ->maxLength(100),
                    ])->columns(2),

                Forms\Components\Section::make('Spanish Content')
                    ->schema([
                        Forms\Components\TextInput::make('badge_es')
                            ->label('Badge')
                            ->placeholder('e.g. Soluciones de Seguridad Global')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_a_es')
                            ->label('Title Line 1')
                            ->placeholder('e.g. Libertad A Través')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_b_es')
                            ->label('Title Line 2 (accent color)')
                            ->placeholder('e.g. De La Fuerza')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_es')
                            ->label('Description')
                            ->rows(2),
                        Forms\Components\TextInput::make('cta_es')
                            ->label('Button Text')
                            ->placeholder('e.g. Más Información')
                            ->maxLength(100),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('bg_image')
                    ->label('Image')
                    ->disk('public')
                    ->height(60)
                    ->width(107)
                    ->rounded(),
                Tables\Columns\TextColumn::make('badge_en')
                    ->label('Badge')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('title_a_en')
                    ->label('Title')
                    ->formatStateUsing(fn ($record) => $record->title_a_en . ' ' . $record->title_b_en)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_link')
                    ->label('Link')
                    ->badge()
                    ->color('gray'),
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
