<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatisfactionSurveyResource\Pages;
use App\Models\SatisfactionSurvey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SatisfactionSurveyResource extends Resource
{
    protected static ?string $model = SatisfactionSurvey::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Contact Us';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Surveys';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Survey Response')->schema([
                Forms\Components\TextInput::make('visitor_name')->disabled(),
                Forms\Components\TextInput::make('visitor_email')->disabled(),
                Forms\Components\TextInput::make('ip_address')->disabled(),
                Forms\Components\TextInput::make('overall_rating')->disabled()->numeric(),
                Forms\Components\TextInput::make('design_rating')->disabled()->numeric(),
                Forms\Components\TextInput::make('usability_rating')->disabled()->numeric(),
                Forms\Components\TextInput::make('content_rating')->disabled()->numeric(),
                Forms\Components\Toggle::make('would_recommend')->disabled(),
                Forms\Components\Textarea::make('suggestions')->disabled()->rows(4)->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Date'),
            Tables\Columns\TextColumn::make('visitor_name')->searchable()->label('Name'),
            Tables\Columns\TextColumn::make('visitor_email')->searchable()->label('Email'),
            Tables\Columns\TextColumn::make('overall_rating')->sortable()->badge()->color(fn (int $state) => match(true) { $state >= 4 => 'success', $state >= 3 => 'warning', default => 'danger' }),
            Tables\Columns\IconColumn::make('would_recommend')->boolean()->label('Recommend?'),
            Tables\Columns\TextColumn::make('ip_address')->toggleable(isToggledHiddenByDefault: true),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSatisfactionSurveys::route('/'),
            'edit' => Pages\EditSatisfactionSurvey::route('/{record}/edit'),
        ];
    }
}
