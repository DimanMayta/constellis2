<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('image')->nullable()->after('country_emoji');
            $table->string('author_name')->nullable()->after('image');
            $table->string('author_role_en')->nullable()->after('author_name');
            $table->string('author_role_es')->nullable()->after('author_role_en');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['image', 'author_name', 'author_role_en', 'author_role_es']);
        });
    }
};
