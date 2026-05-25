<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentProjectResource\Pages;
use App\Models\CurrentProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CurrentProjectResource extends Resource
{
    protected static ?string $model = CurrentProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Current Projects';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_es')
                            ->label('Name (Spanish)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(3),
                        Forms\Components\Textarea::make('description_es')
                            ->label('Description (Spanish)')
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Details')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Project Image')
                            ->directory('current-projects')
                            ->previewable(false)
                            ->deletable()
                            ->helperText('Upload a JPG/PNG image for this project.')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('location_en')
                            ->label('Location (English)')
                            ->placeholder('e.g. Middle East'),
                        Forms\Components\TextInput::make('location_es')
                            ->label('Location (Spanish)')
                            ->placeholder('e.g. Medio Oriente'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'completed' => 'Completed',
                                'upcoming' => 'Upcoming',
                            ])
                            ->default('active')
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label('Classification')
                            ->options(CurrentProject::categoryOptions())
                            ->default(CurrentProject::CATEGORY_PROPOSED_SM_MID_LARGE)
                            ->required()
                            ->helperText('Select the project classification category.'),
                    ])->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(fn () => (CurrentProject::max('sort_order') ?? 0) + 1),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
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
                    ->limit(50),
                Tables\Columns\TextColumn::make('location_en')
                    ->label('Location')
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Classification')
                    ->formatStateUsing(fn (string $state): string => CurrentProject::categoryOptions()[$state] ?? $state)
                    ->colors([
                        'primary' => 'proposed_sm_mid_large',
                        'warning' => 'classified',
                        'danger' => 'proposed_mega',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'upcoming',
                        'secondary' => 'completed',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'upcoming' => 'Upcoming',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Classification')
                    ->options(CurrentProject::categoryOptions()),
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
            'index' => Pages\ListCurrentProjects::route('/'),
            'create' => Pages\CreateCurrentProject::route('/create'),
            'edit' => Pages\EditCurrentProject::route('/{record}/edit'),
        ];
    }
}
