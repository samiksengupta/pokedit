<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PokeApiService; // Import the service

class PokeApiResourceController extends Controller
{
    protected $pokeApiService;

    /**
     * Constructor to inject the PokeApiService.
     *
     * @param PokeApiService $pokeApiService
     */
    public function __construct(PokeApiService $pokeApiService)
    {
        $this->pokeApiService = $pokeApiService;
    }

    /**
     * Fetch resources from the PokeAPI.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $resourceType = $request->query('type', null);
        $offset = (int) $request->query('offset', 0);
        $limit = (int) $request->query('limit', 20);
        $resources = $this->pokeApiService->fetchResources($resourceType, $offset, $limit);

        return response()->json($resources);
    }

    /**
     * Fetch resources from the PokeAPI.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $type, string $name)
    {
        $processed = $this->pokeApiService->processResource($type, $name);

        return response()->json(['processed' => $processed]);
    }
}
