<?php

// Створення таблиці слайдів головного слайдера.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image_path');
            $table->string('title_ua')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ua')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
