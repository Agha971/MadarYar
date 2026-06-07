<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['data'];

    protected $casts = [
        'data' => 'array',
    ];

    public static function get($key, $default = null)
    {
        $settings = cache()->rememberForever('settings', function () {
            return static::first()?->data ?? [];
        });

        return $settings[$key] ?? $default;
    }

    public static function setAll($data)
    {
        $settings = static::firstOrCreate(['id' => 1]);

        $settings->data = $data;
        $settings->save();

        cache()->forget('settings');
    }
}
