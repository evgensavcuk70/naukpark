<?php

// Створення таблиці новин.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index('category_id');
            $table->string('image_main');
            $table->string('slug')->unique('slug');
            $table->string('title_ua');
            $table->text('excerpt_ua');
            $table->longText('content_ua');
            $table->string('title_en');
            $table->text('excerpt_en');
            $table->longText('content_en');
            $table->boolean('is_pinned')->nullable()->default(false);
            $table->boolean('is_archived')->nullable()->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title_ua')->nullable();
            $table->string('meta_description_ua')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->timestamps();

            $table->fullText(['title_en', 'excerpt_en', 'content_en'], 'news_search_en');
            $table->fullText(['title_ua', 'excerpt_ua', 'content_ua'], 'news_search_ua');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
