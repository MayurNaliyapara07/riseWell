@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Order',
            'directory'=>'master',
            'back' => 'home'
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="order_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th colspan="1">Customer Information</th>
                                <th colspan="3">Sending Tracking Information</th>
                                <th colspan="2">Receiving Tracking Information</th>
                                <th colspan="4">Sending To Patients</th>
                                <th colspan="4">Receiving From Patients</th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                            </tr>
                            <tr>
                                <th>Name & Email</th>
                                <th>Order Id</th>
                                <th>Order</th>
                                <th>Lab</th>
                                <th>Order</th>
                                <th>Lab</th>
                                <th>Order Status</th>
                                <th>Shipper</th>
                                <th>Lab Status</th>
                                <th>Shipper</th>
                                <th>Order Status</th>
                                <th>Shipper</th>
                                <th>Lab Status</th>
                                <th>Shipper</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderStatus" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Status </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="order_id" name="order_id" value="">

                        <div class="form-group">
                            <label>Type<span class="text-danger">*</span></label>
                            <select name="sending_type" class="form-control" id="sending_type"
                                    style="width: 100%;!important;">
                                <option value="">Select Type</option>
                                <option value="sending">Sending</option>
                                <option value="receiving">Receiving</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tracking Type<span class="text-danger">*</span></label>
                            <select name="tracking_type" class="form-control" style="width: 100%;!important;">
                                <option value="">Select Status</option>
                                <option value="order">ORDER</option>
                                <option value="lbs">LABS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Order Status<span class="text-danger">*</span></label>
                            <select name="order_status" class="form-control" style="width: 100%;!important;">
                                <option value="">Select Status</option>
                                <option value="Approved">Approved</option>
                                <option value="Placed">Order Placed</option>
                                <option value="Shipped">Order Shipped</option>
                                <option value="Arrived">Order Arrived</option>
                                <option value="Fulfilled">Fulfilled</option>
                                <option value="LabsReady" id="labs_ready">Labs Ready</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close
                        </button>
                        <button type="button" id="orderStatusChange" class="btn btn-primary"
                                onclick="orderStatusChange()">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="shipmentStatus" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Shipping Information</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>

                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="shipping_order_id" name="order_id" value="">
                        <div class="form-group ml-5">
                            <ul class="nav nav-tabs nav-tabs-line">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#sending">
                                        <span class="nav-icon"><i class="fas fa-arrow-alt-circle-up"></i> </span>
                                        <span class="nav-text">Sending To Patients</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#receiving">
                                        <span class="nav-icon"><i class="fas fa-arrow-circle-down"></i></span>
                                        <span class="nav-text">Receiving To Patients</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="sending" role="tabpanel"
                                 aria-labelledby="sending">
                                <div class="form-group">
                                    <label>Type<span class="text-danger">*</span></label>
                                    <select name="tracking_type" class="form-control" id="sending_tracking_type"
                                            style="width: 100%;!important;">
                                        <option value="">Select Type</option>
                                        <option value="order">ORDER</option>
                                        <option value="lab">LABS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Shipment Status<span class="text-danger">*</span></label>
                                    <select name="shipment_status" class="form-control" id="sending_shipment_status"
                                            style="width: 100%;!important;">
                                        <option value="">Select Status</option>
                                        <option value="Fedex">FedEx</option>
                                        <option value="USPS">USPS</option>
                                        <option value="UPS">UPS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tracking No<span class="text-danger">*</span></label>
                                    <input type="text" name="tracking_no" class="form-control" id="sending_tracking_no"
                                           placeholder="Tracking No">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="receiving" role="tabpanel" aria-labelledby="receiving">
                                <input type="hidden" name="receiving_type" id="receiving_type" value="receiving">
                                <div class="form-group">
                                    <label>Type<span class="text-danger">*</span></label>
                                    <select name="tracking_type" class="form-control" id="receiving_tracking_type"
                                            style="width: 100%;!important;">
                                        <option value="">Select Type</option>
                                        <option value="order">ORDER</option>
                                        <option value="lab">LABS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Shipment Status<span class="text-danger">*</span></label>
                                    <select name="shipment_status" class="form-control" id="receiving_shipment_status"
                                            style="width: 100%;!important;">
                                        <option value="">Select Status</option>
                                        <option value="Fedex">FedEx</option>
                                        <option value="USPS">USPS</option>
                                        <option value="UPS">UPS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tracking No<span class="text-danger">*</span></label>
                                    <input type="text" name="tracking_no" class="form-control"
                                           id="receiving_tracking_no"
                                           placeholder="Tracking No">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close
                        </button>
                        <button type="button" id="saveShipmentStatus" class="btn btn-primary"
                                onclick="saveShipmentStatus()">Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="trackingHistory" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tracking History </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="order_id" name="order_id" value="">
                        <div data-scroll="true" data-height="500">
                            <div id="trackingHistoryTimeline">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/datatables/basic/scrollable.js')}}"></script>
    <script>

        @if (!empty($AJAX_PATH))
        var ajaxTable = $('#order_table').DataTable({
            scrollX: true,
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'customer_details',
                    name: 'customer_details',
                },
                {
                    data: 'order_id',
                    name: 'order_id',
                },
                {
                    data: 'sending_order_tracking_no',
                    name: 'sending_order_tracking_no',
                },
                {
                    data: 'sending_lab_tracking_no',
                    name: 'sending_lab_tracking_no',
                },
                {
                    data: 'receiving_order_tracking_no',
                    name: 'receiving_order_tracking_no',
                },
                {
                    data: 'receiving_lab_tracking_no',
                    name: 'receiving_lab_tracking_no',
                },
                {
                    data: 'sending_order_status',
                    name: 'sending_order_status',
                },
                {
                    data: 'sending_order_shipment_status',
                    name: 'sending_order_shipment_status',
                },

                {
                    data: 'sending_lab_status',
                    name: 'sending_lab_status',
                },

                {
                    data: 'sending_lab_shipment_status',
                    name: 'sending_lab_shipment_status',
                },

                {
                    data: 'receiving_order_status',
                    name: 'receiving_order_status',
                },

                {
                    data: 'receiving_order_shipment_status',
                    name: 'receiving_order_shipment_status',
                },

                {
                    data: 'receiving_lab_status',
                    name: 'receiving_lab_status',
                },

                {
                    data: 'receiving_lab_shipment_status',
                    name: 'receiving_lab_shipment_status',
                },

                {
                    data: 'payment_status',
                    name: 'payment_status',
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        });
        @endif

        $(document).on("click", ".orderStatus", function () {
            var Id = $(this).data('id');
            $("input[name=order_id]").val(Id);
            $('#orderStatus').modal('show');
        });

        $(document).on("click", ".trackingHistory", function () {
            var Id = $(this).data('id');
            trackingHistory(Id);
            $('#trackingHistory').modal('show');

        });

        $(document).on("click", ".shipmentStatus", function () {
            var Id = $(this).data('id');
            $("input[name=order_id]").val(Id);
            $('#shipmentStatus').modal('show');
        });

        function trackingHistory(orderId) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ url('get-tracking-history') }}',
                type: 'POST',
                data: {
                    order_id: orderId
                },
                success: function (response) {
                    $.each(response[0], function (key, value) {
                        $('#trackingHistoryTimeline').append('<div class="timeline timeline-3 mt-3"><div class="timeline-items"><div class="timeline-item"><div class="timeline-media"><i class="flaticon2-notification fl text-primary"></i></div><div class="timeline-content"><div class="d-flex align-items-center justify-content-between mb-3"><div class="mr-2"><span class="text-muted ml-2">' + value.date + '</span><span class="label label-light-primary font-weight-bolder label-inline ml-2">' + value.status + '</span></div></div><p class="p-0">' + value.description + '</p></div></div></div></div>');
                    });
                }
            });
        }

        function orderStatusChange() {
            $('#orderStatusChange').addClass('spinner spinner-white spinner-right');
            var order_id = $("input[name=order_id]").val();
            var orderStatus = $("select[name=order_status]").val();
            var tracking_type = $("select[name=tracking_type]").val();
            var sending_type = $("select[name=sending_type]").val();
            $.ajax({
                url: "/order-status-change",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order_id: order_id,
                    order_status: orderStatus,
                    tracking_type: tracking_type,
                    sending_type: sending_type,
                },
                success: function (response) {
                    if (response.status) {
                        ajaxTable.ajax.reload();
                        $('#orderStatusChange').removeClass('spinner spinner-white spinner-right');
                        $('#orderStatus').modal('toggle');
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                        $('#orderStatusChange').removeClass('spinner spinner-white spinner-right');
                    }
                },
            });
        }

        function saveShipmentStatus() {
            var order_id = $('#shipping_order_id').val();
            var sending_shipment_status = $('#sending_shipment_status').val();
            var sending_tracking_no = $('#sending_tracking_no').val();
            var sending_tracking_type = $('#sending_tracking_type').val();
            var receiving_shipment_status = $('#receiving_shipment_status').val();
            var receiving_tracking_no = $('#receiving_tracking_no').val();
            var receiving_tracking_type = $('#receiving_tracking_type').val();
            $.ajax({
                url: "/save-shipment-status",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order_id: order_id,
                    sending_shipment_status: sending_shipment_status,
                    sending_tracking_no: sending_tracking_no,
                    sending_tracking_type: sending_tracking_type,
                    receiving_shipment_status: receiving_shipment_status,
                    receiving_tracking_no: receiving_tracking_no,
                    receiving_tracking_type: receiving_tracking_type,
                },
                success: function (response) {
                    if (response.success) {
                        ajaxTable.ajax.reload();
                        $('#shipmentStatus').modal('toggle');
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }
                },
            });
        }

        $('#labs_ready').hide();
        $('select[name=tracking_type]').on('change', function () {
            var trackingType = $(this).val();
            if (trackingType == 'lbs') {
                $('#labs_ready').show();
            } else {
                $('#labs_ready').hide();
            }
        });

        function copyUrl(URL){
            console.log("called",URL);
            try {
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
                navigator.clipboard.writeText(URL);
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

    </script>

@endpush



