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
                               id="order_table" style="margin-top: 13px !important;width:auto !important;">
                            <thead>
                            <tr>
                                <th>Customer Details</th>
                                <th>Tracking No</th>
                                <th>Order Id</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                                <th>Shipment Status</th>
                                <th>Created At</th>
                                <th>Action</th>
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
                                <option value="OrderShipped">Order Shipped</option>
                                <option value="OrderArrived">Order Arrived</option>
                                <option value="Fulfilled">Fulfilled</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close
                        </button>
                        <button type="button" id="orderStatusChange" class="btn btn-primary" onclick="orderStatusChange()">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="shipmentStatus" data-backdrop="static" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sending To Patients</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="order_id" name="order_id" value="">
                        <div class="form-group">
                            <label>Type<span class="text-danger">*</span></label>
                            <select name="tracking_type" id="tracking_type" class="form-control" style="width: 100%;!important;">
                                <option value="">Select Type</option>
                                <option value="order">ORDER</option>
                                <option value="lbs">LABS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Shipment  Status<span class="text-danger">*</span></label>
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
                        <button type="button" id="saveShipmentStatus" class="btn btn-primary" onclick="saveShipmentStatus()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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
                    data: 'order_tracking_no',
                    name: 'order_tracking_no',
                },
                {
                    data: 'order_id',
                    name: 'order_id',
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
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
                    data: 'created_at',
                    name: 'created_at',
                    orderable: false,
                    searchable: false
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

        function orderStatusChange(){
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
                        $('#orderStatus').modal('toggle');
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }
                },
            });
        }

        function saveShipmentStatus(){
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

    </script>

@endpush



