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
    public function resource(Request $request)
    {
        $type = $request->query('type', null);
        $resources = $this->pokeApiService->fetchResources($type);

        return response()->json($resources);
    }
}
