<!DOCTYPE html>
<html lang="en, id">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>
        Order
    </title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    />
    <style>
        @import "https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap";

        * {
            margin: 0;
            padding: 0;
            user-select: none;
        }

        body {
            padding: 20px;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            -webkit-font-smoothing: antialiased;
            background-color: #dcdcdc;
        }

        .wrapper-invoice {
            display: flex;
            justify-content: center;
        }

        .wrapper-invoice .invoice {
            height: auto;
            background: #fff;
            padding: 5vh;
            margin-top: 5vh;
            max-width: 110vh;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #dcdcdc;
        }

        .wrapper-invoice .invoice .invoice-information {
            float: right;
            text-align: right;
        }

        .wrapper-invoice .invoice .invoice-information b {
            color: #0F172A;
        }

        .wrapper-invoice .invoice .invoice-information p {
            font-size: 2vh;
            color: gray;
        }

        .wrapper-invoice .invoice .invoice-logo-brand h2 {
            text-transform: uppercase;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            font-size: 2.9vh;
            color: #0F172A;
        }

        .wrapper-invoice .invoice .invoice-logo-brand img {
            max-width: 100px;
            width: 100%;
            object-fit: fill;
        }

        .wrapper-invoice .invoice .invoice-head {
            display: flex;
            margin-top: 8vh;
        }

        .wrapper-invoice .invoice .invoice-head .head {
            width: 100%;
            box-sizing: border-box;
        }

        .wrapper-invoice .invoice .invoice-head .client-info {
            text-align: left;
        }

        .wrapper-invoice .invoice .invoice-head .client-info h2 {
            font-weight: 500;
            letter-spacing: 0.3px;
            font-size: 2vh;
            color: #0F172A;
        }

        .wrapper-invoice .invoice .invoice-head .client-info p {
            font-size: 2vh;
            color: gray;
        }

        .wrapper-invoice .invoice .invoice-head .client-data {
            text-align: right;
        }

        .wrapper-invoice .invoice .invoice-head .client-data h2 {
            font-weight: 500;
            letter-spacing: 0.3px;
            font-size: 2vh;
            color: #0F172A;
        }

        .wrapper-invoice .invoice .invoice-head .client-data p {
            font-size: 2vh;
            color: gray;
        }

        .wrapper-invoice .invoice .invoice-body {
            margin-top: 8vh;
        }

        .wrapper-invoice .invoice .invoice-body .table {
            border-collapse: collapse;
            width: 100%;
        }

        .wrapper-invoice .invoice .invoice-body .table thead tr th {
            font-size: 2vh;
            border: 1px solid #dcdcdc;
            text-align: left;
            padding: 1vh;
            background-color: #eeeeee;
        }

        .wrapper-invoice .invoice .invoice-body .table tbody tr td {
            font-size: 2vh;
            border: 1px solid #dcdcdc;
            text-align: left;
            padding: 1vh;
            background-color: #fff;
        }

        .wrapper-invoice .invoice .invoice-body .table tbody tr td:nth-child(2) {
            text-align: right;
        }

        .wrapper-invoice .invoice .invoice-body .flex-table {
            display: flex;
        }

        .wrapper-invoice .invoice .invoice-body .flex-table .flex-column {
            width: 100%;
            box-sizing: border-box;
        }

        .wrapper-invoice .invoice .invoice-body .flex-table .flex-column .table-subtotal {
            border-collapse: collapse;
            box-sizing: border-box;
            width: 100%;
            margin-top: 2vh;
        }

        .wrapper-invoice .invoice .invoice-body .flex-table .flex-column .table-subtotal tbody tr td {
            font-size: 2vh;
            border-bottom: 1px solid #dcdcdc;
            text-align: left;
            padding: 1vh;
            background-color: #fff;
        }

        .wrapper-invoice .invoice .invoice-body .flex-table .flex-column .table-subtotal tbody tr td:nth-child(2) {
            text-align: right;
        }

        .wrapper-invoice .invoice .invoice-body .invoice-total-amount {
            margin-top: 1rem;
        }

        .wrapper-invoice .invoice .invoice-body .invoice-total-amount p {
            font-weight: bold;
            color: #0F172A;
            text-align: right;
            font-size: 2vh;
        }

        .wrapper-invoice .invoice .invoice-footer {
            margin-top: 4vh;
        }

        .wrapper-invoice .invoice .invoice-footer p {
            font-size: 1.7vh;
            color: gray;
        }

        .copyright {
            margin-top: 2rem;
            text-align: center;
        }

        .copyright p {
            color: gray;
            font-size: 1.8vh;
        }

        @media print {
            .table thead tr th {
                -webkit-print-color-adjust: exact;
                background-color: #eeeeee !important;
            }

            .copyright {
                display: none;
            }
        }

        .rtl {
            direction: rtl;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }

        .rtl .invoice-information {
            float: left !important;
            text-align: left !important;
        }

        .rtl .invoice-head .client-info {
            text-align: right !important;
        }

        .rtl .invoice-head .client-data {
            text-align: left !important;
        }

        .rtl .invoice-body .table thead tr th {
            text-align: right !important;
        }

        .rtl .invoice-body .table tbody tr td {
            text-align: right !important;
        }

        .rtl .invoice-body .table tbody tr td:nth-child(2) {
            text-align: left !important;
        }

        .rtl .invoice-body .flex-table .flex-column .table-subtotal tbody tr td {
            text-align: right !important;
        }

        .rtl .invoice-body .flex-table .flex-column .table-subtotal tbody tr td:nth-child(2) {
            text-align: left !important;
        }

        .rtl .invoice-body .invoice-total-amount p {
            text-align: left !important;
        }

        /*# sourceMappingURL=invoice.css.map */

    </style>
