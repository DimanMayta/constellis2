<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supported_projects', function (Blueprint $table) {
            $table->string('section_en')->nullable()->after('is_active');
            $table->string('section_es')->nullable()->after('section_en');
            // Section/category title for grouping projects (e.g. "Fundaciones de Bolivia")
        });
    }

    public function down(): void
    {
        Schema::table('supported_projects', function (Blueprint $table) {
            $table->dropColumn(['section_en', 'section_es']);
        });
    }
};
