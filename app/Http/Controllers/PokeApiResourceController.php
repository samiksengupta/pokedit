<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PokeApiService; 

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
    public function index(Request $request): JsonResponse
    {
        $resourceType = $request->query('type', null);
        $offset = (int) $request->query('offset', 0);
        $limit = (int) $request->query('limit', 20);
        $resources = $this->pokeApiService->fetchResources($resourceType, $offset, $limit);

        return response()->json($resources);
    }

    /**
     * Import resources from the PokeAPI.
     *
     * @param Request $request
     * @param string $type
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, string $type, string $id): JsonResponse
    {
        $imported = $this->pokeApiService->importResource($type, $id);

        return response()->json(['imported' => $imported]);
    }

    public function destroy(Request $request, string $type): JsonResponse
    {
        $this->pokeApiService->clearCache($type);
        $this->pokeApiService->deleteResource($type);

        return response()->json(['message' => 'Resource cleared successfully.']);
    }
}
