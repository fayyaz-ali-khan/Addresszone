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
        $query=Blog::query()->when(request('category'), function($q){
            $q->whereHas('category', function($q2){
                $q2->where('slug', request('category'));
            });
        });
        $blogs = QueryBuilder::for($query)
            ->active()
            ->allowedIncludes(['category', 'user', 'comments', 'comments.user'])
            ->defaultSort('-id')
            ->allowedSorts(['title', 'created_at'])
            ->allowedFilters(['title', 'slug'])->paginate(12);

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
            ->withCount('comments') 
            ->firstOrFail();

        return new BlogResource($blog);
    }
}
