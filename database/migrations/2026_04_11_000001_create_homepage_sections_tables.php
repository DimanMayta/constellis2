<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge_en')->nullable();
            $table->string('badge_es')->nullable();
            $table->string('title_a_en')->nullable();
            $table->string('title_a_es')->nullable();
            $table->string('title_b_en')->nullable();
            $table->string('title_b_es')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();
            $table->string('cta_en')->nullable();
            $table->string('cta_es')->nullable();
            $table->string('cta_link')->default('#');
            $table->string('bg_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('tab_key'); // who, vision, mission
            $table->string('label_en')->nullable();
            $table->string('label_es')->nullable();
            $table->string('icon_svg')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_events', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_es');
            $table->string('emoji')->nullable();
            $table->string('gradient_classes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('country_en')->nullable();
            $table->string('country_es')->nullable();
            $table->string('country_emoji')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_es')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('homepage_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_clients');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('homepage_events');
        Schema::dropIfExists('about_sections');
        Schema::dropIfExists('hero_slides');
    }
};
