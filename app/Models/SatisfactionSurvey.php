<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatisfactionSurvey extends Model
{
    protected $fillable = [
        'overall_rating', 'design_rating', 'usability_rating',
        'content_rating', 'would_recommend', 'suggestions',
        'visitor_name', 'visitor_email', 'ip_address',
    ];

    protected $casts = [
        'would_recommend' => 'boolean',
    ];
}
