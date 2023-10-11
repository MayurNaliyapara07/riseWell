@extends('layouts.frontend')
@section('content')
    <section>
        <div class="book-section">
            <div class="container">

                <h1>Appointment</h1>

                <input type="hidden" class="form-control"
                       name="patients_id" id="patients_id"
                       value="{{!empty($patientDetails) ? $patientDetails->patienst_id:''}}">
                <input type="hidden" class="form-control"
                       name="assign_program_id" id="assignProgramId"
                       value="{{!empty($assignProgram[0])?$assignProgram[0]->assign_program_id:""}}">
                <input type="hidden" class="form-control" id="providerId"
                       name="provider_id"
                       value="{{!empty($providers[0])?$providers[0]->provider_id:""}}">
                <input type="hidden" class="form-control"
                       name="provider_name"
                       value="{{!empty($providers[0])?$providers[0]->provider_name:""}}">

                <div class="form-block">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="">Patients Name</label>
                                <input type="text" class="form-control" placeholder="Please enter your patients name"
                                       readonly
                                       name="patients_name"
                                       value="{{!empty($patientDetails) ? $patientDetails->first_name . ''. $patientDetails->last_name:''}}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="">Type of Visit</label>
                                <input type="text" class="form-control" placeholder="Please enter your type of visit"
                                       readonly
                                       name="event_name"
                                       value="{{!empty($assignProgram[0])?$assignProgram[0]->event_name:""}}">




                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6" >
                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" id="date" class="form-control datepicker" placeholder="" name="" value="">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12" id="show_time">
                            <label for="">Time Slots</label>
                            <ul class="radio-button" id="timeSlot">
                            </ul>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" rows="5" cols="80"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <button type="button" id="saveAppointment" class="btn-book" onclick="saveAppointment()">Book Now</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('styles')
    <style>
        .timeSlotNotAvailable{
            width: auto;
            padding: 0.9rem 0.75rem 1.9rem;
            height: 24px;
            align-items: center;
            font-size: 0.9rem;
            border-radius: 0.42rem;
            color: #F64E60;
            background-color: #FFE2E5;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        $('#show_time').hide();

        $(document).ready(function () {
            $(".datepicker").on('change', function (event) {
                var selectedDate = moment(this.value).format('DD/MM/YYYY');
                var assignProgramId = $('#assignProgramId').val();
                var providerId = $('#providerId').val();

                if (providerId) {
                    $.ajax({
                        url: "/get-available-times",
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            date: selectedDate,
                            provider_id: providerId,
                            assign_program_id: assignProgramId,
                            appointmentType: 'frontend',
                        },
                        success: function (response) {
                            $('#show_time').show();
                            if (response == "" || response == null || response == undefined) {
                                $("#timeSlot").html('<span class="timeSlotNotAvailable">Timeslot not Available<span>');
                            } else {
                                $("#timeSlot").html(response);
                            }

                        },
                    });
                }
            });
        });

        function saveAppointment() {
            $('#saveAppointment').addClass('spinner spinner-white spinner-right');
            var patients_id = $("input[name=patients_id]").val();
            var assignProgramId = $('#assignProgramId').val();
            var date = $("#date").val();
            var providerId = $('#providerId').val();
            var description = $('textarea[name="description"]').val();
            var timeSlot = $('input[name="time_slot"]:checked').val();
            $.ajax({
                url: "/save-appointment",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    assign_program_id: assignProgramId,
                    user_id: providerId,
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
