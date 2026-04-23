<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageClient extends Model
{
    protected $fillable = [
        'name', 'name_en', 'name_es',
        'image', 'image_url',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
