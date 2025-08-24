@extends('admin.layout.app')

@section('main-content')
    <x-Admin.Shared.form-page-container title="Customer Details">
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>First
                                Name: </strong>{{ $customer->first_name }}</label>
                        <br>

                        <label class="form-label"><strong>Last Name
                                : </strong>{{ $customer->last_name }}</label>
                        <label class="form-label"><strong>Email
                                : </strong>{{ $customer->email }}</label>

                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>Company Name
                                : </strong> {{ $customer->company_name }}</label><br>
                        <label class="form-label"><strong>Mobile
                                : </strong>{{ $customer->mobile }}</label><br>

                        <label class="form-label"><strong>Country
                                : </strong>{{ $customer->country }}</label><br>

                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">

                        <label class="form-label"><strong>CNIC Front Image
                                : </strong><span class="CNIC_Front_Image">

                                <a href="https://addresszone.co.uk/public/NIC_Front_Image/30222.jpg" target="_blank"
                                    data-bs-original-title="" title="">View</a>

                            </span></label><br>

                        <label class="form-label"><strong>CNIC Back Image
                                : </strong><span class="CNIC_Back_Image">
                                <a href="https://addresszone.co.uk/public/CNIC_Back_Image/42960.JPG" target="_blank"
                                    data-bs-original-title="" title="">View</a>
                            </span></label><br>
                        <label class="form-label"><strong>Passport Front Image
                                : </strong><span class="Passport_Front_Image">
                                <a href="https://addresszone.co.uk/public/Passport_Front_Image/99794.jpg" target="_blank"
                                    data-bs-original-title="" title="">View</a>
                            </span></label><br>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>Address
                                : </strong>{!! $customer->address !!}
                        </label><br>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>Document Delivery Address
                                : </strong>{!! $customer->document_delivery_address ?? 'N/A' !!}
                        </label><br>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="mb-3">
                    <div class="form-group">

                        <label class="form-label"><strong>Verification Status
                                : </strong>
                            @if ($customer->verification_status == \App\Enums\CustomerVerificationStatus::VERIFIED->value)
                                <span class="badge bg-success-light">Verified</span>
                            @elseif ($customer->verification_status == \App\Enums\CustomerVerificationStatus::NOT_VERIFIED->value)
                                <span class="badge bg-warning-light">Not Verified</span>
                            @elseif ($customer->verification_status == \App\Enums\CustomerVerificationStatus::REJECTED->value)
                                <span class="badge bg-danger-light">Rejected</span>
                            @else
                                <span class="badge bg-danger-light">N/A</span>
                            @endif
                        </label><br>
                        <label class="form-label"><strong>Status
                                : </strong>
                            @if ($customer->status == 1)
                                <span class="badge bg-success-light">Active</span>
                            @elseif ($customer->status == 0)
                                <span class="badge bg-warning-light">Not Active</span>
                            @else
                                <span class="badge bg-danger-light">N/A</span>
                            @endif
                        </label><br>
                        <label class="form-label"><strong>Registered At
                                : </strong>
                            {{ $customer->created_at?->format('d-m-Y H:i A') }}
                        </label><br>
                    </div>
                </div>
            </div>

        </div>
        <hr>
        <div.row>
            <form action="{{ route('admin.customers.update-verification-status', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col-4">
                        <div @class([
                            'form-group',
                            'has-error' => $errors->has('verification_status'),
                        ])>
                            <label for="name">Verification Status</label>
                            <select class="form-control mb-3" name="verification_status">
                                <option value="0" @selected(old('verification_status', $customer->verification_status) == 0)>Not Verified</option>
                                <option value="1" @selected(old('verification_status', $customer->verification_status) == 1)>Verified</option>
                                <option value="2" @selected(old('verification_status', $customer->verification_status) == 2)>Rejected</option>
                            </select>
                            <x-Shared.input-error field="verification_status" />
                        </div>
                    </div>
                    <div class="col">
                        <div @class([
                            'form-group',
                            'has-error' => $errors->has('verification_msg'),
                        ])>
                            <label for="exampleFormControlTextarea1"> Note</label>
                            <textarea name="verification_msg" class="form-control" id="exampleFormControlTextarea1" rows="1">{{ old('verification_msg', $customer->verification_msg ?? '') }}</textarea>
                            <x-Shared.input-error field="verification_msg" />
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </form>
        </div.row>
    </x-Admin.Shared.form-page-container>
@endsection
