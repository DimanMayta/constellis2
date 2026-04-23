<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_events', function (Blueprint $table) {
            $table->string('media_type')->default('none')->after('gradient_classes');
            // none, youtube, video, image
            $table->string('media_url')->nullable()->after('media_type');
            // YouTube URL or uploaded file path
        });
    }

    public function down(): void
    {
        Schema::table('homepage_events', function (Blueprint $table) {
            $table->dropColumn(['media_type', 'media_url']);
        });
    }
};
