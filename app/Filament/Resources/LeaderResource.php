<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaderResource\Pages;
use App\Models\Leader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LeaderResource extends Resource
{
    protected static ?string $model = Leader::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Who We Are';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Leadership';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Leader Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('title')
                            ->label('Position/Title')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('linkedin_url')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->directory('leaders')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (\App\Models\Leader::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Veteran & Experience Info')
                    ->schema([
                        Forms\Components\TextInput::make('years_experience')
                            ->numeric()
                            ->label('Years of Experience'),
                        Forms\Components\Toggle::make('is_veteran')
                            ->label('Military Veteran'),
                        Forms\Components\TextInput::make('military_branch')
                            ->label('Branch of Service')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('rank')
                            ->label('Military Rank')
                            ->maxLength(100),
                        Forms\Components\TagsInput::make('countries_served')
                            ->label('Countries Served')
                            ->placeholder('Add a country'),
                        Forms\Components\TagsInput::make('specializations')
                            ->label('Areas of Expertise')
                            ->placeholder('Add a specialization'),
                        Forms\Components\TagsInput::make('education')
                            ->label('Education')
                            ->placeholder('Add education'),
                        Forms\Components\TagsInput::make('certifications')
                            ->label('Certifications')
                            ->placeholder('Add a certification'),
                    ])->columns(2),

                Forms\Components\Section::make('Biography')
                    ->schema([
                        Forms\Components\RichEditor::make('bio')
                            ->label('Short Bio')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('full_resume')
                            ->label('Full Resume / Extended Biography')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('years_experience')->label('Experience')->suffix(' yrs'),
                Tables\Columns\IconColumn::make('is_veteran')->boolean()->label('Veteran'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_veteran')->label('Veterans Only'),
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
            'index' => Pages\ListLeaders::route('/'),
            'create' => Pages\CreateLeader::route('/create'),
            'edit' => Pages\EditLeader::route('/{record}/edit'),
        ];
    }
}
