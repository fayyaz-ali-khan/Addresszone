@extends('admin.layout.app')
@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Comments List</h4>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive rounded mb-3">
                        <table id="comments-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                            <tr class="ligth ligth-data">
                                <th>User</th>
                                <th>Comment</th>
                                <th>Blog</th>
                                <th>Date</th>
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

            // ------------------ START: Comments data table ------------------//
            $('#comments-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.comments.index') }}",

                columns: [
                    {
                        data: 'user_profile',
                        name: 'user_profile',
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        width: "10%"
                    },

                    {
                        data: 'comment',
                        name: 'comment',
                        searchable: false,
                        width: "15%"
                    },
                    {
                        data: 'blog_title',
                        name: 'blog_title',
                        searchable: false,
                        width: "15%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable: false,
                        width: "15%"
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                        width: "5%"
                    }
                ],

                // Optional: responsive + default ordering
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search comments..."
                }
            });
            // ------------------ END: Comments data table ------------------//

            // ------------------ START: Delete comment ------------------//
            $(document).on('click', '.delete-comment', function(e) {
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
                        let url = `{{ route('admin.comments.destroy', ':id') }}`.replace(
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
                                $('#comments-data-table').DataTable().ajax
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
            // ------------------ END: Delete comment ------------------//

        });
    </script>
@endpush
