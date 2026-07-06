<?php

// Модель слайду головного слайдера.
namespace App\Models;

use App\Models\Concerns\HasContentLimits;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasContentLimits;

    protected $table = 'slides';

    protected $fillable = [
        'image_path',
        'title_ua',
        'title_en',
        'sort_order',
        'is_active',
    ];

    public $timestamps = false;

    public static function visibilityColumn(): string
    {
        return 'is_active';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): string
    {
        $path = $this->image_path;
        if (!str_contains($path, 'images/')) {
            $path = 'images/' . $path;
        }
        return asset($path);
    }
}
