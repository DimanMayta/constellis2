<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code_name')->nullable();
            $table->text('description')->nullable();
            $table->longText('details')->nullable();
            $table->string('status')->default('active'); // planning, active, completed
            $table->integer('progress_percentage')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->json('images')->nullable();
            $table->json('documents')->nullable();
            $table->json('milestones')->nullable();
            $table->string('access_code')->nullable(); // hashed
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('client')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
