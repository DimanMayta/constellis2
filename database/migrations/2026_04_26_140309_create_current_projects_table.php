<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('current_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_es');
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();
            $table->string('image')->nullable();
            $table->string('location_en')->nullable();
            $table->string('location_es')->nullable();
            $table->string('status')->default('active'); // active, completed, upcoming
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_projects');
    }
};
