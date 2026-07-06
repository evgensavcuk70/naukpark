<?php

// Модель можливості Наукового парку.
namespace App\Models;

use App\Models\Concerns\HasContentLimits;
use Illuminate\Database\Eloquent\Model;

class Capability extends Model
{
    use HasContentLimits;

    protected $table = 'capabilities';

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

    public function scopeOrdered($query)
    {
        return $query->where('is_visible', true)->orderBy('sort_order');
    }

    public function getDescription(string $lang = 'ua'): string
    {
        return $this->{"description_{$lang}"} ?? $this->description_ua;
    }

    public function getIconUrlAttribute(): string
    {
        $icon = $this->icon_path ?: 'cap1.svg';
        if (!str_contains($icon, 'images/')) {
            $icon = 'images/' . $icon;
        }
        return asset($icon);
    }
}
