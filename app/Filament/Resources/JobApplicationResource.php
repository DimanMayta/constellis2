<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Job Applications';
    protected static ?string $modelLabel = 'Application';
    protected static ?string $pluralModelLabel = 'Applications';

    public static function getNavigationBadge(): ?string
    {
        $count = JobApplication::where('status', 'received')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Applicant Information')
                ->icon('heroicon-o-user')
                ->schema([
                    Forms\Components\TextInput::make('full_name')
                        ->disabled()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('email')
                        ->disabled()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('phone')
                        ->disabled()
                        ->columnSpan(1),
                    Forms\Components\Select::make('job_posting_id')
                        ->relationship('jobPosting', 'title')
                        ->disabled()
                        ->columnSpan(1),
                ])->columns(2),

            Forms\Components\Section::make('Application Details')
                ->icon('heroicon-o-document-text')
                ->schema([
                    Forms\Components\Textarea::make('cover_letter')
                        ->disabled()
                        ->rows(4)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('experience_summary')
                        ->disabled()
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Review & Status')
                ->icon('heroicon-o-clipboard-document-check')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'received' => '📩 Received',
                            'reviewing' => '🔍 Under Review',
                            'interview' => '📅 Interview Scheduled',
                            'offered' => '✅ Offer Extended',
                            'rejected' => '❌ Not Selected',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\Textarea::make('notes')
                        ->label('Internal Notes')
                        ->placeholder('Add private notes about this applicant...')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Applicant')
                ->icon('heroicon-o-user')
                ->schema([
                    Infolists\Components\TextEntry::make('full_name')->label('Name'),
                    Infolists\Components\TextEntry::make('email')
                        ->copyable()
                        ->icon('heroicon-o-envelope'),
                    Infolists\Components\TextEntry::make('phone')
                        ->icon('heroicon-o-phone')
                        ->default('—'),
                    Infolists\Components\TextEntry::make('jobPosting.title')
                        ->label('Position Applied')
                        ->icon('heroicon-o-briefcase'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Applied On')
                        ->dateTime('M d, Y H:i')
                        ->icon('heroicon-o-calendar'),
                    Infolists\Components\TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'received' => 'warning',
                            'reviewing' => 'info',
                            'interview' => 'primary',
                            'offered' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        }),
                ])->columns(3),

            Infolists\Components\Section::make('Cover Letter')
                ->icon('heroicon-o-document-text')
                ->schema([
                    Infolists\Components\TextEntry::make('cover_letter')
                        ->hiddenLabel()
                        ->default('No cover letter provided.')
                        ->markdown(),
                ])->collapsible(),

            Infolists\Components\Section::make('Experience Summary')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Infolists\Components\TextEntry::make('experience_summary')
                        ->hiddenLabel()
                        ->default('No experience summary provided.')
                        ->markdown(),
                ])->collapsible(),

            Infolists\Components\Section::make('Uploaded Documents')
                ->icon('heroicon-o-paper-clip')
                ->schema([
                    Infolists\Components\TextEntry::make('cv_path')
                        ->label('CV / Resume')
                        ->formatStateUsing(fn (?string $state) => $state ? '📄 ' . basename($state) : '—')
                        ->url(fn (?string $state) => $state ? asset('storage/' . $state) : null, shouldOpenInNewTab: true),
                    Infolists\Components\TextEntry::make('nda_path')
                        ->label('NDA')
                        ->formatStateUsing(fn (?string $state) => $state ? '📄 ' . basename($state) : '—')
                        ->url(fn (?string $state) => $state ? asset('storage/' . $state) : null, shouldOpenInNewTab: true),
                    Infolists\Components\TextEntry::make('interview_request_path')
                        ->label('Interview Request')
                        ->formatStateUsing(fn (?string $state) => $state ? '📄 ' . basename($state) : '—')
                        ->url(fn (?string $state) => $state ? asset('storage/' . $state) : null, shouldOpenInNewTab: true),
                    Infolists\Components\TextEntry::make('application_form_path')
                        ->label('Application Form')
                        ->formatStateUsing(fn (?string $state) => $state ? '📄 ' . basename($state) : '—')
                        ->url(fn (?string $state) => $state ? asset('storage/' . $state) : null, shouldOpenInNewTab: true),
                ])->columns(2),

            Infolists\Components\Section::make('Internal Notes')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->schema([
                    Infolists\Components\TextEntry::make('notes')
                        ->hiddenLabel()
                        ->default('No notes yet.'),
                ])->collapsible()->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('jobPosting.title')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->jobPosting?->title),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'received' => 'warning',
                        'reviewing' => 'info',
                        'interview' => 'primary',
                        'offered' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('cv_path')
                    ->label('CV')
                    ->formatStateUsing(fn (?string $state) => $state ? '📄' : '—')
                    ->url(fn ($record) => $record->cv_path ? asset('storage/' . $record->cv_path) : null, shouldOpenInNewTab: true)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied')
                    ->since()
                    ->sortable()
                    ->description(fn ($record) => $record->created_at->format('M d, Y')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'received' => 'Received',
                        'reviewing' => 'Under Review',
                        'interview' => 'Interview',
                        'offered' => 'Offered',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('job_posting_id')
                    ->relationship('jobPosting', 'title')
                    ->label('Position')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Review'),
                Tables\Actions\Action::make('download_cv')
                    ->label('CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->cv_path ? asset('storage/' . $record->cv_path) : null, shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->cv_path !== null)
                    ->color('info'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'view' => Pages\ViewJobApplication::route('/{record}'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
