<?php

namespace App\Http\Controllers\admin;

use App\Enums\CustomerVerificationStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Http\Resources\UserResource;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getCustomersDataTable();
        }

        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        if (request()->ajax()) {
            return response()->json(new UserResource($customer));
        }

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required:max:36',
            'last_name' => 'nullable|max:36',
            'mobile' => 'required|min:10|max:24',
            'company' => 'required|max:255',
            'status' => 'required|boolean',
            'address' => 'nullable|max:500',
        ]);

        $customer->update($validated);
        toastr()->success('Customer  updated successfully');

        return redirect()->route('admin.customers.index');
    }

    public function updateVerificationStatus(Request $request, User $customer)
    {
        $validated = $request->validate([
            'verification_status' => ['required', Rule::enum(CustomerVerificationStatus::class)],
            'verification_msg' => 'required|max:500',
        ], [
            'verification_msg.required' => 'Verification Note is required',
        ]);

        $customer->update($validated);
        toastr()->success('Customer  status updated successfully');

        return redirect()->route('admin.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['message' => 'Customer  deleted successfully']);
    }

    public function search(Request $request)
    {
        $users = User::where('name', 'like', "%{$request->term}%")
            ->orWhere('first_name', 'like', "%{$request->term}%")
            ->orWhere('last_name', 'like', "%{$request->term}%")
            ->orWhere('mobile', 'like', "%{$request->term}%")
            ->orWhere('email', 'like', "%{$request->term}%")
            ->limit(10)
            ->select('id', 'name', 'first_name', 'last_name', 'mobile', 'email')
            ->get();

        return response()->json($users);
    }

    private function getCustomersDataTable()
    {

        $query = User::query()->select('id', 'name', 'email', 'mobile', 'verification_status', 'created_at', 'image')->latest();

        return DataTables::of($query)
            ->editColumn('image', function ($row) {
                return '<img class="rounded img-fluid avatar-40" src="' . asset('admin/images/user/01.jpg') . '" alt="profile">';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at?->format('d-m-Y H:i');
            })
            ->editColumn('verification_status', function ($row) {
                if ($row->verification_status == CustomerVerificationStatus::NOT_VERIFIED->value) {
                    return '<span class="badge bg-warning-light">Not Verified</span>';
                }
                if ($row->verification_status == CustomerVerificationStatus::REJECTED->value) {
                    return '<span class="badge bg-danger-light">Rejected</span>';
                }
                if ($row->verification_status == CustomerVerificationStatus::VERIFIED->value) {
                    return '<span class="badge bg-success-light">Verified</span>';
                }

                return null;
            })

            ->addColumn('actions', function ($row) {
                return '

                
                <div class="d-flex align-items-center list-action">
                    <a 
                        class="badge bg-info detail-btn mr-2" 
                       
                        href="' . route('admin.customers.show', $row->id) . '"
                       >
                        <i class="ri-eye-line mr-0"></i>
                    </a>
                     <a 
                        class="badge bg-success edit-btn mr-2" 
                       
                        href="' . route('admin.customers.edit', $row->id) . '"
                       >
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-customer" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['image', 'verification_status', 'actions'])
            ->make(true);
    }
}
