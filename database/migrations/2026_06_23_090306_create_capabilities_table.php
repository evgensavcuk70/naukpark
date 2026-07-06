<?php

// Створення таблиці можливостей Наукового парку.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('capabilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('icon_path');
            $table->string('title_ua');
            $table->string('title_en');
            $table->string('description_ua', 120);
            $table->string('description_en', 120);
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capabilities');
    }
};
