<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityDirection extends Model
{
    protected $fillable = [
        'icon_path',
        'title_ua',
        'title_en',
        'description_ua',
        'description_en',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
