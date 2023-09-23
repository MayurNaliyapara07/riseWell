@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Patients',
            'directory'=>'master',
            'create' => 'patients.create'
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="patients_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Patients Name</th>
                                <th>Dob</th>
                                <th>Member ID</th>
                                <th>SSN</th>
                                <th>Profile Claimed</th>
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

    <div class="modal fade" id="addAppointment" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Schedule </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="patients_id" name="patients_id" value="">
                    <input type="hidden" id="patients_state_id" name="patients_state_id" value="">

                    <div class="form-group">
                        <label>Program<span class="text-danger">*</span></label>
                        <select name="assign_program_id" class="form-control  assign-program-select2"
                                style="width: 100%;!important;">
                            <option value="">Select Program</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provider<span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control provider-select2" style="width: 100%;!important;">
                            <option value="">Select Provider</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date<span class="text-danger">*</span></label>
                        <input autocomplete="off" type="text" name="date" class="form-control datepicker" style="width: 100%!important;"
                               placeholder="Select available date" id="date"/>

                    </div>

                    <div class="form-group" id="show_time">
                        <label>Available Time Slot <span class="text-danger">*</span></label>
                        <div class="form-group row" id="timeSlot">
                            <div class="col-9 col-form-label">
                                <div class="radio-inline">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea type="text" autocomplete="off" name="description" class="form-control"
                                  placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close
                    </button>
                    <button type="button" id="saveAppointment" class="btn btn-primary" onclick="saveAppointment()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="timeLine" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TimeLine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        @if (!empty($AJAX_PATH))
        var ajaxTable = $('#patients_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'patients_name',
                    name: 'patients_name',
                },
                {
                    data: 'dob',
                    name: 'dob',
                },
                {
                    data: 'member_id',
                    name: 'member_id',
                },
                {
                    data: 'ssn',
                    name: 'ssn',
                },
                {
                    data: 'profile_claimed',
                    name: 'profile_claimed',
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


        function copyToClipboard(patientId){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-unique-url') }}',
                type: 'POST',
                data: {
                    patients_id: patientId
                },
                success: function (response) {
                    if(response.data){
                        let url = response.data;
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        try {
                            navigator.clipboard.writeText(url);

                            Toast.fire({
                                icon: 'success',
                                title: 'URL copied! '
                            })
                        } catch (err) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Failed to copy!'
                            })

                        }
                    }
                }
            });
        }

        function patientsChangeStatus(route, id = 0) {
            var routeString = "/" + route + "/" + id;
            $.ajax({
                url: routeString,
                type: 'GET',
                data: {
                    "id": id,
                    "_token": "<?php echo e(csrf_token()); ?>",
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

        $(document).on("click", ".addAppointment", function () {
            var Id = $(this).data('id');
            var stateId = $(this).data('state-id');
            $("input[name=patients_id]").val(Id);
            $("input[name=patients_state_id]").val(stateId);
            $('#addAppointment').modal('show');



        });

        $(".assign-program-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('assign-program-list')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                }, processResults: function (response) {
                    return {results: response};
                }, cache: true
            }
        });

        var assignProgramId = "";
        $(".assign-program-select2").change(function () {
            var patientStateId = $('#patients_state_id').val();
            assignProgramId = $(this).val();
            $(".provider-select2").select2({
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ url('provider-list')}}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term,
                            patient_state_id: patientStateId,
                        };
                    }, processResults: function (response) {
                        return {results: response};
                    }, cache: true
                }
            });
        });
        var providerId = "";
        $(".provider-select2").change(function () {
            providerId = $(this).val();
        });
        $('#show_time').hide();
        $('.datepicker').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            autoclose: true,
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },

        }).on('changeDate', function(ev) {
            if(providerId){
                var selectedDate = $("#date").val();
                $.ajax({
                    url: "/get-available-times",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        date: selectedDate,
                        provider_id: providerId,
                        assign_program_id:assignProgramId,
                    },
                    success: function (response) {
                        $('#show_time').show();
                        if(response == "" || response == null || response == undefined ){
                            $("#timeSlot").html('<span class="label label-lg label-light-danger label-inline">Timeslot not Available<span>');
                        } else {
                            $("#timeSlot").html(response);
                        }

                    },
                });
            }
        });
        function saveAppointment() {
            $('#saveAppointment').addClass('spinner spinner-white spinner-right');
            var patients_id = $("input[name=patients_id]").val();
            var assignProgramId = $("select[name=assign_program_id]").val();
            var date = $("#date").val();
            var userId = $("select[name=user_id]").val();
            var description = $('textarea[name="description"]').val();
            var timeSlot = $('input[name="time_slot"]:checked').val();
            $.ajax({
                url: "/save-appointment",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    assign_program_id: assignProgramId,
                    user_id: userId,
                    patients_id: patients_id,
                    date: date,
                    time_slot: timeSlot,
                    description: description,
                },
                success: function (response) {
                    if (response.success) {
                        $('#saveAppointment').removeClass('spinner spinner-white spinner-right');
                        $('#addAppointment').modal('toggle');
                        swalSuccessWithRedirect(response.message,response.redirectUrl);
                    } else {
                        swalError(response.message);
                        $('#saveAppointment').removeClass('spinner spinner-white spinner-right');
                    }
                },
            });
        }


    </script>

@endpush



