<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Spatie\QueryBuilder\QueryBuilder;

class ServiceController extends Controller
{
    public function index()
    {
        $services = QueryBuilder::for(Service::class)
            ->active()
            ->allowedIncludes('category')
            ->allowedFilters('name')->paginate();

        return ServiceResource::collection($services);
    }

    public function show(Service $service)
    {
        if (request()->query('include') === 'category') {
            $service->load('category');
        }

        return new ServiceResource($service);
    }
}
