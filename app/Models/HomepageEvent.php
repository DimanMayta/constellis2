<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageEvent extends Model
{
    protected $fillable = [
        'name_en', 'name_es',
        'emoji', 'gradient_classes',
        'media_type', 'media_url', 'thumbnail_image',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
