@extends('layouts.app')
@section('content')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Order',
            'directory'=>'master',
            'back' => 'order.index'
        ])
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form" id="kt_form">
                        <div class="row">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8">
                                <div class="my-5">

                                    <div class="my-5">
                                        <h3 class=" text-dark font-weight-bold mb-10">Customer Details :</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Customer Name</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" value="{{!empty($order->customer_name)?$order->customer_name:''}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Customer Email</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" value="{{!empty($order->customer_email)?$order->customer_email:''}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Customer Phone No</label>
                                            <div class="col-9">
                                                <input class="form-control" type="text" value="{{!empty($order->customer_phone_no)?$order->customer_phone_no:''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class=" text-dark font-weight-bold mb-10">Order Info :</h3>

                                    <div class="form-group row">
                                        <label class="col-3">Session Id</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->session_id:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Currency</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->currency:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Customer Id</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->customer_id:''}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Invoice Id</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->invoice_id:''}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Subscripation Id</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->subscription_id:''}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Payment Method Id</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->payment_method_id:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Mode</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->mode:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Payment Status</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->payment_status:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Status</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->status:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Sub Total</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->sub_total:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Total Amount</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($order)?$order->total_amount:''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-10"></div>
                                <?php
                                    $address = !empty($order->customer_address)?json_decode($order->customer_address):'';

                                ?>
                                <div class="my-5">
                                    <h3 class=" text-dark font-weight-bold mb-10">Address Details :</h3>
                                    <div class="form-group row">
                                        <label class="col-3">Address Line 1</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->line1)?$address->line1:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Address Line 2</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->line2)?$address->line2:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Address Line 3</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->line3)?$address->line3:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">City</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->city)?$address->city:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Country</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->country)?$address->country:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">State</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->state)?$address->state:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3">Zip / Postal Code</label>
                                        <div class="col-9">
                                            <input class="form-control" type="text" value="{{!empty($address->postal_code)?$address->postal_code:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2"></div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
@endsection




