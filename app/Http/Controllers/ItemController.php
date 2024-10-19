<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    public function getTitel ($mal_id) {
        $response = Http::withOptions(['verify' => false])->get("https://api.jikan.moe/v4/anime/{$mal_id}");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
}