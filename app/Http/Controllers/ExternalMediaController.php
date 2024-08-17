<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalMediaController extends Controller
{
    public function __invoke(Request $request)
    {
        $imageUrl = $request->query('url');

        if (! filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        $response = Http::get($imageUrl);

        if ($response->successful()) {
            return response($response->body())->header('Content-Type', $response->header('Content-Type'));
        }

        return response()->json(['error' => 'Image not found'], 404);
    }
}
