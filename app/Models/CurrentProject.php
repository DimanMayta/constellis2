<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentProject extends Model
{
    use HasFactory;

    /**
     * Project category constants
     */
    const CATEGORY_PROPOSED_SM_MID_LARGE = 'proposed_sm_mid_large';
    const CATEGORY_CLASSIFIED = 'classified';
    const CATEGORY_PROPOSED_MEGA = 'proposed_mega';

    /**
     * Available categories with labels
     */
    public static function categoryOptions(): array
    {
        return [
            self::CATEGORY_PROPOSED_SM_MID_LARGE => 'Proposed Projects SM - MID - LARGE',
            self::CATEGORY_CLASSIFIED => 'Classified',
            self::CATEGORY_PROPOSED_MEGA => 'Proposed Mega Projects',
        ];
    }

    protected $fillable = [
        'name_en', 'name_es',
        'description_en', 'description_es',
        'image', 'location_en', 'location_es',
        'status', 'sort_order', 'is_active',
        'category',
    ];

    protected $casts = [
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
}
