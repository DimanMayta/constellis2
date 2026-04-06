<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->integer('years_experience')->default(0)->after('linkedin_url');
            $table->json('countries_served')->nullable()->after('years_experience');
            $table->boolean('is_veteran')->default(false)->after('countries_served');
            $table->string('military_branch')->nullable()->after('is_veteran');
            $table->string('rank')->nullable()->after('military_branch');
            $table->json('specializations')->nullable()->after('rank');
            $table->json('education')->nullable()->after('specializations');
            $table->json('certifications')->nullable()->after('education');
            $table->longText('full_resume')->nullable()->after('certifications');
        });
    }

    public function down(): void
    {
        Schema::table('leaders', function (Blueprint $table) {
            $table->dropColumn([
                'years_experience', 'countries_served', 'is_veteran',
                'military_branch', 'rank', 'specializations',
                'education', 'certifications', 'full_resume',
            ]);
        });
    }
};
