<?php

// Додавання зовнішнього ключа до таблиці фотогалереї новин.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('news_galleries', function (Blueprint $table) {
            $table->foreign(['news_id'], 'news_galleries_ibfk_1')->references(['id'])->on('news')->onUpdate('no action')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('news_galleries', function (Blueprint $table) {
            $table->dropForeign('news_galleries_ibfk_1');
        });
    }
};
