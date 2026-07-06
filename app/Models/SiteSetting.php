<?php

// Модель налаштувань сайту (контакти, соцмережі).
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['setting_key', 'setting_value'];

    public $timestamps = false;

    public static function allKeyed(): array
    {
        return Cache::remember('site_settings', 600, function () {
            return self::pluck('setting_value', 'setting_key')->toArray();
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::allKeyed()[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
        Cache::forget('site_settings');
    }
}
