<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Get a setting value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("setting.{$key}", 3600, function () use ($key) {
            return Setting::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return $setting->getCastedValue();
    }

    /**
     * Set a setting value.
     */
    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'type' => $type,
                'group' => $group,
            ]
        );

        $setting->setCastedValue($value);
        $setting->save();

        Cache::forget("setting.{$key}");
    }

    /**
     * Get all settings by group.
     */
    public function getByGroup(string $group): array
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return Setting::where('group', $group)
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->getCastedValue()];
                })
                ->toArray();
        });
    }

    /**
     * Set multiple settings at once.
     */
    public function setMultiple(array $settings, string $group = 'general'): void
    {
        foreach ($settings as $key => $value) {
            $type = $this->inferType($value);
            $this->set($key, $value, $type, $group);
        }

        Cache::forget("settings.group.{$group}");
    }

    /**
     * Infer the type from the value.
     */
    protected function inferType(mixed $value): string
    {
        return match (true) {
            is_bool($value) => 'boolean',
            is_int($value) => 'integer',
            is_array($value) => 'json',
            default => 'string',
        };
    }

    /**
     * Clear settings cache.
     */
    public function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Get all settings.
     */
    public function all(): array
    {
        return Setting::all()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->getCastedValue()];
            })
            ->toArray();
    }

    /**
     * Delete a setting.
     */
    public function delete(string $key): void
    {
        Setting::where('key', $key)->delete();
        Cache::forget("setting.{$key}");
    }
}
