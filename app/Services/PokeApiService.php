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
        // dump($baseUrl, $cacheKey);

        Cache::forget($cacheKey); // Clear the cache for the resource type

        // Check if the data is already cached
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($baseUrl, $resourceType) {
            $response = Http::get($baseUrl);
            
            if ($response->successful()) {
                if ($resourceType) {
                    return collect($response->json())->mapWithKeys(fn ($value, $key) => 
                        $key === 'results' ? [
                            $key => collect($value)->map(fn ($result, $key) => [
                                'id' => $result['name'] ?? basename($result['url']),
                                'url' => $result['url']
                            ])->values()->toArray()
                        ] : [$key => $value]
                    )->toArray();
                } else {
                    // If it's the index, we need to fetch the list of resources
                    return collect($response->json())->map(fn ($value, $key) => [
                        'key' => $key,
                        'url' => $value
                    ])
                    ->values()
                    ->toArray();
                }
                
            }

            return [];
        });
    }

    public function processResource(string $resourceType, string $resourceName): bool
    {
        $baseUrl = $this->baseUrl;
        
        if ($resourceType) {
            $baseUrl .= $resourceType . '/';
        }

        if ($resourceName) {
            $baseUrl .= $resourceName . '/';
        }

        return true;
    }

    private function generateCacheKey(?string $baseUrl): string
    {
        return 'pokeapi_' . md5($baseUrl);
    }
}