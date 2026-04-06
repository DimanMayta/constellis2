<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satisfaction_surveys', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('overall_rating'); // 1-5
            $table->tinyInteger('design_rating')->nullable();
            $table->tinyInteger('usability_rating')->nullable();
            $table->tinyInteger('content_rating')->nullable();
            $table->boolean('would_recommend')->default(false);
            $table->text('suggestions')->nullable();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satisfaction_surveys');
    }
};
