<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('contract_number')->nullable();
            $table->string('entity')->nullable();
            $table->text('description')->nullable();
            $table->longText('details')->nullable();
            $table->string('external_url')->nullable();
            $table->json('naics_codes')->nullable();
            $table->json('categories')->nullable();
            $table->json('regions')->nullable();
            $table->string('domain')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
