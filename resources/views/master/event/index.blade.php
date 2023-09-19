@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Schedule',
            'directory'=>'master',
            'create'=>'event.create',
        ])

        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="event_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Schedule Name</th>
                                <th>Location</th>
                                <th>Action</th>
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
        var ajaxTable = $('#event_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'event_name',
                    name: 'event_name',
                },
                {
                    data: 'location_type',
                    name: 'location_type',
                },
                {
                    data: 'action',
                    name: 'action',
                },

            ]
        });
        @endif
    </script>

@endpush



