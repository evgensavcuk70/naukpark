<?php

// Створення таблиці напрямів діяльності (альтернативна структура).
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('activity_directions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon_path');
            $table->string('title_ua', 60);
            $table->string('title_en', 60);
            $table->string('description_ua', 180);
            $table->string('description_en', 180);
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_directions');
    }
};
