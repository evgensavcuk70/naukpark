<?php

// Додавання зовнішнього ключа до таблиці новин.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->foreign(['category_id'], 'news_ibfk_1')->references(['id'])->on('news_categories')->onUpdate('no action')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_ibfk_1');
        });
    }
};
