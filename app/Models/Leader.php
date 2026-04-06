<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'slug', 'bio', 'photo',
        'linkedin_url', 'years_experience', 'countries_served',
        'is_veteran', 'military_branch', 'rank',
        'specializations', 'education', 'certifications',
        'full_resume', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_veteran' => 'boolean',
        'countries_served' => 'array',
        'specializations' => 'array',
        'education' => 'array',
        'certifications' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeVeterans($query)
    {
        return $query->where('is_veteran', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get combined years of experience for all active leaders.
     */
    public static function getCombinedYears(): int
    {
        return static::active()->sum('years_experience');
    }

    /**
     * Get unique list of all countries served by all leaders.
     */
    public static function getAllCountries(): array
    {
        $countries = [];
        static::active()->whereNotNull('countries_served')->get()->each(function ($leader) use (&$countries) {
            if (is_array($leader->countries_served)) {
                $countries = array_merge($countries, $leader->countries_served);
            }
        });
        return array_values(array_unique($countries));
    }

    /**
     * Get veteran percentage.
     */
    public static function getVeteranPercentage(): int
    {
        $total = static::active()->count();
        if ($total === 0) return 0;
        $veterans = static::active()->veterans()->count();
        return (int) round(($veterans / $total) * 100);
    }
}
