@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Service Category List</h4>

                        </div>
                        <a href="#" class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"
                            id="add-new-btn"><i class="las la-plus mr-2"></i>New
                            Service Category</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="service-category-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
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
    @include('admin.service_categories.update_or_create')
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // ------------------ START: coupon data table ------------------//
            $('#service-category-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.service_categories.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'description',
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
                $('#service-category-form').trigger('reset');
            }
            // ------------------ END: Reset coupon form after update ------------------//

            // ------------------ START: Open coupon model for new coupon ------------------//
            $(document).on('click', '#add-new-btn', function() {
                $('#service-category-form').attr('action', '{{ route('admin.service_categories.store') }}');
                $('#service-category-form').trigger('reset');
                $('#_method').remove();
                $('#category-submit-btn').text('Add Category');
                $('#model-service-category-model').text('Add New Service Category');
                $('#service-category-model').modal('show');
            });
            // ------------------ END: Open coupon model for new coupon ------------------//

            // ------------------ START: Edit coupon form ------------------//
            $(document).on('click', '.edit-btn', function() {
                let url = $(this).data('url');
                let name = $(this).data('name');
                let description = $(this).data('description');
                let status = $(this).data('status');

                // Populate the modal form
                $('#category-submit-btn').text('Update Category');

                $('#service-category-form').attr('action', url);
                $('input[name="name"]').val(name);
                $('textarea[name="description"]').val(description);

                $('#status').val(status);
                if ($('#service-category-form input[name="_method"]').length === 0) {
                    $('#service-category-form').append(
                        '<input type="hidden" id="_method" name="_method" value="PUT">');
                }
                $('#model-service-category-model').text('Edit Service Category');
                $('#service-category-model').modal('show');
            });
            // ------------------ END: Edit coupon form ------------------//

            // ------------------ START: Coupon form submitting for update/store ------------------//
            $('#service-category-form').on('submit', function(e) {
                e.preventDefault();
                NProgress.start();
                $('#category-submit-btn').attr('disabled', true);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        resetForm();
                        $('#service-category-data-table').DataTable().ajax.reload();
                        toastr.success(
                            response.message
                        );
                        $('#service-category-model').modal('hide');
                        NProgress.done();
                        $('#category-submit-btn').attr('disabled', false);
                    },
                    error: function(xhr) {
                        NProgress.done();
                        $('#category-submit-btn').attr('disabled', false);

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
            $(document).on('click', '.delete-service-category', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You can revert this!, All the related services will be deleted",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        NProgress.start();
                        let id = $(this).data('id');
                        let url = `{{ route('admin.service_categories.destroy', ':id') }}`.replace(
                            ':id', id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#service-category-data-table').DataTable().ajax
                                    .reload();
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
