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
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\Testimonial::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

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
