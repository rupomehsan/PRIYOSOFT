<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Management\SettingManagement\WebsiteSettings\Database\Models\Model as SettingTitle;

class SeoService
{
    public const CACHE_KEY = 'website_seo_settings';

    protected const CACHE_TTL = 600;

    protected const TITLES = [
        'meta_title', 'meta_description', 'meta_keywords', 'image', 'seo_image',
        'meta_tag', 'meta_schema_tag', 'canonical_url', 'site_name', 'fabicon',
    ];

    public static function all(): array
    {
        $raw = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return SettingTitle::query()
                ->whereIn('title', self::TITLES)
                ->active()
                ->with(['setting_values' => fn ($q) => $q->active()])
                ->get()
                ->mapWithKeys(fn ($item) => [$item->title => $item->setting_values->first()->value ?? ''])
                ->toArray();
        });

        $siteName = $raw['site_name'] ?: config('app.name');
        $title = $raw['meta_title'] ?: $siteName;
        $description = $raw['meta_description'] ?: "Welcome to {$siteName}.";
        $image = $raw['seo_image'] ?: ($raw['image'] ?? '');

        return [
            'site_name' => $siteName,
            'title' => $title,
            'description' => $description,
            'keywords' => $raw['meta_keywords'] ?? '',
            'image' => $image ? self::assetUrl($image) : '',
            'favicon' => ! empty($raw['fabicon']) ? self::assetUrl($raw['fabicon']) : null,
            'canonical' => $raw['canonical_url'] ?: url()->current(),
            'url' => url()->current(),
            'meta_tag' => $raw['meta_tag'] ?? '',
            'schema_tag' => $raw['meta_schema_tag'] ?? '',
        ];
    }

    protected static function assetUrl(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset(ltrim($path, '/'));
    }
}
