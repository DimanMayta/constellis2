<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'job_posting_id', 'full_name', 'email', 'phone',
        'cover_letter', 'cv_path', 'nda_path',
        'interview_request_path', 'application_form_path',
        'experience_summary', 'status', 'notes',
    ];

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'received' => 'Received',
            'reviewing' => 'Under Review',
            'interview' => 'Interview Scheduled',
            'offered' => 'Offer Extended',
            'rejected' => 'Not Selected',
            default => $this->status,
        };
    }
}
