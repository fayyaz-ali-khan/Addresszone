@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Coupon List</h4>

                        </div>
                        <a href="#" class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"
                            id="add-new-btn"><i class="las la-plus mr-2"></i>New
                            Coupon</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="coupon-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Created By</th>
                                    <th>Used By</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>

    </div>
    {{-- Update or create modal --}}
    @include('admin.coupons.update_or_create')
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // ------------------ START: coupon data table ------------------//
            $('#coupon-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.coupons.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                    },
                    {
                        data: 'code',
                    },
                    {
                        data: 'amount',
                    },
                    {
                        data: 'type',
                    },
                    {
                        data: 'created_by',
                        name: 'admin_id'
                    },
                    {
                        data: 'used_by',
                        name: 'user_id'
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'status',

                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // ------------------ END: coupon data table ------------------//

            // ------------------ START: Reset coupon form after update ------------------//
            function resetForm() {
                $('#coupon-form').trigger('reset');
            }
            // ------------------ END: Reset coupon form after update ------------------//

            // ------------------ START: Open coupon model for new coupon ------------------//
            $(document).on('click', '#add-new-btn', function() {
                $('#coupon-form').attr('action', '{{ route('admin.coupons.store') }}');
                $('#coupon-form').trigger('reset');
                $('#_method').remove();
                $('#coupon-submit-btn').text('Add Coupon');
                $('#model-coupon-model').text('Add New Coupon');
                $('#coupon-model').modal('show');
            });
            // ------------------ END: Open coupon model for new coupon ------------------//

            // ------------------ START: Edit coupon form ------------------//
            $(document).on('click', '.edit-btn', function() {
                let url = $(this).data('url');
                let title = $(this).data('title');
                let code = $(this).data('code');
                let amount = $(this).data('amount');
                let type = $(this).data('type');
                let status = $(this).data('status');

                // Populate the modal form
                $('#coupon-submit-btn').text('Update Coupon');

                $('#coupon-form').attr('action', url);
                $('input[name="title"]').val(title);
                $('input[name="code"]').val(code);
                $('input[name="amount"]').val(amount);
                $('#type').val(type);
                $('#status').val(status);
                if ($('#coupon-form input[name="_method"]').length === 0) {
                    $('#coupon-form').append(
                        '<input type="hidden" id="_method" name="_method" value="PUT">');
                }
                $('#model-coupon-model').text('Edit Coupon');
                $('#coupon-model').modal('show');
            });
            // ------------------ END: Edit coupon form ------------------//

            // ------------------ START: Coupon form submitting for update/store ------------------//
            $('#coupon-form').on('submit', function(e) {
                e.preventDefault();
                NProgress.start();
                $('#coupon-submit-btn').attr('disabled', true);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        resetForm();
                        $('#coupon-data-table').DataTable().ajax.reload();
                        toastr.success(
                            response.message
                        );
                        $('#coupon-model').modal('hide');
                        NProgress.done();
                        $('#coupon-submit-btn').attr('disabled', false);
                    },
                    error: function(xhr) {
                        NProgress.done();
                        $('#coupon-submit-btn').attr('disabled', false);

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    toastr.error(errors[field].join(
                                        ' '));
                                }
                            }
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
                // ------------------ END: Coupon form submitting for update/store ------------------//

            });

            // ------------------ START: Delete coupon ------------------//
            $(document).on('click', '.delete-coupon', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You can revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        NProgress.start();
                        let id = $(this).data('id');
                        let url = `{{ route('admin.coupons.destroy', ':id') }}`.replace(':id', id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#coupon-data-table').DataTable().ajax.reload();
                                toastr.success(
                                    response.message
                                );
                                NProgress.done();

                            },
                            error: function(xhr) {
                                NProgress.done();
                                toastr.error(xhr.responseJSON.message);
                            }
                        });
                    }
                });


            });
            // ------------------ END: Delete coupon ------------------//


        });
    </script>
@endpush
