<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'tab_key', 'label_en', 'label_es',
        'icon_svg', 'content_en', 'content_es',
        'video_url', 'image', 'carousel_images',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'carousel_images' => 'array',
    ];
}
