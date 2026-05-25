<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'country_en', 'country_es',
        'country_emoji', 'image',
        'video', 'video_url',
        'author_name', 'author_role_en', 'author_role_es',
        'content_en', 'content_es',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Extract YouTube video ID from various URL formats.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->video_url) return null;

        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video_url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Check if testimonial has any media (image or video).
     */
    public function getHasMediaAttribute(): bool
    {
        return $this->image || $this->video || $this->video_url;
    }
}
