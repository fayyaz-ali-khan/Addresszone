<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryResource;
use App\Models\BlogCategory;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Blog;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = QueryBuilder::for(BlogCategory::class)
            ->active()
            ->allowedIncludes(['blogs', 'blogs.user'])
            ->allowedFilters(['name', 'slug'])->get();
        return BlogCategoryResource::collection($categories);
    }

    public function show($param)
    {
        $blogCategory = QueryBuilder::for(BlogCategory::class)
            ->where(function ($query) use ($param) {
                $query->where('slug', $param)->orWhere('id', $param);
            })
            ->active()
            ->allowedIncludes(['blogs', 'blogs.user', 'blogs.comments', 'blogs.comments.user'])
            ->firstOrFail();

        return new BlogCategoryResource($blogCategory);
    }
}
