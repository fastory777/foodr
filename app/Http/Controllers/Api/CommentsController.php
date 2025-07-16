<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::query();

        if ($request->has('dish_id')) {
            $query->where('dish_id', $request->dish_id);
        }

        return CommentResource::collection($query->latest()->get());
    }

    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'dish_id' => $validated['dish_id'],
            'user_id' => auth()->id(),
            'author_name' => auth()->user()?->name ?? $validated['author_name'],
            'content' => $validated['content'],
        ]);

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}
