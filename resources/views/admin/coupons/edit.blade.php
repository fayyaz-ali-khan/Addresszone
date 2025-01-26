    <div class="d-flex align-items-center list-action">
        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"
            href="#"><i class="ri-pencil-line mr-0"></i></a>
        <x-admin.shared.model-layout>
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <x-admin.shared.input-form-group label="Title" name="title" value="{{ old('tittle') }}"
                        errorKey="title" />
                    <div class="row">
                        <div class="col"><x-admin.shared.input-form-group label="Code" name="code"
                                value="{{ old('code') }}" errorKey="code" /></div>
                        <div class="col"><x-admin.shared.input-form-group label="Amount" name="amount"
                                value="{{ old('amount') }}" errorKey="amount" /></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control mb-3">
                                    <option value="fixed" @selected(old('type') == 'fixed')>Fixed</option>
                                    <option value="percentage" @selected(old('type') == 'percentage')>Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control mb-3">
                                    <option value="1" @selected(old('status') == 1)>Active</option>
                                    <option value="0" @selected(old('status') == 0)>DeActive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Add Coupon</button>
                </div>
            </form>
        </x-admin.shared.model-layout>

        <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title=""
            data-original-title="Delete" href="#"><i class="ri-delete-bin-line mr-0"></i></a>
    </div>';
