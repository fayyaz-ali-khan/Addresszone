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
                        <table id="email-templates-data-table" class=" table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">

                                <tr class="ligth ligth-data">
                                    <th>#</th>
                                    <th>Subject</th>
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
            $('#email-templates-data-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('admin.email_templates.index') }}",
                columnDefs: [{
                    className: "text-center",
                    targets: [4]
                }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'subject',
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


        });
    </script>
@endpush
