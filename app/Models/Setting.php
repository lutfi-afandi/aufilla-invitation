<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public const CACHE_KEY = 'app_settings_all';
    public const CACHE_TTL = 86400; // 24 hours

    /**
     * Get all settings cached as a key-value associative array.
     */
    public static function getAllCached(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a setting value with a fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = self::getAllCached();

        if (array_key_exists($key, $settings) && $settings[$key] !== null && $settings[$key] !== '') {
            return $settings[$key];
        }

        return $default;
    }

    /**
     * Get a setting value decoded from JSON.
     */
    public static function getJson(string $key, array $default = []): array
    {
        $val = self::get($key);

        if (is_string($val)) {
            $decoded = json_decode($val, true);
            return is_array($decoded) ? $decoded : $default;
        }

        return is_array($val) ? $val : $default;
    }

    /**
     * Set a setting value and clear cache.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        if (is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        self::clearCache();

        return $setting;
    }

    /**
     * Clear the cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
