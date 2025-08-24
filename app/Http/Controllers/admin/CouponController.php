<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (request()->ajax()) {
            return $this->getCouponDataTable();
        }

        return view('admin.coupons.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $validated = $request->validated();
        $validated['admin_id'] = Auth::guard('admin')->user()->id;
        Coupon::create($validated);

        return response()->json(['success' => true, 'message' => 'Coupon updated successfully.']);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return response()->json(['success' => true, 'message' => 'Coupon updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json(['success' => true, 'message' => 'Coupon deleted successfully.']);

    }

    private function getCouponDataTable()
    {

        $query = Coupon::query()->with('createdBy', 'usedBy')->latest();

        return DataTables::of($query)
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('created_by', function ($row) {
                return $row->createdBy ? $row->createdBy->name : 'N/A';
            })->editColumn('used_by', function ($row) {
                return $row->usedBy ? $row->usedBy->name : 'N/A';
            })->editColumn('status', function ($row) {
                return $row->status == 0 || $row->user_id ? '<span class="badge bg-danger-light">Expired</span>' : '<span class="badge bg-primary-light">Active</span>';
            })
            ->addColumn('actions', function ($row) {
                return '
                <div class="d-flex align-items-center list-action">
                    <a 
                        class="badge bg-success edit-btn mr-2" 
                        data-toggle="modal" 
                        data-target="#new-coupon" 
                        data-url="'.route('admin.coupons.update', $row->id).'"
                        data-title="'.$row->title.'"
                        data-code="'.$row->code.'"
                        data-amount="'.$row->amount.'"
                        data-type="'.$row->type.'"
                        data-status="'.$row->status.'">
                        <i class="ri-pencil-line mr-0"></i>
                    </a>
                    <a class="badge bg-warning mr-2 delete-coupon" data-id="'.$row->id.'" data-toggle="tooltip" title="Delete">
                        <i  class="ri-delete-bin-line mr-0"></i>
                    </a>
                </div>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }
}
