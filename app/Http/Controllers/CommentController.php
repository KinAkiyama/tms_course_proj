<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function showComments($mal_id)
    {
        $comments = Comment::with('user')
                            ->where('title_mal_id', $mal_id)
                            ->get();
        return response()->json($comments);
    }

    public function createComment(Request $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'title_mal_id' => $request->mal_id,
            'description' => $request->description,
        ]);

        return response()->json($comment, 200);
    }

    public function updateComment (Request $request, $mal_id, $id)
    {
        $uuid = (string) $id;
        $comment = Comment::where('id', $uuid)->where('title_mal_id', $mal_id)->first();

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $comment->description = $request->input('description');
        $comment->save();
        return response()->json(['message' => 'Comment updated successfully', 'comment'=>$comment], 200);
    }

    public function destroyComment($mal_id, $id)
    {
        $uuid = (string) $id;
        $comment = Comment::where('id', $uuid)->where('title_mal_id', $mal_id)->first();

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
