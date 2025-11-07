<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Document;

use App\Http\Resources\DocumentResource;
use Illuminate\Support\Facades\Storage;


class DocumentController
{

    public function getMyDocuments()
    {

        $documents = Document::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        return response()->json(['data' => DocumentResource::collection($documents)]);
    }

    function downloadMyDocument($id)
    {
        $document = Document::where([['id', $id], ['user_id', auth()->user()->id]])->value('document_file');

        if (!$document) {
            return response()->json(['message' => 'Document not exist to download'], 404);
        }

        if (Storage::exists($document)) {
            return Storage::download($document);
        }
    }
}
