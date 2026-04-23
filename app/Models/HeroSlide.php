<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'badge_en', 'badge_es',
        'title_a_en', 'title_a_es',
        'title_b_en', 'title_b_es',
        'description_en', 'description_es',
        'cta_en', 'cta_es', 'cta_link',
        'bg_image', 'bg_image_es', 'bg_position',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
