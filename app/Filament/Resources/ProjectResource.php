<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'What We Do';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Project Details')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('code_name'),
                Forms\Components\TextInput::make('client'),
                Forms\Components\Select::make('status')->options(['planning' => 'Planning', 'active' => 'Active', 'completed' => 'Completed']),
                Forms\Components\TextInput::make('progress_percentage')->numeric()->minValue(0)->maxValue(100),
                Forms\Components\TextInput::make('location'),
                Forms\Components\TextInput::make('country'),
                Forms\Components\TextInput::make('budget')->numeric()->prefix('$'),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\Textarea::make('description')->rows(3),
                Forms\Components\MarkdownEditor::make('details'),
                Forms\Components\TextInput::make('access_code')->password()->dehydrateStateUsing(fn ($state) => $state ? $state : null),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code_name'),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state) => match($state) { 'active' => 'info', 'completed' => 'success', 'planning' => 'warning' }),
            Tables\Columns\TextColumn::make('progress_percentage')->suffix('%'),
            Tables\Columns\TextColumn::make('country'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ])->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
