<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function showFavorites() {
        $favorites = Favorite::where('user_id', Auth::id())->get();
        return response()->json($favorites);
    }

    public function storeFavorites(Request $request) {
        $request->validate(['mal_id' => 'required|integer']);

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'mal_id' => $request->mal_id,
        ]);

        return response()->json($favorite, 201);
    }
    public function destroyFavorites($mal_id) {
        $favorite = Favorite::where('mal_id', $mal_id)
            ->where('user_id', Auth::id())
            ->firstOfFail();

        $favorite->delete();

        return response()->json(null, 204);
    }
}
