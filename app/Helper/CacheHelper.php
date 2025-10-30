<?php

declare(strict_types=1);

namespace App\Helper;

use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

trait CacheHelper
{
    /**
     * Combine memoization + persistent cache with optional force refresh.
     *
     * @param string $key
     * @param \Closure $resolver
     * @param \DateTimeInterface|\DateInterval|int|null $ttl
     * @param bool $forceRefresh Force bypass both persistent & memory cache
     * @return mixed
     */
    public static function memoizedCache(
        string $key,
        Closure $resolver,
        DateTimeInterface|DateInterval|int|null $ttl = null,
        bool $forceRefresh = false
    ): mixed {
        $memo = Cache::memo();

        if (!$forceRefresh && $memo->has($key)) {
            return $memo->get($key);
        }

        if ($forceRefresh) {
            Cache::forget($key);
        }

        $value = is_null($ttl)
            ? Cache::rememberForever($key, $resolver)
            : Cache::remember($key, $ttl, $resolver);

        $memo->put($key, $value);

        return $value;
    }



    /**
     * Invalidate both persistent cache and in-request memoized cache.
     */
    public static function invalidateCache(string $key): void
    {
        Cache::forget($key);       // Invalidate persistent
        Cache::memo()->forget($key); // Invalidate in-memory
    }

    /**
     * Register a cache key in a dynamic group.
     */
    public static function trackCacheKey(string $group, string $key): void
    {
        $keys = Cache::get("tracked_keys:{$group}", []);
        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::forever("tracked_keys:{$group}", $keys);
        }
    }

    /**
     * Flush all cache keys tracked under a group.
     */
    public static function flushCacheGroup(string $group): void
    {
        $keys = Cache::get("tracked_keys:{$group}", []);
        foreach ($keys as $key) {
            self::invalidateCache($key);
        }
        Cache::forget("tracked_keys:{$group}");
    }


    /**
     * Boot automatiquement lors du chargement du modèle.
     */
    protected static function bootHasCachedModel(): void
    {
        static::saved(fn() => static::invalidateModelCache());
        static::deleted(fn() => static::invalidateModelCache());
    }

    /**
     * Appelle refreshCache() si défini dans le modèle.
     */
    protected static function refreshCacheIfDefined(): void
    {
        if (method_exists(static::class, 'refreshCache')) {
            static::refreshCache();
        }
    }

    /**
     * Invalide les clés de cache définies sur le modèle.
     */
    protected static function invalidateModelCache(): void
    {
        $class = get_called_class();

        if (property_exists($class, 'cacheKeys')) {
            $vars = get_class_vars($class);
            $keys = $vars['cacheKeys'] ?? [];

            foreach ($keys as $key) {
                self::invalidateCache($key);
            }
        }

        if (method_exists(static::class, 'afterCacheInvalidated')) {
            static::afterCacheInvalidated(); // Hook optionnel
        }
    }
}
