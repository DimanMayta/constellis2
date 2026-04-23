<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_es')->nullable()->after('name_en');
            $table->text('icon_svg')->nullable()->after('icon');
            // Make category nullable since we no longer use categories
            $table->foreignId('service_category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_es', 'icon_svg']);
        });
    }
};
