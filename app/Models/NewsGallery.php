<?php

// Модель фотографії з галереї новини.
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsGallery extends Model
{
    protected $table = 'news_gallery';

    protected $fillable = ['news_id', 'image_path'];

    public $timestamps = false;

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
