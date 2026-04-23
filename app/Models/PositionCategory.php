<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionCategory extends Model
{
    protected $fillable = [
        'name_en', 'name_es', 'icon_svg',
        'image', 'image_url',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
