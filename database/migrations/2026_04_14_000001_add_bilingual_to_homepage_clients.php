<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_clients', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_es')->nullable()->after('name_en');
        });

        // Copy existing name to name_en
        DB::table('homepage_clients')->whereNull('name_en')->update([
            'name_en' => DB::raw('name'),
            'name_es' => DB::raw('name'),
        ]);
    }

    public function down(): void
    {
        Schema::table('homepage_clients', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_es']);
        });
    }
};
