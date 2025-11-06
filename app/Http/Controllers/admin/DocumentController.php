<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Traits\FileHandler;


class DocumentController extends Controller
{
    use FileHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->getDocumentsDataTable();
        }
        return view('admin.documents.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer' => 'required|exists:users,id',
            'document_title' => 'required|array',
            'document_title.*' => 'required|string|max:255',
            'documents' => 'required|array',
            'documents.*' => 'required|file',

        ]);

        foreach ($request->documents as $key => $document) {
            if ($document->isValid()) {
                $path = $this->storeFile($document, 'documents');
                $title = $request->document_title[$key];
                Document::create([
                    'user_id' => $validated['customer'],
                    'document_title' => $title,
                    'document_file' => $path,
                    'created_by' => Auth::id(),
                    'status' => true,
                ]);
            }
        }

        return response()->json(['status' => true, 'message' => 'Documents uploaded successfully']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'document_title' => 'required|max:500',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'reason' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('document_file')) {
            Storage::disk('public')->delete($document->document_file);
            $path = $request->file('document_file')->store('documents', 'public');
            $document->document_file = $path;
        }

        $document->update([
            'document_title' => $request->document_title,
            'reason' => $request->reason,
            'status' => $request->status ?? false,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $this->deleteFile($document->document_file);
        $document->delete();
        return response()->json(['message' => 'Document deleted successfully']);
    }


    public function getDocumentsDataTable()
    {
        $query = Document::with(['user:id,name,first_name,last_name', 'creator:id,name,first_name,last_name'])
            ->select('id', 'user_id', 'document_title', 'created_at', 'created_by')
            ->latest();

        return DataTables::of($query)
            ->addColumn('user', function ($row) {
                return $row->user->first_name . ' ' . $row->user->last_name ?? 'N/A';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at?->format('d-m-Y H:i');
            })
            ->addColumn('created_by', function ($row) {
                return $row->creator->name ?? ($row->creator->first_name . ' ' . $row->creator->last_name ?? 'N/A');
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">
                    <a 
                        class="badge bg-success edit-btn mr-2" 
                        href="' . route('admin.documents.edit', $row->id) . '"
                        title="Edit"
                    >
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a 
                        class="badge bg-warning mr-2 delete-document" 
                        data-id="' . $row->id . '" 
                        title="Delete"
                    >
                        <i class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
