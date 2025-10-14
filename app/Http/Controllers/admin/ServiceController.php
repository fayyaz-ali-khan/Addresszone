<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    use FileHandler;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->getServicesDataTable();
        }

        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        $service_categories = ServiceCategory::where('status', 1)->get();

        return view('admin.services.create', compact('service_categories'));
    }

    public function edit(Service $service)
    {
        $service_categories = ServiceCategory::where('status', 1)->get();

        return view('admin.services.edit', compact('service', 'service_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $this->getServiceData($request, $request->validate($this->getValidationRules()));

        if (! $data['status']) {
            toastr()->error($data['message']);

            return redirect()->back();
        }
        Service::create($data['data']);
        toastr()->success('Service created successfully');

        return redirect()->route('admin.services.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $rules = $this->getValidationRules();
        $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg';

        $data = $this->getServiceData($request, $request->validate($rules));
        if (! $data['status']) {
            toastr()->error($data['message']);

            return redirect()->back();
        }
        $service->update($data['data']);
        toastr()->success('Service updated successfully');

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->deleteFile($service->image);
        $service->delete();

        return response()->json(['status' => true, 'message' => 'Service deleted successfully']);
    }

    private function getServiceData(Request $request, array $validated = []): array
    {

        $service = Service::whereNot('id', $request->service?->id ?? '')->where('service_category_id', $validated['service_category_id'])->where('title', $validated['title'])->exists();
        if ($service) {
            return ['status' => false, 'message' => 'Service already exists in this category'];
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->isMethod('PUT') && $request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $this->updateFile($request->file('image'), $service->image, 'admin/services');
        }
        if ($request->isMethod('POST') && $request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $this->storeFile($request->file('image'), 'admin/services');
        }

        return ['status' => true, 'data' => $validated];
    }

    private function getValidationRules(): array
    {
        return [
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'months' => 'required|numeric',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }

    private function getServicesDataTable()
    {

        $query = Service::query()->with('category')->select('id', 'title', 'service_category_id', 'price', 'months', 'status', 'image')->latest();

        return DataTables::of($query)
            ->editColumn('status', function ($row) {
                return $row->status == 0 ? '<span class="badge bg-danger-light">Deactive</span>' : '<span class="badge bg-primary-light">Active</span>';
            })->editColumn('image', function ($row) {
                return '<div class="iq-avatar">
                           <img class="avatar-70 rounded" src="'.asset('storage/'.$row->image).'" alt="#" data-original-title="" title="">
                        </div>';
            })
            ->editColumn('category', function ($row) {

                return $row->category->name;
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center justify-content-end list-action">
                    <a
                        class="badge bg-success edit-btn mr-2"
                        href="'.route('admin.services.edit', $row->id).'"
                        >
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-service" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['image', 'description', 'status', 'actions'])
            ->make(true);
    }
}
