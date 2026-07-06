<?php

// Модель напряму діяльності.
namespace App\Models;

use App\Models\Concerns\HasContentLimits;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasContentLimits;

    protected $table = 'activities';

    protected $fillable = [
        'title_ua',
        'title_en',
        'description_ua',
        'description_en',
        'icon_path',
        'sort_order',
        'is_visible',
    ];

    public $timestamps = false;

    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1)->orderBy('sort_order');
    }

    public function getTitle(string $lang = 'ua'): string
    {
        return $this->{"title_{$lang}"} ?? $this->title_ua;
    }

    public function getDescription(string $lang = 'ua'): string
    {
        return $this->{"description_{$lang}"} ?? $this->description_ua;
    }
}
