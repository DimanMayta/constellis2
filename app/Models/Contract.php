<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'contract_number', 'entity', 'description',
        'details', 'external_url', 'naics_codes', 'categories',
        'regions', 'domain', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'naics_codes' => 'array',
        'categories' => 'array',
        'regions' => 'array',
        'is_active' => 'boolean',
    ];

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
}
