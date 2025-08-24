@extends('admin.layout.app')



@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Email Template List</h4>

                        </div>
                        <a href="{{ route('admin.email_templates.create') }}"
                            class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"><i
                                class="las la-plus mr-2"></i>New
                            Template</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="customer-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Verification Status</th>
                                    <th>Created At</th>
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
            $('#customer-data-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.customers.index') }}",
                columnDefs: [{
                    className: "text-center",
                    targets: [4]
                }],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'image',
                    },
                    {
                        data: 'name',
                    },

                    {
                        data: 'email',

                    },
                    {
                        data: 'mobile',

                    },
                    {
                        data: 'verification_status',
                        searchable: false

                    },


                    {
                        data: 'created_at',
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
            $(document).on('click', '.delete-customer', function(e) {
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
                        let url = `{{ route('admin.customers.destroy', ':id') }}`.replace(':id',
                            id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#customer-data-table').DataTable().ajax.reload();
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
