<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internal_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject')->nullable();
            $table->longText('body');
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();

            $table->index(['to_user_id', 'read_at']);
            $table->index(['from_user_id', 'created_at']);
        });

        Schema::create('internal_announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->string('category')->default('general'); // general, hr, operations, security
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        Schema::create('internal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->bigInteger('file_size')->default(0);
            $table->string('category')->default('general'); // general, policy, procedure, training, hr
            $table->string('access_level')->default('basic'); // basic, elevated, full
            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
            $table->integer('download_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internal_documents');
        Schema::dropIfExists('internal_announcements');
        Schema::dropIfExists('internal_messages');
    }
};
