<?php

// Додавання індексів, яких бракувало під реальні запити застосунку:
// - news: News::published() фільтрує is_archived/published_at і сортує
//   за is_pinned/published_at на кожному запиті (головна, /news, sitemap.xml);
// - news_gallery: $news->gallery (hasMany) шукає за news_id без індексу.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->index(['is_archived', 'is_pinned', 'published_at'], 'news_archived_pinned_published_idx');
        });

        Schema::table('news_gallery', function (Blueprint $table) {
            $table->index('news_id', 'news_gallery_news_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('news_archived_pinned_published_idx');
        });

        Schema::table('news_gallery', function (Blueprint $table) {
            $table->dropIndex('news_gallery_news_id_idx');
        });
    }
};
