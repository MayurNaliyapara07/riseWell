@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Notification Template',
            'directory'=>'master',
//            'create'=> 'notification-template.create',
            'back'=> 'home'
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="notification_template_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Edit</th>
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
        var ajaxTable = $('#notification_template_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'subj',
                    name: 'subj',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'action',
                    name: 'action',
                },

            ]
        });
        @endif

        function updateStatus(route, id = 0) {
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



