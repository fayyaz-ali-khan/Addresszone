@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Blog Category List</h4>

                        </div>
                        <a href="#" class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"
                            id="add-new-btn"><i class="las la-plus mr-2"></i>New
                            Catgeory</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="blog-categories-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>Title</th>
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
    @include('admin.blog_categories.update_or_create')
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // ------------------ START: blog categories data table ------------------//
            $('#blog-categories-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.blog-categories.index') }}",
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
            // ------------------ END: blog categories data table ------------------//

            // ------------------ START: Reset blog category form after update ------------------//
            function resetForm() {
                $('#blog-category-form').trigger('reset');
            }
            // ------------------ END: Reset blog category form after update ------------------//

            // ------------------ START: opn blog category model for new coupon ------------------//
            $(document).on('click', '#add-new-btn', function() {
                $('#blog-category-form').attr('action', '{{ route('admin.blog-categories.store') }}');
                $('#blog-category-form').trigger('reset');
                $('#_method').remove();
                $('#blog-category-submit-btn').text('Add Category');
                $('#model-blog-category-model').text('Add New Blog Category');
                $('#blog-category-model').modal('show');
            });
            // ------------------ END: opn blog category model for new coupon ------------------//

            // ------------------ START: Edit blog categoryform ------------------//
            $(document).on('click', '.edit-btn', function() {
                let url = $(this).data('url');
                let name = $(this).data('name');
                let description = $(this).data('description');
                let status = $(this).data('status');

                // Populate the modal form
                $('#blog-category-submit-btn').text('Update Category');

                $('#blog-category-form').attr('action', url);
                $('input[name="name"]').val(name);
                $('input[name="description"]').val(description);
                $('#status').val(status);
                if ($('#blog-category-form input[name="_method"]').length === 0) {
                    $('#blog-category-form').append(
                        '<input type="hidden" id="_method" name="_method" value="PUT">');
                }
                $('#model-blog-category-model').text('Edit Catgeory');
                $('#blog-category-model').modal('show');
            });
            // ------------------ END: Edit blog category form ------------------//

            // ------------------ START: Blog category form submitting for update/store ------------------//
            $('#blog-category-form').on('submit', function(e) {
                e.preventDefault();
                NProgress.start();
                $('#blog-category-submit-btn').attr('disabled', true);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        resetForm();
                        $('#blog-categories-data-table').DataTable().ajax.reload();
                        toastr.success(
                            response.message
                        );
                        $('#blog-category-model').modal('hide');
                        NProgress.done();
                        $('#blog-category-submit-btn').attr('disabled', false);
                    },
                    error: function(xhr) {
                        NProgress.done();
                        $('#blog-category-submit-btn').attr('disabled', false);

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
                // ------------------ END: Blog category form submitting for update/store ------------------//

            });

            // ------------------ START: Delete coupon ------------------//
            $(document).on('click', '.delete-category', function(e) {
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
                        let url = `{{ route('admin.blog-categories.destroy', ':id') }}`.replace(
                            ':id', id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#blog-categories-data-table').DataTable().ajax
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
