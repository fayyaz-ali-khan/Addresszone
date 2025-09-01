@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Blogs List</h4>

                        </div>
                        <a href="{{ route('admin.blogs.create') }}"
                            class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"><i
                                class="las la-plus mr-2"></i>New
                            Blog</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="blogs-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
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
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            // ------------------ START: Email templates data table ------------------//
            $('#blogs-data-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.blogs.index') }}",
                columnDefs: [{
                        className: "text-center",
                        targets: [4]
                    },
                    {
                        width: "10%",
                        targets: 0 // image
                    },
                    {
                        width: "50%",
                        targets: 1 // title
                    },
                    {
                        width: "10%",
                        targets: 2 // category
                    },
                    {
                        width: "10%",
                        targets: 3 // status
                    },
                    {
                        width: "10%",
                        targets: 4 // actions
                    },

                ],
                columns: [{
                        data: 'image'
                    },

                    {
                        data: 'title',
                    },
                    {
                        data: 'category',
                        searchable: false

                    },
                    {
                        data: 'status',
                        searchable: false

                    },

                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // ------------------ END: Email templates data table ------------------//
            // ------------------ START: Delete coupon ------------------//
            $(document).on('click', '.delete-blog', function(e) {
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
                        let url = `{{ route('admin.blogs.destroy', ':id') }}`.replace(
                            ':id', id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            blockUI: true,
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#blogs-data-table').DataTable().ajax
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
