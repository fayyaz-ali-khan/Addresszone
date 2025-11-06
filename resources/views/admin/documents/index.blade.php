@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Documents List</h4>

                        </div>
                        <a href="{{ route('admin.documents.create') }}"
                            class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"><i
                                class="las la-plus mr-2"></i>New Document</a>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="documents-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Document Title</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
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
            // ------------------ START: Documents DataTable ------------------//
            $('#documents-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.documents.index') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user.name'
                    },
                    {
                        data: 'document_title',
                        name: 'document_title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            // ------------------ END: Documents DataTable ------------------//

            // ------------------ START: Delete Document ------------------//
            $(document).on('click', '.delete-document', function(e) {
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
                        let url = `{{ route('admin.documents.destroy', ':id') }}`.replace(':id',
                            id);
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#documents-data-table').DataTable().ajax.reload();
                                toastr.success(response.message);
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
            // ------------------ END: Delete Document ------------------//

        });
    </script>
@endpush
