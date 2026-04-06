<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'department',
        'employee_code', 'access_level', 'avatar', 'is_active', 'last_seen_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Check if user was seen in the last 30 seconds.
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subSeconds(30));
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    // ── Role Checks ──
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isEmployee(): bool { return in_array($this->role, ['admin', 'employee']); }
    public function isContractor(): bool { return $this->role === 'contractor'; }

    public function canAccessStore(): bool
    {
        return $this->isEmployee() && $this->is_active;
    }

    public function canAccessIntranet(): bool
    {
        return $this->is_active && in_array($this->role, ['admin', 'employee', 'contractor']);
    }

    public function canAccessProjects(): bool
    {
        return $this->is_active && in_array($this->role, ['admin', 'employee', 'contractor']);
    }

    // ── Relationships ──
    public function sentMessages()
    {
        return $this->hasMany(InternalMessage::class, 'from_user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(InternalMessage::class, 'to_user_id');
    }

    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->unread()->count();
    }

    public function orders()
    {
        return $this->hasMany(StoreOrder::class);
    }
}
