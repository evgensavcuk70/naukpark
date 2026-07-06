<?php

// Створення таблиці категорій новин.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ua');
            $table->string('name_en');
            $table->string('slug')->unique('slug');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_categories');
    }
};
