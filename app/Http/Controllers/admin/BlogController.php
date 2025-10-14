<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    use FileHandler;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->getBlogDatatable();
        }

        return view('admin.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->get();

        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|exists:blog_categories,id',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['status'] = $request->boolean('status');
        $data['blog_category_id'] = $data['category'];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $this->storeFile($request->file('image'), 'images/blogs');
        }

        Blog::create($data);
        toastr()->success('Blog created successfully');

        return to_route('admin.blogs.index', status: 301);
    }

    /**
     * Display the specified resource.
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
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::active()->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|max:255|unique:blogs,title,'.$blog->id,
            'category' => 'required|exists:blog_categories,id',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:10000',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['status'] = $request->boolean('status');
        $data['blog_category_id'] = $data['category'];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($blog->image) {
                $this->deleteFile($blog->image);
            }
            $data['image'] = $this->storeFile($request->file('image'), 'images/blogs');
        }

        $blog->update($data);
        toastr()->success('Blog updated successfully');

        return to_route('admin.blogs.index', status: 301);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            $this->deleteFile($blog->image);
        }
        $blog->delete();

        return response()->json(['status' => true, 'message' => 'Blog deleted successfully']);
    }

    private function getBlogDatatable()
    {

        $query = Blog::query()->with('category:id,name')->orderByDesc('id');

        return DataTables::of($query)
            ->editColumn('title', function ($row) {
                return '<span title="'.$row->title.'">'.substr($row->title, 0, 36).'</span>';
            })
            ->editColumn('image', function ($row) {
                return '<img class="rounded img-fluid avatar-40" src="'.asset('storage/'.$row->image ?? '').'" alt="profile">';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('status', function ($row) {
                return $row->status == 0 || $row->user_id ? '<span class="badge bg-danger-light">Inactive</span>' : '<span class="badge bg-primary-light">Active</span>';
            })
            ->addColumn('category', function ($row) {
                return $row->category->name;
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">
                    <a
                        class="badge bg-success edit-btn mr-2"
                        href="'.route('admin.blogs.edit', $row->id).'"
                    >
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-blog" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['status', 'actions', 'title', 'image'])
            ->make(true);
    }
}
