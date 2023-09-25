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

    public function checkout($patientId)
    {
        \Stripe\Stripe::setApiKey($this->stripe_secret_key);

        $patients = $this->getPatientDetails($patientId);
        $productId = !empty($patients) ? $patients->product_id : '';

        if (isset($productId)) {
            $customerDetails = [
                'customer_name' => !empty($patients) ? $patients->first_name . " " . $patients->last_name : '',
                'customer_email' => !empty($patients) ? $patients->email : '',
                'customer_phone_no' => !empty($patients) ? $patients->phone_no : '',
            ];

            $product = $this->getProductDetails($productId);
            $productName = !empty($product->product_name) ? $product->product_name : '';
            $price = !empty($product->price) ? ($product->price * 100) : 0;
            $discount = !empty($product->discount) ? ($product->discount * 100) : 0;
            $shippingCost = !empty($product->shipping_cost) ? ($product->shipping_cost * 100) : 0;
            $processingFees = !empty($product->processing_fees) ? ($product->processing_fees * 100) : 0;
            $subTotal = $processingFees + $shippingCost;

            /* stripe create customer */
            $customer = $this->createCustomer($customerDetails);

            /* stripe create coupon */
            $couponsId = $this->createCoupon($discount);

            /* stripe create shipping rate & processing fees */
            $shippingRateId = $this->createShippingRate($subTotal);

            $lineItems = [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $productName
                        ],
                        'unit_amount' => $price,
                        'currency' => 'USD',
                    ],
                    'quantity' => 1,
                ],
            ];
            return $this->createSessionCheckout($customer, $lineItems, $couponsId, $shippingRateId, $patientId,'payment');

        }
    }

    public function oneTimeCheckout($request)
    {
        \Stripe\Stripe::setApiKey($this->stripe_secret_key);

        $order_details = !empty($request['order_details']) ? $request['order_details'] : '';

        /* get patients details */
        $patientId = !empty($request['patients_id']) ? $request['patients_id'] : '';
        $patients = $this->getPatientDetails($patientId);
        $customerDetails = [
            'customer_name' => !empty($patients) ? $patients->first_name . " " . $patients->last_name : '',
            'customer_email' => !empty($patients) ? $patients->email : '',
            'customer_phone_no' => !empty($patients) ? $patients->phone_no : '',
        ];

        /* get product details */
        $lineItems = array();
        $discountPrice = $shippingRates = 0;
        foreach ($order_details as $value) {
            $productId = $value['product_id'];
            $qty = $value['qty'];
            $product = $this->getProductDetails($productId);
            $productName = !empty($product->product_name) ? $product->product_name : '';
            $price = !empty($product->price) ? ($product->price * 100) : 0;
            $discount = !empty($product->discount) ? ($product->discount * 100) : 0;
            $shippingCost = !empty($product->shipping_cost) ? ($product->shipping_cost * 100) : 0;
            $processingFees = !empty($product->processing_fees) ? ($product->processing_fees * 100) : 0;
            $subTotal = $processingFees + $shippingCost;
            $lineItems[] = array(
                'price_data' => array(
                    'product_data' => array(
                        'name' => $productName
                    ),
                    'unit_amount' => $price,
                    'currency' => 'USD',
                ),
                'quantity' => $qty,
            );
            $discountPrice += $discount;
            $shippingRates += $subTotal;
        }

        /* stripe create customer */
        $customer = $this->createCustomer($customerDetails);

        /* stripe create coupon */
        $couponsId = $this->createCoupon($discountPrice);

        /* stripe create shipping rate & processing fees */
        $shippingRateId = $this->createShippingRate($shippingRates);

        return $this->createSessionCheckout($customer, $lineItems, $couponsId, $shippingRateId, $patientId,'payment');
    }

    public function subscriptionCheckout($request)
    {


        \Stripe\Stripe::setApiKey($this->stripe_secret_key);

        $order_details = !empty($request['order_details']) ? $request['order_details'] : '';

        /* get patients details */
        $patientId = !empty($request['patients_id']) ? $request['patients_id'] : '';
        $patients = $this->getPatientDetails($patientId);
        $customerDetails = [
            'customer_name' => !empty($patients) ? $patients->first_name . " " . $patients->last_name : '',
            'customer_email' => !empty($patients) ? $patients->email : '',
            'customer_phone_no' => !empty($patients) ? $patients->phone_no : '',
        ];

        /* get product details */
        $lineItems = array();
        $discountPrice = $shippingRates = 0;
        foreach ($order_details as $value) {
            $productId = $value['product_id'];
            $qty = $value['qty'];
            $product = $this->getProductDetails($productId);
            $stripePlan = !empty($product->stripe_plan) ? $product->stripe_plan : '';


            $price = !empty($product->price) ? ($product->price * 100) : 0;
            $discount = !empty($product->discount) ? ($product->discount * 100) : 0;
            $shippingCost = !empty($product->shipping_cost) ? ($product->shipping_cost * 100) : 0;
            $processingFees = !empty($product->processing_fees) ? ($product->processing_fees * 100) : 0;
            $subTotal = $processingFees + $shippingCost;
            $lineItems[] = array(
                'price' => $stripePlan,
                'quantity' => $qty,
            );
            $discountPrice += $discount;
            $shippingRates += $subTotal;
        }

        /* stripe create customer */
        $customer = $this->createCustomer($customerDetails);

        /* stripe create coupon */
        $couponsId = $this->createCoupon($discountPrice);

        /* stripe create shipping rate & processing fees */
        $shippingRateId = $this->createShippingRate(0);

        return $this->createSessionCheckout($customer, $lineItems, $couponsId, $shippingRateId, $patientId,'subscription');
    }

    public function createCustomer($data)
    {
        $customer = $this->stripe->customers->create([
            'name' => $data['customer_name'],
            'phone' => $data['customer_phone_no'],
            'email' => $data['customer_email'],
            'description' => 'Customer',
        ]);
        return $customer->id;
    }

    public function createCoupon($discountPrice)
    {
        if ($discountPrice > 0) {
            $discountId = "discount_" . rand(0, 99999);
            $coupons = $this->stripe->coupons->create([
                'name' => 'Coupon',
                'currency' => 'usd',
                'duration' => 'once',
                'id' => $discountId,
                'amount_off' => $discountPrice,
            ]);
            $couponsId = ['coupon' => $coupons->id];
        } else {
            $couponsId = [];
        }
        return $couponsId;
    }

    public function createShippingRate($shippingRates)
    {
        if ($shippingRates > 0) {
            $shippingRates = $this->stripe->shippingRates->create([
                'display_name' => 'Shipping Rate & Processing Fees',
                'type' => 'fixed_amount',
                'fixed_amount' => [
                    'amount' => $shippingRates,
                    'currency' => 'usd',
                ],
            ]);
            $shippingRateId = ['shipping_rate' => $shippingRates->id];
        } else {
            $shippingRateId = [];
        }

        return $shippingRateId;
    }

    public function createSessionCheckOut($customer, $lineItems, $couponsId, $shippingRateId, $patientId,$mode)
    {
        $session = \Stripe\Checkout\Session::create([
            'customer' => $customer,
            'line_items' => $lineItems,
            'mode' => $mode,
            'discounts' => [$couponsId],
            'shipping_options' => [$shippingRateId],
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}&patients_id=$patientId",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return \redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $stripeRecord = $this->stripe->checkout->sessions->retrieve($sessionId);
        $line_items = $this->stripe->checkout->sessions->allLineItems($sessionId, ['limit' => 20]);
        $stripeRecord['line_items'] = $line_items;
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
        $shippingAndProcessingCost = !empty($stripeRecord->shipping_cost->amount_total) ? $stripeRecord->shipping_cost->amount_total : 0;
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
            $productDetails = !empty($invoiceDetails['lines']['data']) ? $invoiceDetails['lines']['data'] : '';
            $invoicePdf = !empty($invoiceDetails['invoice_pdf']) ? $invoiceDetails['invoice_pdf'] : '';
            $discountDetails = !empty($invoiceDetails['discount']) ? json_encode($invoiceDetails['discount']) : "";
        } else {
            $lineItems = !empty($stripeRecord->line_items->data) ? $stripeRecord->line_items->data : "";
            foreach ($lineItems as $item) {
                $productDetails[] = [
                    'product_name' => !empty($item->description) ? $item->description : '',
                    'qty' => !empty($item->quantity) ? $item->quantity : 0,
                    'currency' => !empty($item->currency) ? $item->currency : '',
                    'discount' => !empty($item->amount_discount) ? $item->amount_discount : 0,
                    'sub_total' => !empty($item->amount_subtotal) ? $item->amount_subtotal : 0,
                    'total_amount' => !empty($item->amount_total) ? $item->amount_total : 0,
                    'unit_amount' => !empty($item->price->unit_amount) ? $item->price->unit_amount : 0,
                ];
            }
        }
        if ($paymentStatus == 'paid' && $status == 'complete') {
            $order = [
                'session_id' => !empty($sessionId) ? $sessionId : '',
                'patients_id' => $patientsId,
                'product_details' => !empty($productDetails) ? json_encode($productDetails) : '',
                'shipping_and_processing_amount' => $shippingAndProcessingCost,
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
                'sending_order_status' => 'NewOrder',
            ];

            $order = Order::create($order);
            Mail::to($customerEmail)->send(new OrderPlaced($order));
            return redirect()->route('home');
        }

    }


}
