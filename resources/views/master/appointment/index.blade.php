@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Appointment',
            'directory'=>'master',
        ])

        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="appointment_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Event Name</th>
                                <th>Patients Name</th>
                                <th>Provider Name</th>
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
        var ajaxTable = $('#appointment_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'date',
                    name: 'date',
                },
                {
                    data: 'program_name',
                    name: 'program_name',
                },
                {
                    data: 'patients_name',
                    name: 'patients_name',
                },
                {
                    data: 'provider_name',
                    name: 'provider_name',
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



