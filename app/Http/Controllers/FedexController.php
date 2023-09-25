<?php

namespace App\Http\Controllers;

use App\Helpers\BaseHelper;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderWiseStatus;
use App\Models\Patients;
use Illuminate\Support\Facades\Request;

class FedexController extends Controller
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new GeneralSetting();
    }

    public function getAccessToken()
    {
        try {
            $url = 'https://apis-sandbox.fedex.com/oauth/token';
            $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
            $fields = "grant_type=client_credentials&client_id=l770d9e3f6775b4d80810e0e3bd10bb093&client_secret=b93f0d68421842198d2e463d1d18e4a5";
            $resp = $this->curl_me($url, $headers, $fields);
            if (!empty($resp['errors'])) {
                echo $resp['errors'][0]['message'];
                exit();
            } else {
                return $resp['access_token'];
            }
        } catch (\Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine() . ' called from ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'];
        }

    }


    public function getSendingOrderTrackingDetails()
    {
        $type = 'SendingOrder';
        $orders = Order::select('order_id', 'sending_order_tracking_no as tracking_no','patients_id')->whereNotNull('sending_order_tracking_no')->where('sending_order_status', '!=', 'Delivered')->where('sending_order_shipment_status', '=', 'Fedex')->get();
        if (count($orders) > 0){
            foreach ($orders as $order) {
                $this->CallApi($order, $type);
            }
        }
        else{
            echo "SendingOrder Not Found !!";
        }

    }

    public function getReceivingOrderTrackingDetails()
    {
        $type = 'ReceivingOrder';
        $orders = Order::select('order_id', 'receiving_order_tracking_no as tracking_no', 'receiving_order_status','patients_id')->whereNotNull('receiving_order_tracking_no')->where('receiving_order_status', '!=', 'Delivered')->where('receiving_order_shipment_status', '=', 'Fedex')->get();

        if (count($orders) > 0){
            foreach ($orders as $order) {
                $this->CallApi($order, $type);
            }
        }
        else{
            echo "ReceivingOrder Not Found !!";
        }
    }

    public function getSendingLabTrackingDetails()
    {
        $type = 'SendingLab';
        $orders = Order::select('order_id', 'sending_lab_tracking_no as tracking_no', 'sending_lab_status','patients_id')->whereNotNull('sending_lab_tracking_no')->where('sending_lab_status', '!=', 'Delivered')->where('sending_lab_shipment_status', '=', 'Fedex')->get();
        if (count($orders) > 0){
            foreach ($orders as $order) {
                $this->CallApi($order, $type);
            }
        }
        else{
            echo "SendingLab Not Found !!";
        }
    }

    public function getReceivingLabTrackingDetails()
    {
        $type = 'ReceivingLab';
        $orders = Order::select('order_id', 'receiving_lab_tracking_no as tracking_no', 'receiving_lab_status')->whereNotNull('receiving_lab_tracking_no')->where('receiving_lab_status', '!=', 'Delivered')->where('receiving_lab_shipment_status', '=', 'Fedex')->get();
        if (count($orders) > 0){
            foreach ($orders as $order) {
                $this->CallApi($order, $type);
            }
        }
        else{
            echo "ReceivingLab Not Found !!";
        }
    }

    public function CallApi($order, $type)
    {
        $access_token = $this->getAccessToken();
        $url = "https://apis-sandbox.fedex.com/track/v1/trackingnumbers";
        $header = [
            'Authorization: Bearer ' . $access_token,
            'x-customer-transaction-id' => '624deea6-b709-470c-8c39-4b5511281492',
            'x-locale' => 'en_US',
            'Content-type' => 'application/json'
        ];

        $fields = '{ "trackingInfo": [
                    {
                        "trackingNumberInfo": {
                        "trackingNumber":' . $order->tracking_no . ',
                        }
                    }
                 ],
                  "includeDetailedScans": true
         }';


        $resp = $this->curl_me($url, $header, $fields);
        if (!empty($resp['output'])) {
            $response = $resp['output'];
            return $this->updateOrderStatus($response, $order, $type);
        }


    }

    function curl_me($url, $headers, $fields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $response = curl_exec($ch);
        $json = json_decode($response, true);
        curl_close($ch);
        return $json;

    }

    public function updateOrderStatus($details, $order, $type)
    {
        $completeTrackResults = $details['completeTrackResults'];
        $trackResults = !empty($completeTrackResults[0]) ? $completeTrackResults[0]['trackResults'] : '';

        $scanEvents = !empty($trackResults[0]) ? $trackResults[0]['scanEvents'] : '';
        $scanEvents[50]['eventType'] = 'DL';
        $scanEvents[50]['eventDescription'] = 'Package delivered to recipient address ';
        $scanEvents[50]['date'] = now();
        $scanEvents[50]['derivedStatus'] = 'Delivered';


        if (!empty($scanEvents)) {
            foreach ($scanEvents as $key => $value) {
                $eventType = !empty($value['eventType']) ? $value['eventType'] : '';
                if (in_array($eventType, ['OC', 'AO', 'AR', 'DL'])) {
                    $date = !empty($value['date']) ? $value['date'] : '-';
                    $derivedStatus = !empty($value['derivedStatus']) ? $value['derivedStatus'] : '';
                    $eventDescription = !empty($value['eventDescription']) ? $value['eventDescription'] : '';
                    $orderStatus = new OrderWiseStatus();
                    $orderStatus->order_id = $order->order_id;
                    $orderStatus->date = $date;
                    $orderStatus->status = $derivedStatus;
                    $orderStatus->description = $eventDescription;
                    $orderStatus->eventType = $eventType;
                    $orderStatus->save();

                    /* send notification and status update */
                    if ($eventType == 'DL') {
                        $baseHelper = new BaseHelper();
                        $patientsObj = new Patients();
                        $patientsDetails = $patientsObj->loadModel($order->patients_id);

                        $customerEmail = !empty($order->customer_email) ? $order->customer_email : '';
                        $customerPhoneNo = !empty($patientsDetails->phone_no) ? $patientsDetails->country_code . "" . $patientsDetails->phone_no : '';


                        if ($type == 'SendingOrder') {
                            $smsNotification = $baseHelper->sendSMSNotification($customerPhoneNo, 'Delivered', 'order', '');
                            $mailNotification = $baseHelper->sendMailNotification($customerEmail, 'Delivered', 'order');
                            Order::where('order_id', $order->order_id)->update(['sending_order_status' => 'Delivered']);
                        } elseif ($type == 'ReceivingOrder') {
                            $smsNotification = $baseHelper->sendSMSNotification($customerPhoneNo, 'Delivered', 'order', '');
                            $mailNotification = $baseHelper->sendMailNotification($customerEmail, 'Delivered', 'order');
                            Order::where('order_id', $order->order_id)->update(['receiving_order_status' => 'Delivered']);
                        } elseif ($type == 'SendingLab') {
                            $smsNotification = $baseHelper->sendSMSNotification($customerPhoneNo, 'Delivered', 'lab', '');
                            $mailNotification = $baseHelper->sendMailNotification($customerEmail, 'Delivered', 'lab');
                            Order::where('order_id', $order->order_id)->update(['sending_lab_status' => 'Delivered']);
                        } elseif ($type == 'ReceivingLab') {
                            $smsNotification = $baseHelper->sendSMSNotification($customerPhoneNo, 'Delivered', 'lab', '');
                            $mailNotification = $baseHelper->sendMailNotification($customerEmail, 'Delivered', 'lab');
                            Order::where('order_id', $order->order_id)->update(['receiving_lab_status' => 'Delivered']);
                        }

                    }
                }
            }
        }
        echo $order->order_id . "Updated Status".'</br>';
    }
}
