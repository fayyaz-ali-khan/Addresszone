<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\SendNotificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.send_notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.send_notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'subject' => 'required|max:255',
            'message' => 'required',
            'send_to' => 'required|in:all,specific,subscribers',
            'attachements.*' => 'nullable|file|mimes:jpg,png,jpeg,pdf,doc,docx,xls,xlsx,txt|max:20480',
        ];

        if ($request->send_to == 'specific') {
            $rules['email'] = 'required|email';
        }
        if ($request->send_to == 'subscribers') {
            $rules['status'] = 'required|in:all,1,0';
        }

        $data = $request->validate($rules);
        $recipients = [];

        if ($data['send_to'] == 'specific') {
            $recipients[] = $data['email'];
        } elseif ($data['send_to'] == 'subscribers') {
            // Send to subscribers based on status
            if ($data['status'] == 'all') {
                $recipients = User::where('is_subscribed', true)->pluck('email')->toArray();
            } else {
                $status = $data['status'] == '1' ? true : false;
                $recipients = User::where('is_subscribed', $status)->pluck('email')->toArray();
            }
        } else {
            $recipients = User::where('id', Auth::user()->id)->pluck('email')->toArray();
        }

        foreach ($recipients as $email) {
            Mail::to($email)->send(new SendNotificationMail(subject: $data['subject'], message_body: $data['message'], attachment_files: $request->file('attachements')));
        }

        toastr()->success('Notification sent successfully');

        return to_route('admin.send-notifications.index', status: 301);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
