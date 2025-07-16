<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comment::query();

        if ($request->has('dish_id')) {
            $query->where('dish_id', $request->dish_id);
        }

        return response()->json([
            CommentResource::collection($query->latest()->get()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'dish_id' => $validated['dish_id'],
            'user_id' => auth()->check() ? auth()->id() : null,
            'author_name' => auth()->check() ? auth()->user()->name : $validated['author_name'],
            'content' => $validated['content'],
        ]);

        return response()->json(new CommentResource($comment), 201);
        /*        return response()->json([
                    'message' => 'Comment created successfully',
                    'data' => new CommentResource($comment),
                ], 201); */

    }

    /**
     * Display the specified resource.ц
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
