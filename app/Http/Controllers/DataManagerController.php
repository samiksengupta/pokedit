<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class DataManagerController extends Controller
{
    public function reset(Request $request): JsonResponse
    {
        try {
            Artisan::call('native:migrate:fresh', [
                '--seed' => true,
            ]);
            return response()->json(['message' => 'Database has been reset successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to reset database.', 'error' => $e->getMessage()], 500);
        }
    }
}