</head>
<body>
<?php

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Helpers\BaseHelper;

$baseHelper = new BaseHelper();
$currency = !empty($order) ? strtoupper($order->currency) : "";
$product = $baseHelper->getStripeProductDetails(json_decode($order->product_details));
$shippingAndProcessingCost = !empty($order->shipping_and_processing_amount) ? new Money($order->shipping_and_processing_amount, new Currency($currency)) : 0;
$shippingCost = !empty($order->shipping_and_processing_amount) ? $order->shipping_and_processing_amount : 0;

?>
<section class="wrapper-invoice">
    <!-- switch mode rtl by adding class rtl on invoice class -->
    <div class="invoice">
        <div class="invoice-information">
            <p><b>OrderId </b> : {{!empty($order)?$order->order_id:""}}</p>
            <p><b>Order Date </b>: {{!empty($order)?$baseHelper->dateFormat($order->created_at,'formate-3'):''}}</p>
            <p><b>Order Status</b> : NewOrder</p>
        </div>
        <!-- logo brand invoice -->
        <div class="invoice-logo-brand">
            <!-- <h2>Tampsh.</h2> -->
            <img src="https://risewell.health/wp-content/themes/healthcare/assets/images/dark-logo.png" alt=""/>
        </div>
        <!-- invoice head -->
        <div class="invoice-head">
            <div class="head client-info">
                <p style="margin-bottom: 5px;"><b>Customer Information</b></p>
                <p>Name : {{!empty($order->customer_name)?$order->customer_name:''}}</p>
                <p>Email : {{!empty($order->customer_email)?$order->customer_email:''}}</p>
                <p>Phone No : {{!empty($order->customer_phone_no)?$order->customer_phone_no:''}}</p>
                <p>Currency : {{!empty($order)?$order->currency:''}}</p>
            </div>
            <div class="head client-data">
                <?php
                $address = !empty($order->customer_address) ? json_decode($order->customer_address) : '';
                ?>
                <p style="margin-bottom: 5px;"><b>Billing To</b></p>
                <p><span>Address: </span> {{!empty($address->line1)?$address->line1:''}}
                    ,{{!empty($address->line2)?$address->line2:''}}</p>
                <p><span>Country: </span> {{!empty($address->country)?$address->country:''}}</p>
                <p><span>State: </span> {{!empty($address->state)?$address->state:''}}</p>
                <p><span>City: </span> {{!empty($address->city)?$address->city:''}}</p>
                <p><span>Postal Code: </span> {{!empty($address->postal_code)?$address->postal_code:''}}</p>
            </div>
        </div>
        @if(!empty($product))
                <?php $subTotal = 0; ?>
            <div class="invoice-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item</th>
                        <th>Unit Cost</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product as $key=>$item)
                        @php
                            $itemTotal = $item['total'];
                        @endphp
                        <tr>
                            <td>{{$key+1}}</td>
                            <td style="text-align: left">{{$item['product_name']}}</td>
                            <td>{{!empty($item['unit_cost'])?$item['unit_cost']:0}}</td>
                            <td>{{!empty($item['quantity'])?$item['quantity']:0}}</td>
                            <td>{{!empty($item['unit_cost'])?$item['unit_cost']:0}}</td>
                        </tr>
                        @php
                            $subTotal += $item['sub_total'];
                            $discountAmount = $item['discount_amount'];
                            $discount = new Money($item['discount_amount'],new Currency($item['currency']));
                        @endphp
                    @endforeach
                    </tbody>
                </table>
                <div class="flex-table">
                    <div class="flex-column"></div>
                    <div class="flex-column">
                        <table class="table-subtotal">
                            <tbody>
                                <?php

                                $shippingWithSubTotal = $subTotal + $shippingCost;
                                $totalAmount = new Money($shippingWithSubTotal - $discountAmount, new Currency($currency));

                                ?>
                            <tr>
                                <td>Subtotal</td>
                                <td>{{$itemTotal}}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charges & Processing Fees</td>
                                <td>{{$shippingAndProcessingCost}}</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>{{$discount}}</td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td>{{$totalAmount}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- invoice total  -->
                <div class="invoice-total-amount">
                    <p>Total : {{$totalAmount}}</p>
                </div>
            </div>
        @endif
        <div class="invoice-footer">
            <p>Thankyou, happy shopping again</p>
        </div>
    </div>
</section>
<div class="copyright">
    <p>@ healthcare.trialview.in</p>
</div>
</body>
</html>
