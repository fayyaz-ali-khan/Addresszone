<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->getCouponDataTable();
        }

        return view('admin.service_categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:54|unique:service_categories,name',
            'description' => 'nullable|max:500',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        ServiceCategory::create($validated);

        return response()->json(['success' => true, 'message' => 'Service Category added successfully.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:54|unique:service_categories,name,' . $serviceCategory->id,
            'description' => 'nullable|max:500',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        $serviceCategory->update($validated);

        return response()->json(['success' => true, 'message' => 'Service Category updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        return response()->json(['success' => true, 'message' => 'Service Category deleted successfully.']);
    }

    private function getCouponDataTable()
    {

        $query = ServiceCategory::query()->latest();

        return DataTables::of($query)
            ->editColumn('description', function ($row) {
                return '<span title="' . $row->description . '">' . substr($row->description, 0, 36) . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('status', function ($row) {
                return $row->status == 0 ? '<span class="badge bg-danger-light">Deactive</span>' : '<span class="badge bg-primary-light">Active</span>';
            })

            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">
                    <a 
                        class="badge bg-success edit-btn mr-2" 
                        data-toggle="modal" 
                        data-target="#service-category-model" 
                        data-url="' . route('admin.service_categories.update', $row->id) . '"
                        data-name="' . $row->name . '"
                        data-description="' . $row->description . '"
                       
                        data-status="' . $row->status . '">
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-service-category" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['description', 'status', 'actions'])
            ->make(true);
    }
}
