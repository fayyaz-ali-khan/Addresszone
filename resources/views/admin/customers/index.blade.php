@extends('admin.layout.app')

{{--<style>--}}
{{--    * {--}}
{{--        margin: 0;--}}
{{--        padding: 0;--}}
{{--        box-sizing: border-box;--}}
{{--        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;--}}
{{--    }--}}

{{--    body {--}}
{{--        /*background-color: #f5f7fb;*/--}}
{{--        color: #333;--}}
{{--        padding: 20px;--}}
{{--    }--}}

{{--    .container {--}}
{{--        max-width: 1200px;--}}
{{--        margin: 0 auto;--}}
{{--    }--}}

{{--    header {--}}
{{--        text-align: center;--}}
{{--        margin-bottom: 30px;--}}
{{--        padding: 20px;--}}
{{--    }--}}

{{--    h1 {--}}
{{--        color: #2c3e50;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-weight: 600;--}}
{{--    }--}}

{{--    .description {--}}
{{--        color: #7f8c8d;--}}
{{--        font-size: 18px;--}}
{{--        max-width: 800px;--}}
{{--        margin: 0 auto;--}}
{{--    }--}}

{{--    .card {--}}
{{--        background: white;--}}
{{--        border-radius: 10px;--}}
{{--        /*box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);*/--}}
{{--        overflow: hidden;--}}
{{--        /*margin-bottom: 30px;*/--}}
{{--    }--}}

{{--    .toolbar {--}}
{{--        display: flex;--}}
{{--        flex-wrap: wrap;--}}
{{--        gap: 15px;--}}
{{--        padding: 20px;--}}
{{--        background: #f8f9fa;--}}
{{--        border-bottom: 1px solid #eaeef2;--}}
{{--    }--}}

{{--    .filter-group {--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        min-width: 100px;--}}
{{--    }--}}

{{--    .filter-group label {--}}
{{--        font-size: 12px;--}}
{{--        font-weight: 600;--}}
{{--        margin-bottom: 5px;--}}
{{--        color: #6c757d;--}}
{{--    }--}}

{{--    .filter-control {--}}
{{--        padding: 10px 12px;--}}
{{--        border: 1px solid #ddd;--}}
{{--        border-radius: 6px;--}}
{{--        font-size: 14px;--}}
{{--        background: white;--}}
{{--        color: #495057;--}}
{{--        transition: all 0.3s;--}}
{{--    }--}}

{{--    .filter-control:focus {--}}
{{--        outline: none;--}}
{{--        border-color: #4dabf7;--}}
{{--        box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.2);--}}
{{--    }--}}

{{--    .btn {--}}
{{--        padding: 10px 16px;--}}
{{--        border: none;--}}
{{--        border-radius: 6px;--}}
{{--        font-size: 14px;--}}
{{--        font-weight: 500;--}}
{{--        cursor: pointer;--}}
{{--        transition: all 0.3s;--}}
{{--        display: flex;--}}
{{--        align-items: center;--}}
{{--        gap: 8px;--}}
{{--    }--}}

{{--    .btn-primary {--}}
{{--        background: #4dabf7;--}}
{{--        color: white;--}}
{{--    }--}}

{{--    .btn-primary:hover {--}}
{{--        background: #339af0;--}}
{{--    }--}}

{{--    .btn-outline {--}}
{{--        background: transparent;--}}
{{--        border: 1px solid #ddd;--}}
{{--        color: #6c757d;--}}
{{--    }--}}

{{--    .btn-outline:hover {--}}
{{--        background: #f8f9fa;--}}
{{--    }--}}

{{--    table {--}}
{{--        width: 100%;--}}
{{--        border-collapse: collapse;--}}
{{--    }--}}

{{--    th {--}}
{{--        background: #f1f3f5;--}}
{{--        padding: 12px 15px;--}}
{{--        text-align: left;--}}
{{--        font-weight: 600;--}}
{{--        color: #495057;--}}
{{--        border-bottom: 2px solid #e9ecef;--}}
{{--    }--}}

{{--    td {--}}
{{--        padding: 12px 15px;--}}
{{--        border-bottom: 1px solid #e9ecef;--}}
{{--        color: #495057;--}}
{{--    }--}}

{{--    tr:hover {--}}
{{--        background: #f8f9fa;--}}
{{--    }--}}

{{--    .status {--}}
{{--        display: inline-block;--}}
{{--        padding: 5px 12px;--}}
{{--        border-radius: 12px;--}}
{{--        font-size: 12px;--}}
{{--        font-weight: 500;--}}
{{--    }--}}

{{--    .status-active {--}}
{{--        background: #d1fae5;--}}
{{--        color: #065f46;--}}
{{--    }--}}

{{--    .status-pending {--}}
{{--        background: #fef3c7;--}}
{{--        color: #92400e;--}}
{{--    }--}}

{{--    .status-inactive {--}}
{{--        background: #fee2e2;--}}
{{--        color: #b91c1c;--}}
{{--    }--}}

{{--    .dataTables_wrapper {--}}
{{--        padding: 20px;--}}
{{--    }--}}

{{--    .toolbar-title {--}}
{{--        display: flex;--}}
{{--        align-items: center;--}}
{{--        gap: 10px;--}}
{{--        margin-right: auto;--}}
{{--    }--}}

{{--    .toolbar-title i {--}}
{{--        color: #4dabf7;--}}
{{--        font-size: 20px;--}}
{{--    }--}}

{{--    @media (max-width: 768px) {--}}
{{--        .toolbar {--}}
{{--            flex-direction: column;--}}
{{--        }--}}

{{--        .filter-group {--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .toolbar-actions {--}}
{{--            display: flex;--}}
{{--            gap: 10px;--}}
{{--        }--}}

{{--        .toolbar-actions .btn {--}}
{{--            flex: 1;--}}
{{--        }--}}
{{--    }--}}
{{--</style>--}}

@section('main-content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <div>
                            <h4 class="mb-3">Customers List</h4>

                        </div>
{{--                        <a href="{{ route('admin.email_templates.create') }}"--}}
{{--                            class="btn border  btn-info add-btn shadow-none mx-2 d-none d-md-block"><i--}}
{{--                                class="las la-plus mr-2"></i>New--}}
{{--                            Template</a>--}}
                    </div>
                </div>
                <div class="col-lg-12">

{{--                    <div class="card">--}}
{{--                        <div class="toolbar">--}}
{{--                            <div class="toolbar-title">--}}
{{--                                <i class="fas fa-filter"></i>--}}
{{--                                <h3>Data Filters</h3>--}}
{{--                            </div>--}}


{{--                            <div class="filter-group">--}}
{{--                                <label for="status">Status</label>--}}
{{--                                <select id="status" class="filter-control">--}}
{{--                                    <option value="">All Statuses</option>--}}
{{--                                    <option value="active">Active</option>--}}
{{--                                    <option value="pending">Pending</option>--}}
{{--                                    <option value="inactive">Inactive</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <div class="filter-group">--}}
{{--                                <label for="category">Category</label>--}}
{{--                                <select id="category" class="filter-control">--}}
{{--                                    <option value="">All Categories</option>--}}
{{--                                    <option value="technology">Technology</option>--}}
{{--                                    <option value="finance">Finance</option>--}}
{{--                                    <option value="healthcare">Healthcare</option>--}}
{{--                                    <option value="retail">Retail</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <div class="filter-group">--}}
{{--                                <label for="date">Date Range</label>--}}
{{--                                <input type="date" id="date" class="filter-control" style="padding: 5px !important;">--}}
{{--                            </div>--}}

{{--                            <div class="toolbar-actions">--}}
{{--                            <br/>--}}
{{--                                <button class="btn btn-primary mt-2" id="applyFilters">--}}
{{--                                    <i class="fas fa-check"></i> Apply--}}
{{--                                </button>--}}
{{--                                <button class="btn btn-outline" id="resetFilters">--}}
{{--                                    <i class="fas fa-redo"></i> Reset--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


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
