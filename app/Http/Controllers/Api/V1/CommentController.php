<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'comment' => ['required'],
            'blog_id' => ['required', 'exists:blogs,id'],
        ]);
        $data['user_id'] = auth()->user()->id;
        return response()->json(['message' => 'Comment created successfully', 'data' => new CommentResource(Comment::create($data))], 201);
    }

    public function show(Comment $comment)
    {
        $comment = QueryBuilder::for(Comment::class)
            ->where('id', $comment->id)
            ->allowedIncludes(['blog', 'user', 'blog.category'])->firstOrFail();

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json();
    }

}
