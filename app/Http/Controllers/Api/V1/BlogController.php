<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Spatie\QueryBuilder\QueryBuilder;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = QueryBuilder::for(Blog::class)
            ->active()
            ->allowedIncludes(['category', 'user', 'comments', 'comments.user'])
            ->defaultSort('-id')
            ->allowedSorts(['title', 'created_at'])
            ->allowedFilters(['title', 'slug'])->get();

        return BlogResource::collection($blogs);

    }

    public function show($param)
    {
        $blog = QueryBuilder::for(Blog::class)
            ->where(function ($query) use ($param) {
                $query->where('slug', $param)->orWhere('id', $param);
            })
            ->active()
            ->allowedIncludes(['category', 'user', 'comments', 'comments.user'])
            ->firstOrFail();

        return new BlogResource($blog);
    }
}
