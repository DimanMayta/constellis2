<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Project extends Model
{
    protected $fillable = [
        'name', 'slug', 'code_name', 'description', 'details',
        'status', 'progress_percentage', 'start_date', 'end_date',
        'location', 'country', 'images', 'documents', 'milestones',
        'access_code', 'budget', 'client', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'documents' => 'array',
        'milestones' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $hidden = ['access_code'];

    public function setAccessCodeAttribute($value)
    {
        $this->attributes['access_code'] = $value ? Hash::make($value) : null;
    }

    public function verifyAccessCode(string $code): bool
    {
        return Hash::check($code, $this->access_code);
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'reference_project_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'planning' => 'Planning',
            'active' => 'In Progress',
            'completed' => 'Completed',
            default => $this->status,
        };
    }
}
