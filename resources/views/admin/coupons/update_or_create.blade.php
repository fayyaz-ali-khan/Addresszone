<x-Admin.Shared.model-layout id="coupon-model" title="Add New Coupon">
    <form action="{{ route('admin.coupons.store') }}" method="POST" id="coupon-form">
        @csrf
        <div class="modal-body">
            <x-Admin.Shared.input-form-group label="Title" name="title" value="{{ old('tittle') }}" errorKey="title" />
            <div class="row">
                <div class="col"><x-Admin.Shared.input-form-group label="Code" name="code"
                        value="{{ old('code') }}" errorKey="code" /></div>
                <div class="col"><x-Admin.Shared.input-form-group label="Amount" name="amount"
                        value="{{ old('amount') }}" errorKey="amount" /></div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Type</label>
                        <select id="type" name="type" class="form-control mb-3">
                            <option value="fixed" @selected(old('type') == 'fixed')>Fixed</option>
                            <option value="percentage" @selected(old('type') == 'percentage')>Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value="1">Active</option>
                            <option value="0">Expire</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" id="coupon-submit-btn">Add Coupon</button>
        </div>
    </form>
</x-Admin.Shared.model-layout>
