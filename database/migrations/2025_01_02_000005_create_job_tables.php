<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->foreignId('reference_project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('employment_type')->default('full-time'); // full-time, part-time, contract
            $table->string('clearance_level')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('department')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('nda_path')->nullable();
            $table->string('interview_request_path')->nullable();
            $table->string('application_form_path')->nullable();
            $table->text('experience_summary')->nullable();
            $table->string('status')->default('received'); // received, reviewing, interview, offered, rejected
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_postings');
    }
};
