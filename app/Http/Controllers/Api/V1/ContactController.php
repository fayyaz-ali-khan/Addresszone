<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __invoke(Request $request):JsonResponse
    {
        $data=$request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        Contact::create($data);

        return response()->json(['message' => 'Contact created successfully']);

    }
}
