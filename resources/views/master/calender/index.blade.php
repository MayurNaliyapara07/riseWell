@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Calender',
            'directory'=>'master',
        ])
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom card-stretch">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Calendar</h3>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="kt_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-view-event" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Appointment Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-12 mb-5">
                                <label for="patient_name" class="form-label">Patient Name:</label>
                                <p id="showPatientName"></p>
                            </div>
                            <div class="form-group col-sm-12 mb-5">
                                <label for="patient_name" class="form-label">Program Name:</label>
                                <p id="showProgramName"></p>
                            </div>
                            <div class="form-group col-sm-12 mb-5">
                                <label for="doctor_name" class="form-label">Doctor:</label>
                                <p id="showDoctorName"></p>
                            </div>
                            <div class="form-group col-sm-12 mb-5">
                                <label for="opd_date" class="form-label">Date:</label>
                                <br>
                                <p id="showDate"></p>
                            </div>
                            <div class="form-group col-sm-12 mb-5">
                                <label for="problem" class="form-label">Description:</label>
                                <p id="showDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <script src="{{asset('assets/js/pages/features/calendar/basic.js"')}}"></script>
    <script>
        $(document).ready(function () {

            var SITEURL = "{{url('/')}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var KTCalendarBasic = function() {
                return {
                    init: function() {
                        var todayDate = moment().startOf('day');
                        var TODAY = todayDate.format('YYYY-MM-DD');
                        var calendarEl = document.getElementById('kt_calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                            themeSystem: 'bootstrap',
                            isRTL: KTUtil.isRTL(),
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            height: 800,
                            contentHeight: 780,
                            aspectRatio: 3,
                            nowIndicator: true,
                            now: TODAY + 'T09:25:00', // just for demo
                            views: {
                                dayGridMonth: { buttonText: 'month' },
                                timeGridWeek: { buttonText: 'week' },
                                timeGridDay: { buttonText: 'day' }
                            },
                            defaultView: 'dayGridMonth',
                            defaultDate: TODAY,
                            editable: true,
                            eventLimit: true,
                            navLinks: true,
                            color:'#ffffff',
                            events: events = {!! json_encode($events) !!},
                            eventRender: function (info) {
                                var element = $(info.el);
                                if (info.event.extendedProps && info.event.extendedProps.description) {
                                    console.log(info.event,'info.event');
                                    if (element.hasClass('fc-day-grid-event')) {
                                        element.data('content', info.event.extendedProps.description);
                                        element.data('placement', 'top');
                                        KTApp.initPopover(element);
                                    } else if (element.hasClass('fc-time-grid-event')) {
                                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                                    }
                                }
                            },

                            eventClick: function (info) {
                                if (info.event.extendedProps && info.event.extendedProps.description) {
                                    var eventId = info.event.id;
                                    $.ajax({
                                        url: SITEURL + "/appointment-details",
                                        data: 'schedule_id=' + eventId,
                                        type: "POST",
                                        success: function (data) {
                                            $('#showPatientName').html(data.patientsName);
                                            $('#showDoctorName').html(data.providerName);
                                            $('#showDate').html(data.date);
                                            $('#showDescription').html(data.description);
                                            $('#showProgramName').html(data.program_name);
                                            $('#modal-view-event').modal('show');
                                        }
                                    });
                                }
                            },
                        });
                        calendar.render();
                    }
                };
            }();

            jQuery(document).ready(function() {
                KTCalendarBasic.init();
            });
        });

        function formatDate(dateVal) {
            var newDate = new Date(dateVal);

            var sMonth = padValue(newDate.getMonth() + 1);
            var sDay = padValue(newDate.getDate());
            var sYear = newDate.getFullYear();
            var sHour = newDate.getHours();
            var sMinute = padValue(newDate.getMinutes());
            var sAMPM = "AM";

            var iHourCheck = parseInt(sHour);

            if (iHourCheck > 12) {
                sAMPM = "PM";
                sHour = iHourCheck - 12;
            }
            else if (iHourCheck === 0) {
                sHour = "12";
            }

            sHour = padValue(sHour);

            return sMonth + "/" + sDay + "/" + sYear + " " + sHour + ":" + sMinute + " " + sAMPM;
        }

        function padValue(value) {
            return (value < 10) ? "0" + value : value;
        }
    </script>

@endpush



