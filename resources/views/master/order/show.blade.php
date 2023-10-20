@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.app')
@section('content')

    <?php
    $productDetails = \Illuminate\Support\Facades\DB::table('product')->where('product_id',$order->product_id)->first();
    $currency = !empty($order) ? strtoupper($order->currency) : "";
    $product = $baseHelper->getStripeProductDetails(json_decode($order->product_details));
    $shippingAndProcessingCost = !empty($order->shipping_and_processing_amount) ? new \Akaunting\Money\Money($order->shipping_and_processing_amount, new \Akaunting\Money\Currency($currency)) : 0;
    $shippingCost = !empty($order->shipping_and_processing_amount) ? $order->shipping_and_processing_amount : 0;
    ?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Order',
            'directory'=>'master',
            'back' => 'order.index'
        ])
        <div class="container">
            <div class="card">
                <div class="card-header">
                    Invoice
                    <strong>{{!empty($order)?$baseHelper->dateFormat($order->created_at,'formate-3'):''}}</strong>
                    <span class="float-right"> <strong>Status: </strong><span
                            class="text-capitalize">{{!empty($order)?$order->status:''}}</span></span>

                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Customer:</h6>
                            <div><strong>Payment Mode : </strong> {{!empty($order)?$order->mode:''}}</div>
                            <div><strong>ID : </strong> {{!empty($order)?$order->customer_id:''}}</div>
                            <div><strong>Name : </strong> {{!empty($order->customer_name)?$order->customer_name:''}}
                            </div>
                            <div><strong>Email :</strong> {{!empty($order->customer_email)?$order->customer_email:''}}
                            </div>
                            <div><strong>PhoneNo
                                    :</strong> {{!empty($order->customer_phone_no)?$order->customer_phone_no:''}}</div>
                            <div><strong>Currency : </strong> {{!empty($order)?$order->currency:''}}</div>

                            <div><strong>Product Requested : </strong>{{!empty($order->is_product_requested)?$productDetails->product_name:'No'}}</div>

                        </div>
                        <?php
                        $address = !empty($order->customer_address) ? json_decode($order->customer_address) : '';
                        ?>
                        <div class="col-sm-6">
                            <h6 class="mb-3">Billing To:</h6>
                            <div><strong>Address : </strong> {{!empty($address->line1)?$address->line1:''}}
                                , {{!empty($address->line2)?$address->line2:''}}
                                , {{!empty($address->line3)?$address->line3:''}}</div>
                            <div><strong>Country : </strong> {{!empty($address->country)?$address->country:''}}</div>
                            <div><strong>State : </strong> {{!empty($address->state)?$address->state:''}}</div>
                            <div><strong>City: </strong> {{!empty($address->city)?$address->city:''}}</div>
                            <div><strong>Zip / Postal Code: </strong> {{!empty($address->postal_code)?$address->postal_code:''}}</div>
                        </div>
                    </div>
                    <?php $subTotal = $itemTotal = $discountAmount = 0;

                    ?>


                    @if(!empty($product))
                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Product</th>
                                    <th class="right">Unit Cost</th>
                                    <th class="center">Qty</th>
                                    <th class="right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product as $key=>$item)
                                    @php
                                        $itemTotal = $item['total'];
                                    @endphp
                                    <tr>
                                        <td class="center">{{$key+1}}</td>
                                        <td class="left strong">{{$item['product_name']}}</td>
                                        <td class="right">{{$item['unit_cost']}}</td>
                                        <td class="center">{{$item['quantity']}}</td>
                                        <td class="right">{{$itemTotal}}</td>
                                    </tr>
                                    @php
                                        $subTotal += $item['sub_total'];
                                        $discountAmount = $item['discount_amount'];
                                        $discount = new \Akaunting\Money\Money($item['discount_amount'],new \Akaunting\Money\Currency($item['currency']));;
                                    @endphp
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="row">

                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <?php

                            $shippingWithSubTotal = $subTotal + $shippingCost;
                            $totalAmount = new \Akaunting\Money\Money($shippingWithSubTotal - $discountAmount, new \Akaunting\Money\Currency($currency));

                            ?>
                            <table class="table table-clear">
                                <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td class="right">{{$itemTotal}}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Shipping Charges & Processing Fees</strong>
                                    </td>
                                    <td class="right">{{$shippingAndProcessingCost}}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Discount</strong>
                                    </td>
                                    <td class="right">  {{$discount}}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>{{$totalAmount}}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection




