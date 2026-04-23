<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return (string) User::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'employee_code', 'department'];
    }

    // ═══════════════════════════════════════════
    // FORM (Create / Edit)
    // ═══════════════════════════════════════════

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ── Personal Information ──
                Forms\Components\Section::make('Personal Information')
                    ->description('Basic user identity and login credentials.')
                    ->icon('heroicon-o-user')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Full name')
                                ->prefixIcon('heroicon-o-user'),

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('user@constellis.com')
                                ->prefixIcon('heroicon-o-envelope'),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('password')
                                ->password()
                                ->revealable()
                                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->maxLength(255)
                                ->placeholder('Min. 8 characters')
                                ->prefixIcon('heroicon-o-lock-closed')
                                ->helperText(fn (string $operation) => $operation === 'edit' ? 'Leave blank to keep current password.' : null),

                            Forms\Components\FileUpload::make('avatar')
                                ->image()
                                ->avatar()
                                ->directory('avatars')
                                ->maxSize(2048)
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('1:1')
                                ->imageResizeTargetWidth('200')
                                ->imageResizeTargetHeight('200')
                                ->alignCenter()
                                ->helperText('Upload avatar image (optional, max 2MB).'),
                        ]),
                    ]),

                // ── Role & Access ──
                Forms\Components\Section::make('Role & Permissions')
                    ->description('Define user role, access level, and organizational details.')
                    ->icon('heroicon-o-shield-check')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('role')
                                ->options([
                                    'admin' => '🛡️ Admin',
                                    'employee' => '👤 Employee',
                                    'contractor' => '🔧 Contractor',
                                ])
                                ->required()
                                ->native(false)
                                ->default('employee')
                                ->live()
                                ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                    if ($state) {
                                        $prefix = match ($state) {
                                            'admin' => 'CON-ADMIN',
                                            'employee' => 'CON-EMP',
                                            'contractor' => 'CON-CTR',
                                            default => 'CON-USR',
                                        };
                                        $lastCode = User::where('employee_code', 'like', $prefix . '-%')
                                            ->orderByDesc('employee_code')
                                            ->value('employee_code');
                                        $nextNum = $lastCode
                                            ? (int) substr($lastCode, strrpos($lastCode, '-') + 1) + 1
                                            : 1;
                                        $set('employee_code', $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT));
                                    }
                                })
                                ->helperText('Determines sidebar access and capabilities.'),

                            Forms\Components\Select::make('access_level')
                                ->options([
                                    'basic' => '🟢 Basic',
                                    'elevated' => '🟡 Elevated',
                                    'full' => '🔴 Full',
                                ])
                                ->required()
                                ->native(false)
                                ->default('basic')
                                ->helperText('Controls document visibility and feature access.'),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->helperText('Inactive users cannot login.')
                                ->onColor('success')
                                ->offColor('danger')
                                ->inline(false),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('department')
                                ->maxLength(255)
                                ->placeholder('e.g. Operations, IT, External')
                                ->prefixIcon('heroicon-o-building-office')
                                ->datalist([
                                    'IT', 'Operations', 'External', 'Finance',
                                    'Human Resources', 'Security', 'Training',
                                    'Legal', 'Communications',
                                ]),

                            Forms\Components\TextInput::make('employee_code')
                                ->maxLength(255)
                                ->placeholder('Select a role to generate')
                                ->prefixIcon('heroicon-o-identification')
                                ->unique(ignoreRecord: true)
                                ->readOnly()
                                ->default(function () {
                                    $prefix = 'CON-EMP';
                                    $lastCode = User::where('employee_code', 'like', $prefix . '-%')
                                        ->orderByDesc('employee_code')
                                        ->value('employee_code');
                                    $nextNum = $lastCode
                                        ? (int) substr($lastCode, strrpos($lastCode, '-') + 1) + 1
                                        : 1;
                                    return $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
                                })
                                ->helperText('Auto-generated from selected role.'),
                        ]),
                    ]),
            ]);
    }

    // ═══════════════════════════════════════════
    // TABLE (List)
    // ═══════════════════════════════════════════

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (User $record): string => $record->email),

                Tables\Columns\TextColumn::make('employee_code')
                    ->label('Code')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'employee' => 'info',
                        'contractor' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'admin' => 'heroicon-o-shield-check',
                        'employee' => 'heroicon-o-briefcase',
                        'contractor' => 'heroicon-o-wrench-screwdriver',
                        default => 'heroicon-o-user',
                    }),

                Tables\Columns\TextColumn::make('department')
                    ->label('Department')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—')
                    ->icon('heroicon-o-building-office')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('access_level')
                    ->label('Access')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'full' => 'danger',
                        'elevated' => 'warning',
                        'basic' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('last_seen_at')
                    ->label('Status')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'Never';
                        $parsed = Carbon::parse($state);
                        if ($parsed->gt(now()->subSeconds(30))) return 'Online';
                        return $parsed->diffForHumans();
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (!$state) return 'gray';
                        return Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'success' : 'gray';
                    })
                    ->icon(function ($state) {
                        if (!$state) return 'heroicon-o-signal-slash';
                        return Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'heroicon-o-signal' : 'heroicon-o-clock';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Joined')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                        'contractor' => 'Contractor',
                    ])
                    ->label('Role'),

                Tables\Filters\SelectFilter::make('access_level')
                    ->options([
                        'full' => 'Full',
                        'elevated' => 'Elevated',
                        'basic' => 'Basic',
                    ])
                    ->label('Access Level'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),

                Tables\Filters\Filter::make('online')
                    ->label('Online Now')
                    ->query(fn (Builder $query) => $query->where('last_seen_at', '>=', now()->subSeconds(30)))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('toggleActive')
                        ->label(fn (User $record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->icon(fn (User $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn (User $record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn (User $record) => $record->update(['is_active' => !$record->is_active])),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->poll('30s');
    }

    // ═══════════════════════════════════════════
    // INFOLIST (View)
    // ═══════════════════════════════════════════

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Personal Information')
                    ->icon('heroicon-o-user')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Full Name')
                            ->weight('bold')
                            ->size('lg')
                            ->icon('heroicon-o-user'),

                        Infolists\Components\TextEntry::make('email')
                            ->icon('heroicon-o-envelope')
                            ->copyable()
                            ->copyMessage('Email copied'),

                        Infolists\Components\TextEntry::make('employee_code')
                            ->label('Employee Code')
                            ->badge()
                            ->color('primary')
                            ->placeholder('Not assigned')
                            ->icon('heroicon-o-identification'),
                    ]),

                Infolists\Components\Section::make('Role & Permissions')
                    ->icon('heroicon-o-shield-check')
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('role')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->color(fn (string $state): string => match ($state) {
                                'admin' => 'danger',
                                'employee' => 'info',
                                'contractor' => 'warning',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'admin' => 'heroicon-o-shield-check',
                                'employee' => 'heroicon-o-briefcase',
                                'contractor' => 'heroicon-o-wrench-screwdriver',
                                default => 'heroicon-o-user',
                            }),

                        Infolists\Components\TextEntry::make('access_level')
                            ->label('Access Level')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => ucfirst($state))
                            ->color(fn (string $state): string => match ($state) {
                                'full' => 'danger',
                                'elevated' => 'warning',
                                'basic' => 'success',
                                default => 'gray',
                            }),

                        Infolists\Components\TextEntry::make('department')
                            ->placeholder('Not assigned')
                            ->icon('heroicon-o-building-office'),

                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                    ]),

                Infolists\Components\Section::make('Activity')
                    ->icon('heroicon-o-clock')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('last_seen_at')
                            ->label('Last Seen')
                            ->since()
                            ->placeholder('Never')
                            ->icon('heroicon-o-signal')
                            ->badge()
                            ->color(fn ($state) => $state && Carbon::parse($state)->gt(now()->subSeconds(30)) ? 'success' : 'gray'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Account Created')
                            ->dateTime('M d, Y — g:i A')
                            ->icon('heroicon-o-calendar'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->since()
                            ->icon('heroicon-o-pencil-square'),
                    ]),

                Infolists\Components\Section::make('Permissions Summary')
                    ->icon('heroicon-o-key')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('role')
                            ->label('Can Access Admin Panel')
                            ->formatStateUsing(fn (string $state) => $state === 'admin' ? '✅ Yes' : '❌ No')
                            ->color(fn (string $state) => $state === 'admin' ? 'success' : 'danger'),

                        Infolists\Components\TextEntry::make('role')
                            ->label('Can Access Intranet')
                            ->formatStateUsing(fn (string $state) => in_array($state, ['admin', 'employee', 'contractor']) ? '✅ Yes' : '❌ No')
                            ->color(fn (string $state) => in_array($state, ['admin', 'employee', 'contractor']) ? 'success' : 'danger'),

                        Infolists\Components\TextEntry::make('role')
                            ->label('Can Access Store')
                            ->formatStateUsing(fn (string $state) => in_array($state, ['admin', 'employee']) ? '✅ Yes' : '❌ No')
                            ->color(fn (string $state) => in_array($state, ['admin', 'employee']) ? 'success' : 'danger'),

                        Infolists\Components\TextEntry::make('access_level')
                            ->label('Document Access')
                            ->formatStateUsing(fn (string $state) => match ($state) {
                                'full' => '📁 All documents (Basic + Elevated + Full)',
                                'elevated' => '📁 Basic + Elevated documents',
                                'basic' => '📁 Basic documents only',
                                default => '—',
                            }),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
