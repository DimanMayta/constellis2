<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingCategoryResource\Pages;
use App\Models\TrainingCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TrainingCategoryResource extends Resource
{
    protected static ?string $model = TrainingCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Training';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Categories';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('description')->rows(3),
                        Forms\Components\TextInput::make('anchor_id')->maxLength(100),
                        Forms\Components\TextInput::make('icon')->maxLength(100),
                        Forms\Components\FileUpload::make('image')->image()->directory('training-categories'),
                        Forms\Components\TextInput::make('sort_order')->numeric()->default(fn () => (\App\Models\TrainingCategory::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')->default(true),
                    ])->columns(2),
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('courses_count')->counts('courses')->label('Courses')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingCategories::route('/'),
            'create' => Pages\CreateTrainingCategory::route('/create'),
            'edit' => Pages\EditTrainingCategory::route('/{record}/edit'),
        ];
    }
}
