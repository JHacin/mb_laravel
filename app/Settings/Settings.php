<?php

namespace App\Settings;

use Setting;

class Settings
{
    public static function get(string $key, string $fallback = ''): string
    {
        return Setting::get($key) ?? $fallback;
    }

    public static function set(string $key, string $value): string
    {
        return Setting::set($key, $value);
    }

    public static function hasValueTrue(string $key): bool
    {
        return self::get($key) === config('settings.value_true');
    }

    public static function setValueFalse(string $key): bool
    {
        return self::set($key, config('settings.value_false'));
    }
}
