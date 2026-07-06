<?php

// Створення таблиці налаштувань сайту.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('setting_key', 100)->unique('setting_key');
            $table->text('setting_value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
