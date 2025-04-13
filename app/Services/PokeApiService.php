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
    public function fetchResources(?string $type = null): array
    {
        $baseUrl = $this->baseUrl;
        $resourceType = 'index';
        
        if ($type) {
            $resourceType = $type;
            $baseUrl .= $resourceType . '/';
        }

        // Cache key based on the resource type
        $cacheKey = "pokeapi_{$resourceType}";

        // Cache::forget($cacheKey); // Clear the cache for the resource type

        // Check if the data is already cached
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($baseUrl, $resourceType) {
            $response = Http::get($baseUrl);

            if ($response->successful()) {
                if ($resourceType === 'index') {
                    // If it's the index, we need to fetch the list of resources
                    return collect($response->json())->map(fn ($value, $key) => [
                        'key' => $key,
                        'url' => $value,
                        'resources' => [],
                    ])
                    ->values()
                    ->toArray();
                } else {
                    return collect($response->json())
                    ->toArray();
                }
                
            }

            return [];
        });
    }

    public function fetchResourceMap(): array
    {
        $resources = collect($this->fetchResources());

        return $resources->map(function ($value, $key) {
            $resourceName = $key;
            $resourceUrl = $value;

            // Fetch the resource details (children)
            $resourceDetails = $this->fetchResources($resourceName);

            // Return the transformed structure
            return [
                'key' => $resourceName,
                'url' => $resourceUrl,
                'resources' => $resourceDetails,
            ];
        })->values()->toArray();
    }
}