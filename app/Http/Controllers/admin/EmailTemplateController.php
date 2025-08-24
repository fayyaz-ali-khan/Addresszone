<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\EmailTemplate;
use Illuminate\Validation\Rules\Email;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->getCouponDataTable();
        }
        return view('admin.email_templates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates_categories=getEmailTemplates();
        return view('admin.email_templates.create',compact('templates_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $email_templates=getEmailTemplates();
        $email_templates=array_keys($email_templates);
        $validated = $request->validate([
            'subject' => 'required|unique:email_templates,subject',
            'body' => 'required',
            'status'=>'required|boolean',
            'category' => 'required|in:'.implode(',', $email_templates),
        ]);

        EmailTemplate::create($validated);

        toastr()->success('Email template created successfully');

        return to_route('admin.email_templates.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $templates_categories=getEmailTemplates();
        $templates_categories=array_keys($templates_categories);
        $assigned_category=EmailTemplate::pluck('category')->toArray();
        $available_categories=array_diff($templates_categories,$assigned_category);
        $available_categories[]=$emailTemplate->category;
        $templates_categories=getEmailTemplates();
        return view('admin.email_templates.edit',compact('emailTemplate','templates_categories','available_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'subject' => 'required|unique:email_templates,subject,'.$emailTemplate->id,
            'body' => 'required',
            'status'=>'required|boolean',
            'category' => 'required|in:'.implode(',', array_keys(getEmailTemplates())),
        ]);

        $emailTemplate->update($validated);

        toastr()->success('Email template updated successfully');

        return to_route('admin.email_templates.index');
    }


    
    private function getCouponDataTable()
    {

        $query = EmailTemplate::query()->latest();

        return DataTables::of($query)
            ->editColumn('category', function ($row) {
                return ucwords(str_replace('_', ' ', $row->category));
            })
            ->editColumn('status', function ($row) {
                return $row->status == 0 ? '<span class="badge bg-danger-light">Deactive</span>' : '<span class="badge bg-primary-light">Active</span>';
            })

            ->addColumn('actions', function ($row) {
                return '
                    <a 
                        class="badge bg-success edit-btn mr-2" 
                        
                        href="'.route('admin.email_templates.edit', $row->id).'"
                        >
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                  ';
            })
            ->rawColumns([ 'status', 'actions'])
            ->make(true);
    }
}
