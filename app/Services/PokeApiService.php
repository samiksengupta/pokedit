<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokeApiService
{
    protected $baseUrl = 'https://pokeapi.co/api/v2/';

    /**
     * Fetch a list of resources from the PokeAPI with caching.
     *
     * @param string $resourceType
     * @return array
     */
    public function fetchResources(?string $resourceType = null, ?int $offset = 0, ?int $limit = 20): array
    {
        $baseUrl = $this->baseUrl;
        
        if ($resourceType) {
            $baseUrl .= $resourceType . '/';
            if ($offset && $limit) {
                $baseUrl .= sprintf('?offset=%s&limit=%s', $offset, $limit);
            }
        }

        $cacheKey = $this->generateCacheKey($baseUrl);

        // Cache::forget($cacheKey); // Clear the cache for the resource type

        // Check if the data is already cached
        return $this->getCached($cacheKey, function () use ($baseUrl, $resourceType) {
            $response = Http::get($baseUrl);
            
            if ($response->successful()) {
                if ($resourceType) {
                    $isUnnamedId = $this->hasUnnamedIds($resourceType);
                    return collect($response->json())->mapWithKeys(fn ($value, $key) => 
                        $key === 'results' ? [
                            $key => collect($value)->map(fn ($result, $key) => [
                                'id' => $isUnnamedId || !isset($result['name']) ? basename($result['url']) : $result['name'],
                                'url' => $result['url']
                            ])->values()->toArray()
                        ] : [$key => $value]
                    )->toArray();
                } else {
                    // If it's the index, we need to fetch the list of resources
                    return $this->sortResourceIndex(collect($response->json())->map(fn ($value, $key) => [
                        'key' => $key,
                        'url' => $value
                    ])
                    ->values()
                    ->toArray());
                }
                
            }

            return [];
        });
    }

    public function importResource(string $resourceType, string $resourceId): bool
    {
        $baseUrl = $this->baseUrl;
        
        if ($resourceType) {
            $baseUrl .= $resourceType . '/';
        }

        if ($resourceId) {
            $baseUrl .= $resourceId . '/';
        }

        $cacheKey = $this->generateCacheKey($baseUrl);

        $payload = $this->getCached($cacheKey, function () use ($baseUrl) {
            $response = Http::get($baseUrl);
            if ($response->successful()) {
                return json_decode($response->body(), false);
            }
            return null;
        });

        if ($payload) {
            return PokeApiImporter::import($resourceType, $resourceId, $payload);
        }

        return false;
    }

    public function deleteResource(string $resourceType): bool
    {
        return PokeApiImporter::truncate($resourceType);
    }

    public function clearCache(string $resourceType): void
    {
        $baseUrl = $this->baseUrl . $resourceType . '/';
        $cacheKey = $this->generateCacheKey($baseUrl);
        Cache::forget($cacheKey);
    }

    private function generateCacheKey(?string $baseUrl): string
    {
        return 'pokeapi_' . md5($baseUrl);
    }

    private function sortResourceIndex(array $resources): array
    {
        $ordering = collect(['language', 'generation', 'ability', 'type', 'move-damage-class', 'contest-type', 'move-target', 'move', 'move-learn-method', 'egg-group', 'growth-rate', 'pokemon-habitat', 'pokemon-shape', 'pokemon-color', 'pokemon-species']);
        return collect($resources)->filter(function($value, $key) use($ordering) {
            return $ordering->contains($value['key']);
        })->sortBy(function($value) use($ordering) {
            return $ordering->search($value['key']);
        })->values()->toArray();
    }

    private function hasUnnamedIds($resourceType): bool
    {
        return in_array($resourceType, ['language', 'characteristic', 'contest-effect', 'evolution-chain', 'machine', 'super-contest-effect']);
    }

    // Get the response of a callback through a caching layer
    private function getCached(string $cacheKey, \Closure $callback, $fresh = false): mixed
    {
        if ($fresh) {
            Cache::forget($cacheKey); // Clear the cache for the resource type
        }
        $cacheTime = \App\Models\Setting::find('app.api.cache')->value ?? 30;
        return $cacheTime > 0 ? Cache::remember($cacheKey, $cacheTime, $callback) : Cache::rememberForever($cacheKey, $callback);
    }
}