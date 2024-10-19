<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function showTitels () {
        $response = Http::withOptions(['verify' => false])->get('https://api.jikan.moe/v4/top/anime');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
}
