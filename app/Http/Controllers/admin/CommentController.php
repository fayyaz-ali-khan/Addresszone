<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getCommentsDataTable();
        }

        return view('admin.comments.index');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['status' => true, 'message' => 'Comment deleted successfully']);
    }

    private function getCommentsDataTable()
    {

        $searchText = request('search.value');
        $query = Comment::query()
            ->with([
                'blog:id,title,image',
                'user:id,first_name,last_name,email',
            ])
            ->when($searchText, function ($query) use ($searchText) {
                $query->where(function ($query) use ($searchText) {
                    $query->where('comment', 'like', '%' . $searchText . '%');
                })->orWhereHas('blog', function ($query) use ($searchText) {
                    $query->where('title', 'like', '%' . $searchText . '%');
                })->orWhereHas('user', function ($query) use ($searchText) {
                    $query->where('first_name', 'like', '%' . $searchText . '%')
                        ->orWhere('last_name', 'like', '%' . $searchText . '%')
                        ->orWhere('email', 'like', '%' . $searchText . '%');
                });
            })
            ->orderByDesc('id');

        return DataTables::of($query)
            ->editColumn('comment', function ($row) {
                return '<span title="' . $row->comment . '">' . substr($row->comment, 0, 36) . '</span>';
            })
            ->addColumn('blog_title', function ($row) {
                return '<a href="' . route('admin.blogs.edit', $row->blog->id) . '?tab=comments" target="_blank" title="' . $row->blog->title . '">' . substr($row->blog->title, 0, 36) . '</span>';
            })
            ->addColumn('user_profile', function ($row) {

                $image = $row->user->image
                    ? asset('storage/' . $row->user->image)
                    : asset('admin/images/image-placeholder.png');
                $user_name = $row->user->first_name . ' ' . $row->user->last_name;
                $email = $row->user->email;
                $profile = ' <div class="d-flex align-items-center">
                                    <img src="' . $image . '" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                    <div>
                                        <a href="javascript:void(0);">' . $user_name . '</a>
                                        <p class="mb-0"><small>' . $email . '</small></p>
                                    </div>
                                </div>';
                return $profile;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">

                    <a class="badge bg-warning mr-2 delete-comment" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->only(['id', 'comment', 'blog_title', 'user_profile', 'created_at', 'actions'])
            ->rawColumns(['actions', 'comment', 'user_profile', 'blog_title'])
            ->make(true);
    }

}
