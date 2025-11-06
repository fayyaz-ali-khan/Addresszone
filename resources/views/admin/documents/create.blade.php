@extends('admin.layout.app')

@section('main-content')
    <x-Admin.Shared.form-page-container title="Customer Details">
        <div class="row">

            <div class="col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <label class="form-label"><strong>Select User
                            : </strong></label>
                    <select id="document-user" class="form-control">
                        <option value="">Select Customer</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">


            </div>

            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>First
                                Name: <span id="customer-first-name"></span> </strong></label>
                        <br>

                        <label class="form-label"><strong>Last Name
                                : <span id="customer-last-name"></span> </strong></label>


                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">

                        <label class="form-label"><strong>Email
                                : <span id="customer-email"></span></strong></label>
                        <br>
                        <label class="form-label"><strong>Mobile
                                : <span id="customer-mobile"></span></strong></label>

                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label"><strong>Company Name
                                : <span id="customer-company-name"></span> </strong> </label><br>

                        <label class="form-label"><strong>Country
                                : <span id="customer-country"></span></strong></label><br>

                    </div>
                </div>
            </div>


        </div>
        <div class="row media-group-gallery d-none">
            <div class="col-sm-4 col-md-4">
                <figure class="figure">
                    <img id="customer-profile-image" src="" class="figure-img img-fluid rounded" style="width:180px"
                        alt="Customer Profile Image">
                    <figcaption class="figure-caption text-center">Profile Image</figcaption>
                </figure>
            </div>
            <div class="col-sm-6 col-md-4">
                <figure class="figure">
                    <img id="customer-cnic-front-image" src="" class="figure-img img-fluid rounded"
                        style="width:180px" alt="Customer CNIC Front Image">
                    <figcaption class="figure-caption text-center">CNIC Front Image</figcaption>
                </figure>
            </div>
            <div class="col-sm-6 col-md-4">
                <figure class="figure">
                    <img id="customer-cnic-back-image" src="" class="figure-img img-fluid rounded"
                        style="width:180px" alt="Customer CNIC Back Image">
                    <figcaption class="figure-caption text-center">CNIC Back Image</figcaption>
                </figure>
            </div>
            <div class="col-sm-6 col-md-4">
                <figure class="figure">
                    <img id="customer-Passport-image" src="" class="figure-img img-fluid rounded"
                        style="width:180px" alt="Customer Passport Image">
                    <figcaption class="figure-caption text-center">Passport Image</figcaption>
                </figure>
            </div>


        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h5>Documents Record</h5>
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th><strong>Document Name</strong></th>
                            <th><strong>Document File</strong></th>
                        </tr>
                    </thead>
                    <tbody id="document-list">
                        <tr>
                            <td>ASD </td>
                            <td>asdas </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div.row>
            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="customer" id="customer-id" value="" />
                <div class="form-row">
                    <div class="col-sm-6 col-md-4">
                        <div @class([
                            'form-group',
                            'has-error' => $errors->has('verification_status'),
                        ])>
                            <label for="name">Document Title</label>
                            <input type="text" name="document_title[]" class="form-control" />
                            <x-Shared.input-error field="verification_status" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div @class([
                            'form-group',
                            'has-error' => $errors->has('verification_msg'),
                        ])>
                            <label> Document File</label>
                            <input type="file" name="documents[]" class="form-control" />
                            <x-Shared.input-error field="verification_msg" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 d-flex align-items-center">
                        <button class="btn btn-info add-more-document mt-4" type="button" id="add-document"
                            title="Add more documents"> <i class="ri-add-fill"></i></button>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary float-right submit-btn">Submit</button>
            </form>
        </div.row>
    </x-Admin.Shared.form-page-container>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#document-user').select2({
                placeholder: 'Select a user',
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.customers.search') }}",
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: `${item.first_name} ${item.last_name} (${item.email}) (${item.mobile})`
                                };
                            })
                        };
                    },

                    cache: true
                },


            });

            // When selection changes
            $('#document-user').on('change', function() {

                let userId = $(this).val();
                let url = "{{ route('admin.customers.show', ':id') }}";
                url = url.replace(':id', userId);
                NProgress.start();
                if (userId) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {
                            user_id: userId
                        },
                        success: function(response) {
                            $('#customer-id').val(response.id || '');
                            $('#customer-profile-image').attr('src', response.image || '');
                            $('#customer-cnic-front-image').attr('src', response
                                .CNIC_Front_Image || '');
                            $('#customer-cnic-back-image').attr('src', response
                                .CNIC_Back_Image || '');
                            $('#customer-Passport-image').attr('src', response
                                .Passport_Front_Image || '');
                            $('#customer-first-name').text(response.first_name || '');
                            $('#customer-last-name').text(response.last_name || '');
                            $('#customer-email').text(response.email || '');
                            $('#customer-mobile').text(response.mobile || '');
                            $('#customer-company-name').text(response.company_name || '');
                            $('#customer-country').text(response.country || '');
                            $('.media-group-gallery').removeClass('d-none');
                            toastr.success('Data loaded successfully.');
                            NProgress.done();

                        },
                        error: function(xhr) {
                            NProgress.done();
                            resetFields();
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        }
                    });
                }
            });

            // When user clicks "Add More Document"
            $(document).on('click', '.add-more-document', function(e) {
                e.preventDefault();

                let newRow = `
                <div class="form-row">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <input type="text" name="document_title[]" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <input type="file" name="documents[]" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 ">
                        <button class="btn btn-warning remove-document" type="button" title="Remove Document">
                            <i class="ri-delete-bin-2-fill"></i>
                        </button>
                    </div>
                </div>`;

                // Add new row after current form-row
                $(this).closest('.form-row').after(newRow);
            });

            // When user clicks "Remove Document"
            $(document).on('click', '.remove-document', function(e) {
                e.preventDefault();
                $(this).closest('.form-row').remove();
            });


            $('form').on('submit', function(e) {
                e.preventDefault();
                $('.submit-btn').attr('disabled', true);
                // Get the selected customer ID
                let customerId = $('#customer-id').val();
                console.log(customerId);
                let selectedCustomer = $('#document-user').val();
                console.log(selectedCustomer);
                if ((!customerId || !selectedCustomer) || (selectedCustomer != customerId)) {
                    toastr.error("Please select a customer before submitting documents.");
                    return;
                }

                let form = this;

                let url = $(form).attr('action');
                let formData = new FormData(form); // supports file uploads

                NProgress.start(); // optional progress bar
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false, // required for FormData
                    contentType: false, // required for FormData
                    success: function(response) {
                        NProgress.done();
                        toastr.success(response.message || "Documents submitted successfully.");
                        form.reset(); // clear form
                        $('.form-row').not(':first').remove();
                        resetFields();
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.documents.index') }}";
                        }, 2000);
                    },
                    error: function(xhr) {
                        NProgress.done();
                        let message = xhr.responseJSON?.message || "Something went wrong!";
                        toastr.error(message);
                        $('.submit-btn').attr('disabled', false);
                    }
                });
            });

            function resetFields() {
                $('.media-group-gallery').addClass('d-none');
                $('#customer-id').val('');
                $('#customer-profile-image').attr('src', '');
                $('#customer-cnic-front-image').attr('src', '');
                $('#customer-cnic-back-image').attr('src', '');
                $('#customer-Passport-image').attr('src', '');
                $('#customer-first-name').text('');
                $('#customer-last-name').text('');
                $('#customer-email').text('');
                $('#customer-mobile').text('');
                $('#customer-company-name').text('');
                $('#customer-country').text('');

            }

        });
    </script>
@endpush
