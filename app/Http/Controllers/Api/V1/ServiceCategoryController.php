<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = QueryBuilder::for(ServiceCategory::class)
            ->active()
            ->allowedIncludes('services')
            ->allowedFilters('name')->get();

        return ServiceCategoryResource::collection($categories);
    }

    public function show(Request $request, ServiceCategory $serviceCategory)
    {
        if ($request->query('include') === 'services') {
            $serviceCategory->load('services');
        }

        return new ServiceCategoryResource($serviceCategory);
    }
}
