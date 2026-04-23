<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('browser_version', 50)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('device_type', 20)->default('desktop'); // desktop, mobile, tablet, bot
            $table->string('url', 2048);
            $table->string('method', 10)->default('GET');
            $table->string('referrer', 2048)->nullable();
            $table->text('user_agent')->nullable();
            $table->integer('status_code')->nullable();
            $table->float('response_time')->nullable(); // in milliseconds
            $table->string('session_id', 100)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('created_at');
            $table->index('country');
            $table->index('browser');
            $table->index('device_type');
            $table->index([DB::raw('url(191)')]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
