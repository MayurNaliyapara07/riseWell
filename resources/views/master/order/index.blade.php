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
                                <th colspan="3">Tracking Information</th>
                                <th colspan="2">Sending To Patients </th>
                                <th colspan="2">Receiving To Patients </th>
                                <th colspan="1"></th>
                                <th colspan="1"></th>
                            </tr>
                            <tr>
                                <th>Name & Email</th>
                                <th>Order Id</th>
                                <th>Order No</th>
                                <th>Labs No</th>
                                <th>Status</th>
                                <th>Shipper</th>
                                <th>Status</th>
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
                                    <span class="nav-icon"><i class="
fas fa-arrow-circle-down"></i></span>
                                    <span class="nav-text">Receiving To Patients</span>
                                </a>
                            </li>
                        </ul>
                        </div>
                        <input type="hidden" id="order_id" name="order_id" value="">
                        <div class="form-group">
                            <label>Type<span class="text-danger">*</span></label>
                            <select name="tracking_type" id="tracking_type" class="form-control"
                                    style="width: 100%;!important;">
                                <option value="">Select Type</option>
                                <option value="order">ORDER</option>
                                <option value="lbs">LABS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Shipment Status<span class="text-danger">*</span></label>
                            <select name="shipment_status" class="form-control" style="width: 100%;!important;">
                                <option value="">Select Status</option>
                                <option value="Fedex">FedEx</option>
                                <option value="USPS">USPS</option>
                                <option value="UPS">UPS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tracking No<span class="text-danger">*</span></label>
                            <input type="text" name="tracking_no" class="form-control" placeholder="Tracking No">
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

    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/datatables/basic/scrollable.js')}}"></script>
    <script>

        @if (!empty($AJAX_PATH))
        var ajaxTable = $('#order_table').DataTable({
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
                    data: 'order_tracking_no',
                    name: 'order_tracking_no',
                },
                {
                    data: 'lab_tracking_no',
                    name: 'lab_tracking_no',
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                },
                {
                    data: 'order_shipment_status',
                    name: 'order_shipment_status',
                },
                {
                    data: 'lab_status',
                    name: 'lab_status',
                },

                {
                    data: 'lab_shipment_status',
                    name: 'lab_shipment_status',
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

        $(document).on("click", ".shipmentStatus", function () {
            var Id = $(this).data('id');
            $("input[name=order_id]").val(Id);
            $('#shipmentStatus').modal('show');
        });

        function orderStatusChange() {
            $('#orderStatusChange').addClass('spinner spinner-white spinner-right');
            var order_id = $("input[name=order_id]").val();
            var orderStatus = $("select[name=order_status]").val();
            var tracking_type = $("select[name=tracking_type]").val();
            $.ajax({
                url: "/order-status-change",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order_id: order_id,
                    order_status: orderStatus,
                    tracking_type: tracking_type,
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
            var order_id = $("input[name=order_id]").val();
            var shipment_status = $("select[name=shipment_status]").val();
            var tracking_no = $("input[name=tracking_no]").val();
            var tracking_type = $('#tracking_type').val();
            $.ajax({
                url: "/save-shipment-status",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order_id: order_id,
                    shipment_status: shipment_status,
                    tracking_no: tracking_no,
                    tracking_type: tracking_type,
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

    </script>

@endpush



