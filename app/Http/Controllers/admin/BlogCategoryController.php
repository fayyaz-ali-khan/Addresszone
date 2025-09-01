<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BlogCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return $this->getCategoryDatatable();
        }

        return view('admin.blog_categories.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:blog_categories,name',
            'description' => 'nullable|max:500',
        ]);

        $data['status'] = $request->boolean('status');
        $data['slug'] = Str::slug($request->name);

        BlogCategory::create($data);

        return response()->json(['success' => true, 'message' => 'Category Created successfully.']);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:blog_categories,name,'.$blogCategory->id,
            'description' => 'nullable|max:500',
        ]);

        $data['status'] = $request->boolean('status');
        $data['slug'] = Str::slug($request->name);

        $blogCategory->update($data);

        return response()->json(['success' => true, 'message' => 'Category Updated successfully.']);
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    private function getCategoryDataTable()
    {

        $query = BlogCategory::query()->orderByDesc('id');

        return DataTables::of($query)
            ->editColumn('description', function ($row) {
                return '<span title="'.$row->description.'">'.substr($row->description, 0, 36).'</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('created_by', function ($row) {
                return $row->createdBy ? $row->createdBy->name : 'N/A';
            })->editColumn('status', function ($row) {
                return $row->status == 0 || $row->user_id ? '<span class="badge bg-danger-light">Expired</span>' : '<span class="badge bg-primary-light">Active</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">
                    <a 
                        class="badge bg-success edit-btn mr-2" 
                        data-toggle="modal" 
                        data-target="#blog-category-model" 
                        data-url="'.route('admin.blog-categories.update', $row->id).'"
                        data-name="'.$row->name.'"
                        data-description="'.$row->description.'"
                        data-status="'.$row->status.'">
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-category" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['status', 'actions', 'description'])
            ->make(true);
    }
}
