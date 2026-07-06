<?php

// Створення таблиці напрямів діяльності.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('icon_path');
            $table->string('title_ua');
            $table->string('title_en');
            $table->text('description_ua');
            $table->text('description_en');
            $table->integer('sort_order')->nullable()->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_active')->nullable()->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
