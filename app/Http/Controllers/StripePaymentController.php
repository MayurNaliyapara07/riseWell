<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Patients;
use App\Models\PaymentGatewayCredentials;
use App\Models\Product;
use App\Notifications\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{

    protected $stripe;
    protected $stripe_secret_key;

    public function __construct()
    {
        $stripeDetails = GeneralSetting::first();
        $this->stripe_secret_key = $stripeDetails->stripe_secret_key;
        $this->stripe = new \Stripe\StripeClient($this->stripe_secret_key);
    }

    public function oneTimeCheckout($data)
    {
        $orderType = !empty($data['order_type']) ? $data['order_type'] : "";
        if ($orderType == "OneTime") {
            $mode = 'payment';
        } else {
            $mode = 'subscription';
        }
        $patientsId = !empty($data['patients_id']) ? $data['patients_id'] : '';
        $orderDetails['order_details'] = $data['order_details'];
        $orderDetails['patients_id'] = $patientsId;
        $orderDetails['mode'] = $mode;
        return $this->checkout($orderDetails);

    }

    public function checkout($data)
    {

        \Stripe\Stripe::setApiKey($this->stripe_secret_key);

        $patientId = !empty($data['patients_id']) ? $data['patients_id'] : $data;

        $patients = $this->getPatientDetails($patientId);

        $productId = !empty($patients) ? $patients->product_id : '';

        if (isset($productId)) {

            $product = $this->getProductDetails($productId);

            $customerName = !empty($patients) ? $patients->first_name . " " . $patients->last_name : '';

            $customerEmail = !empty($patients) ? $patients->email : '';

            $customerPhoneNo = !empty($patients) ? $patients->phone_no : '';

            $stripePlan = !empty($product->stripe_plan) ? $product->stripe_plan : '';

            if (!empty($stripePlan)) {

                $productName = !empty($product->product_name) ? $product->product_name : '';

                $price = !empty($product->price) ? $product->price : 0;

                $discount = !empty($product->discount) ? ($product->discount * 100) : 0;

                $shippingCost = !empty($product->shipping_cost) ? ($product->shipping_cost * 100) : 0;

                $processingFees = !empty($product->processing_fees) ? ($product->processing_fees * 100) : 0;

                $subTotal = $processingFees + $shippingCost;

                $totalPrice = number_format($subTotal - $discount, 2);

                $orderDetails = !empty($data['order_details']) ? $data['order_details'] : '';
                if (!empty($orderDetails) && count($orderDetails) > 0) {
                    foreach ($orderDetails as $order) {
                        $lineItems[] = array(
                            'price' => $order['product_id'],
                            'quantity' => (int)$order['qty'],
                        );
                    }
                }

                $customer = $this->stripe->customers->create([
                    'name' => $customerName,
                    'phone' => $customerPhoneNo,
                    'email' => $customerEmail,
                    'description' => 'Customer',
                ]);


                $discountId = "discount_" . rand(0, 99999);
                $coupons = $this->stripe->coupons->create([
                    'name' => 'Coupon',
                    'currency' => 'usd',
                    'duration' => 'once',
                    'id' => $discountId,
                    'amount_off' => $discount,
                ]);
                $couponsId = $coupons->id;


                $shippingRates = $this->stripe->shippingRates->create([
                    'display_name' => 'Shipping Rate & Processing Fees',
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                        'amount' => $subTotal,
                        'currency' => 'usd',
                    ],
                ]);
                $shippingRateId = $shippingRates->id;


                $session = \Stripe\Checkout\Session::create([
                    'customer' => !empty($customer->id) ? $customer->id : "",
                    'line_items' => [
                        [
                            'price_data' => [
                                'product_data' => [
                                    'name' => $productName
                                ],
                                'unit_amount' => $price * 100,
                                'currency' => 'USD',
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'discounts' => [[
                        'coupon' => $couponsId,
                    ]],
                    'shipping_options' => [['shipping_rate' => $shippingRateId]],
                    'mode' => 'payment',
                    'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}&patients_id=$patientId",
                    'cancel_url' => route('checkout.cancel', [], true),
                ]);

                return \redirect()->away($session->url);
            }
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $stripeRecord = $this->stripe->checkout->sessions->retrieve($sessionId);
        $stripeRecord['patients_id'] = $request->get('patients_id');
        return $this->addToOrdersTables($stripeRecord);
    }

    public function webhook(Request $request)
    {

    }

    public function getPatientDetails($patientsId)
    {
        $patientObj = new Patients();
        $patientsTable = $patientObj->getTable();
        $patientDetails = $patientObj->setSelect()
            ->addFieldToFilter($patientsTable, 'patients_id', '=', $patientsId)
            ->get()
            ->first();
        return $patientDetails;
    }

    public function getProductDetails($productId)
    {
        $productObj = new Product();
        $productTable = $productObj->getTable();
        $productDetails = $productObj->setSelect()
            ->addFieldToFilter($productTable, 'product_id', '=', $productId)
            ->get()
            ->first();

        return $productDetails;
    }

    public function addToOrdersTables($stripeRecord)
    {


        $sessionId = $stripeRecord->id;
        $paymentStatus = $stripeRecord->payment_status;
        $status = $stripeRecord->status;
        $subTotal = !empty($stripeRecord->amount_subtotal) ? $stripeRecord->amount_subtotal : 0;
        $totalAmount = !empty($stripeRecord->amount_total) ? $stripeRecord->amount_total : 0;
        $mode = !empty($stripeRecord->mode) ? $stripeRecord->mode : '';
        $subscriptionId = !empty($stripeRecord->subscription) ? $stripeRecord->subscription : '';
        $currency = !empty($stripeRecord->currency) ? $stripeRecord->currency : '';
        $customerId = !empty($stripeRecord) ? $stripeRecord->customer : '';
        $customerDetails = !empty($stripeRecord->customer_details) ? $stripeRecord->customer_details->address : '';
        $customerEmail = !empty($stripeRecord->customer_details) ? $stripeRecord->customer_details->email : '';
        $customerName = !empty($stripeRecord->customer_details) ? $stripeRecord->customer_details->name : '';
        $customerPhoneNo = !empty($stripeRecord->customer_details) ? $stripeRecord->customer_details->phone : '';
        $address = !empty($customerDetails) ? json_encode($customerDetails) : '';
        $cardDetails = $this->stripe->customers->allPaymentMethods($customerId, ['type' => 'card']);
        $paymentMethodId = !empty($cardDetails['data'][0]) ? $cardDetails['data'][0]['id'] : '';
        $card = !empty($cardDetails['data'][0]) ? $cardDetails['data'][0]['card'] : '';
        $cardBrand = !empty($card['brand']) ? $card['brand'] : '';
        $cardExpireMonth = !empty($card['exp_month']) ? $card['exp_month'] : '';
        $cardExpireYear = !empty($card['exp_year']) ? $card['exp_year'] : '';
        $cardNo = !empty($card['last4']) ? $card['last4'] : '';
        $invoiceId = !empty($stripeRecord) ? $stripeRecord->invoice : '';
        $patientsId = !empty($stripeRecord->patients_id) ? $stripeRecord->patients_id : 0;
        if (!empty($invoiceId)) {
            $invoiceDetails = $this->stripe->invoices->retrieve($invoiceId);
            $productDetails = !empty($invoiceDetails['lines']['data']) ? json_encode($invoiceDetails['lines']['data']) : '';
            $invoicePdf = !empty($invoiceDetails['invoice_pdf']) ? $invoiceDetails['invoice_pdf'] : '';
            $discountDetails = !empty($invoiceDetails['discount']) ? json_encode($invoiceDetails['discount']) : "";
        }
        if ($paymentStatus == 'paid' && $status == 'complete') {
            $order = [
                'session_id' => !empty($sessionId) ? $sessionId : '',
                'patients_id' => $patientsId,
                'product_details' => !empty($productDetails) ? $productDetails : '',
                'discount_details' => !empty($discountDetails) ? $discountDetails : '',
                'customer_email' => !empty($customerEmail) ? $customerEmail : '',
                'customer_name' => !empty($customerName) ? $customerName : '',
                'customer_phone_no' => !empty($customerPhoneNo) ? $customerPhoneNo : '',
                'currency' => !empty($currency) ? $currency : "",
                'customer_id' => !empty($customerId) ? $customerId : '',
                'customer_address' => !empty($address) ? $address : '',
                'invoice_id' => !empty($invoiceId) ? $invoiceId : '',
                'invoice_pdf' => !empty($invoicePdf) ? $invoicePdf : '',
                'subscription_id' => !empty($subscriptionId) ? $subscriptionId : '',
                'payment_method_id' => !empty($paymentMethodId) ? $paymentMethodId : '',
                'mode' => !empty($mode) ? $mode : '',
                'payment_status' => !empty($paymentStatus) ? $paymentStatus : '',
                'card_brand' => !empty($cardBrand) ? $cardBrand : '',
                'exp_month' => !empty($cardExpireMonth) ? $cardExpireMonth : '',
                'exp_year' => !empty($cardExpireYear) ? $cardExpireYear : '',
                'last4' => !empty($cardNo) ? $cardNo : '',
                'status' => !empty($status) ? $status : '',
                'sub_total' => !empty($subTotal) ? $subTotal : '',
                'total_amount' => !empty($totalAmount) ? $totalAmount : '',
                'order_status' => 'OrderPlaced',
            ];
            $order = Order::create($order);
            $order['traking_url'] = url('order-track') . "/" . $order->order_id;
//            Mail::to($customerEmail)->send(new OrderPlaced($order));
            return redirect()->route('home');
        }


    }


}
