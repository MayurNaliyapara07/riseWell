@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Product',
            'directory'=>'master',
            'create'=>'product.create',
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="product_table" style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Status</th>
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
        var ajaxTable = $('#product_table').DataTable({
            processing: false,
            serverSide: true,
            ordering: false,
            stateSave: true,
            pagingType: "full_numbers",
            ajax: "{{url(!empty($AJAX_PATH)?$AJAX_PATH:'/')}}",
            lengthMenu: [[10, 25, 50, 100, 500, 1000000], [10, 25, 50, 100, 500, "All"]],
            columns: [
                {
                    data: 'image',
                    name: 'image',
                },
                {
                    data: 'category_name',
                    name: 'category_name',
                },
                {
                    data: 'product_name',
                    name: 'product_name',
                },
                {
                    data: 'sku',
                    name: 'sku',
                },
                {
                    data: 'price',
                    name: 'price',
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

        function productChangeStatus(route, id = 0) {
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



