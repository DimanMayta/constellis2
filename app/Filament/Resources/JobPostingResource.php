<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobPostingResource\Pages;
use App\Models\JobPosting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobPostingResource extends Resource
{
    protected static ?string $model = JobPosting::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Job Postings';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $state ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('employment_type')->options(['full-time' => 'Full-Time', 'part-time' => 'Part-Time', 'contract' => 'Contract']),
                Forms\Components\TextInput::make('location'),
                Forms\Components\TextInput::make('country'),
                Forms\Components\TextInput::make('department'),
                Forms\Components\TextInput::make('clearance_level'),
                Forms\Components\TextInput::make('salary_range'),
                Forms\Components\Select::make('reference_project_id')->relationship('project', 'name'),
                Forms\Components\MarkdownEditor::make('description'),
                Forms\Components\MarkdownEditor::make('requirements'),
                Forms\Components\MarkdownEditor::make('responsibilities'),
                Forms\Components\DateTimePicker::make('expires_at'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(fn () => (JobPosting::max('sort_order') ?? 0) + 1),
                Forms\Components\Toggle::make('is_active')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('employment_type')->badge(),
            Tables\Columns\TextColumn::make('location'),
            Tables\Columns\TextColumn::make('applications_count')->counts('applications')->label('Applications'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
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
        ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobPostings::route('/'),
            'create' => Pages\CreateJobPosting::route('/create'),
            'edit' => Pages\EditJobPosting::route('/{record}/edit'),
        ];
    }
}
