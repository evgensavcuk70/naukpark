<?php

// Створення таблиці фотогалереї новин.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('news_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('news_id')->index('news_id');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_galleries');
    }
};
