<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function showTitels (Request $request)
    {
        $page = $request->query('page', 1);
        $response = Http::withOptions(['verify' => false])->get("https://api.jikan.moe/v4/top/anime?page={$page}");

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }

    public function showSeasonTitels ()
    {
        $response = Http::withOptions(['verify' => false])->get('https://api.jikan.moe/v4/seasons/now');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }

    public function showLastTitels ()
    {
        $response = Http::withOptions(['verify' => false])->get('https://api.jikan.moe/v4/top/anime');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
}
