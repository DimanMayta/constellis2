<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_events', function (Blueprint $table) {
            $table->string('thumbnail_image')->nullable()->after('media_url');
            // Custom thumbnail image to display on the card instead of auto-generated thumbnails
        });
    }

    public function down(): void
    {
        Schema::table('homepage_events', function (Blueprint $table) {
            $table->dropColumn('thumbnail_image');
        });
    }
};
