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
                                <th>Order Id</th>
                                <th> Name</th>
                                <th>Customer Email</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
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
                    data: 'order_id',
                    name: 'order_id',
                },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                },
                {
                    data: 'customer_email',
                    name: 'customer_email',
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

        function orderStatusChange(){
            var order_id = $("input[name=order_id]").val();
            var orderStatus = $("select[name=order_status]").val();
            $.ajax({
                url: "/order-status-change",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    order_id: order_id,
                    order_status: orderStatus,
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

    </script>

@endpush



