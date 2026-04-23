<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportedProject extends Model
{
    protected $fillable = [
        'name_en',
        'name_es',
        'description_en',
        'description_es',
        'logo',
        'image_url',
        'website_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
