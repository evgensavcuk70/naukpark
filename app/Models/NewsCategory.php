<?php

// Модель категорії новин.
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';

    protected $fillable = ['name_ua', 'name_en', 'slug'];

    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }

    public function getName(string $lang = 'ua'): string
    {
        return $this->{"name_{$lang}"} ?? $this->name_ua;
    }
}
