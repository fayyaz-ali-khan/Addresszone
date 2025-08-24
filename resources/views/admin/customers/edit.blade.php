@extends('admin.layout.app')

@section('main-content')
    <x-Admin.Shared.form-page-container title="Edit Customer">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" novalidate="true">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="First Name *" name="first_name"
                        value="{{ old('first_name', $customer->first_name) }}" />
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="Last Name" name="last_name"
                        value=" {{ old('last_name', $customer->last_name) }}" />

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="{{ $customer->email }}" class="form-control" id="email" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="Number *" name="mobile"
                        value="{{ old('mobile', $customer->mobile) }}" type="number" />

                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="Company *" name="company"
                        value="{{ $customer->company_name }}" />

                </div>
                <div class="col-md-4">
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('status'),
                    ])>
                        <label>Status</label>
                        <select name="status" class="form-control mb-3">
                            <option value="1" @selected(old('status', $customer->status) == 1)>Active</option>
                            <option value="0" @selected(old('status', $customer->status) == 0)>Inactive</option>
                        </select>
                        <x-Shared.input-error field="status" />
                    </div>
                </div>


                <div class="col-md-8">
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('address'),
                    ])>
                        <label>Address</label>
                        <textarea name="address" class="form-control" style="text-align: left; direction: rtl" rows="3">
                            {{ old('address', $customer->address) }}
                        </textarea>
                        <x-Shared.input-error field="address" />
                    </div>
                </div>


            </div>
            <span class="float-right">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" class="btn btn-primary mr-2">Update Customer</button>
            </span>
        </form>
    </x-Admin.Shared.form-page-container>
@endsection
