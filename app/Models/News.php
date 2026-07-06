<?php

// Модель новини.
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Support\HtmlSanitizer;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'category_id',
        'title_ua', 'title_en',
        'excerpt_ua', 'excerpt_en',
        'content_ua', 'content_en',
        'slug',
        'image_main',
        'is_archived',
        'is_pinned',
        'published_at',
        'meta_title_ua', 'meta_title_en',
        'meta_description_ua', 'meta_description_en',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_archived'  => 'boolean',
        'is_pinned'    => 'boolean',
    ];

    public function setContentUaAttribute(?string $value): void
    {
        $this->attributes['content_ua'] = HtmlSanitizer::clean($value);
    }

    public function setContentEnAttribute(?string $value): void
    {
        $this->attributes['content_en'] = HtmlSanitizer::clean($value);
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function gallery()
    {
        return $this->hasMany(NewsGallery::class, 'news_id')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_archived', 0)
            ->where('published_at', '<=', now());
    }

    public function getTitle(string $lang = 'ua'): string
    {
        $val = $this->{"title_{$lang}"};
        return (!empty($val)) ? $val : $this->title_ua;
    }

    public function getContent(string $lang = 'ua'): string
    {
        $val = $this->{"content_{$lang}"};
        return (!empty($val)) ? $val : $this->content_ua;
    }

    public function getMetaTitle(string $lang = 'ua'): string
    {
        $val = $this->{"meta_title_{$lang}"};
        return (!empty($val)) ? $val : $this->getTitle($lang);
    }

    public function getMetaDescription(string $lang = 'ua'): string
    {
        $val = $this->{"meta_description_{$lang}"};
        if (!empty($val)) return $val;
        return mb_strimwidth(strip_tags($this->getContent($lang)), 0, 160, '...');
    }

    public function getShortDesc(string $lang = 'ua', int $length = 160): string
    {
        return mb_strimwidth(strip_tags($this->getContent($lang)), 0, $length, '...');
    }

    public function getFormattedDate(string $lang = 'ua'): string
    {
        if (!$this->published_at) return '';

        if ($lang === 'ua') {
            $months = [
                1  => 'січня', 2  => 'лютого',  3  => 'березня',
                4  => 'квітня', 5  => 'травня',  6  => 'червня',
                7  => 'липня',  8  => 'серпня',  9  => 'вересня',
                10 => 'жовтня', 11 => 'листопада', 12 => 'грудня',
            ];
            return $this->published_at->day . ' '
                . $months[$this->published_at->month] . ' '
                . $this->published_at->year;
        }

        return $this->published_at->format('F j, Y');
    }

    public function getImageUrlAttribute(): string
    {
        $img = $this->image_main ?: 'photo1.jpg';
        return asset('images/' . $img);
    }

    public static function generateSlug(string $title): string
    {
        $text = mb_strtolower($title, 'UTF-8');

        $ukr = ['а','б','в','г','ґ','д','е','є','ж','з','и','і','ї','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ю','я'];
        $lat = ['a','b','v','g','g','d','e','ye','zh','z','y','i','yi','y','k','l','m','n','o','p','r','s','t','u','f','kh','ts','ch','sh','shch','','yu','ya'];

        $text = str_replace($ukr, $lat, $text);
        $text = preg_replace('/[^a-z0-9\-]+/', '-', $text);

        return trim($text, '-');
    }
}
