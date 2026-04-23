<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Site Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Details')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique identifier (e.g. site.name, contact.email)'),
                        Forms\Components\TextInput::make('label')
                            ->maxLength(255)
                            ->helperText('Human-readable label'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'boolean' => 'Boolean',
                                'number' => 'Number',
                                'email' => 'Email',
                                'url' => 'URL',
                            ])
                            ->default('text'),
                        Forms\Components\TextInput::make('group')
                            ->maxLength(100)
                            ->placeholder('e.g. general, contact, social'),
                        Forms\Components\Textarea::make('value')
                            ->rows(3)
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get) => $get('type') !== 'boolean'),
                        Forms\Components\Toggle::make('value_boolean')
                            ->label('Enabled')
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                            ->afterStateHydrated(function (Forms\Components\Toggle $component, $record) {
                                if ($record) {
                                    $component->state($record->value === 'true');
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => $state ? 'true' : 'false')
                            ->dehydrated(fn (Forms\Get $get) => $get('type') === 'boolean'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable()->sortable()->copyable(),
                Tables\Columns\TextColumn::make('label')->searchable(),
                Tables\Columns\TextColumn::make('value')->limit(50),
                Tables\Columns\TextColumn::make('group')->badge()->sortable(),
                Tables\Columns\TextColumn::make('type')->badge()->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group'),
                Tables\Filters\SelectFilter::make('type'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])])
            ->defaultSort('group')
            ->groups(['group']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
