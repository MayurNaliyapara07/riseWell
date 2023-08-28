@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'User',
            'directory'=>'master',
            'create' => 'user.create'
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="user_table"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @if (!empty($AJAX_PATH))
        var ajaxTable = $('#user_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'user_name',
                    name: 'user_name',
                },
                {
                    data: 'user_type',
                    name: 'user_type',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'phone_no',
                    name: 'phone_no',
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        @endif

        function userChangeStatus(route, id = 0) {
            var routeString = "/" + route + "/" + id;
            $.ajax({
                url: routeString,
                type: 'GET',
                data: {
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status) {
                        ajaxTable.ajax.reload();
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }
                }
            });
        }

    </script>

@endpush



