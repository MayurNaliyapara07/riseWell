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

    public function getTrackingDetails()
    {
        $orders = Order::where('order_status', '!=', 'Delivered')->where('sending_order_shipment_status','=','Fedex')->get();
        $access_token = $this->getAccessToken();
        $url = "https://apis-sandbox.fedex.com/track/v1/trackingnumbers";
        $header = [
            'Authorization: Bearer ' . $access_token,
            'x-customer-transaction-id' => '624deea6-b709-470c-8c39-4b5511281492',
            'x-locale' => 'en_US',
            'Content-type' => 'application/json'
        ];

        if (count($orders) > 0) {
            foreach ($orders as $order) {
                $fields = '{ "trackingInfo": [
                    {
                        "trackingNumberInfo": {
                        "trackingNumber":' . $order->sending_order_tracking_no . ',
                        }
                    }
                 ],
                  "includeDetailedScans": true
                }';
                $resp = $this->curl_me($url, $header, $fields);
                if (!empty($resp['output'])) {
                    $response = $resp['output'];
                    return $this->updateOrderStatus($response, $order);
                }
            }
        } else {
            echo "Order Not Found!!";
            exit();
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

    public function updateOrderStatus($details, $order)
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

                    $type = $eventType;
                    $date = !empty($value['date']) ? $value['date'] : '-';
                    $derivedStatus = !empty($value['derivedStatus']) ? $value['derivedStatus'] : '';
                    $eventDescription = !empty($value['eventDescription']) ? $value['eventDescription'] : '';

                    $orderStatus = new OrderWiseStatus();
                    $orderStatus->order_id = $order->order_id;
                    $orderStatus->date = $date;
                    $orderStatus->status = $derivedStatus;
                    $orderStatus->description = $eventDescription;
                    $orderStatus->eventType = $type;
                    $orderStatus->save();

                    /* send notification and status update */
                    if ($type == 'DL') {

                        $baseHelper = new BaseHelper();
                        $patientsObj = new Patients();
                        $patientsDetails = $patientsObj->loadModel($order->patients_id);

                        $customerEmail = !empty($order->customer_email) ? $order->customer_email : '';
                        $customerPhoneNo = !empty($patientsDetails->phone_no) ? $patientsDetails->country_code . "" . $patientsDetails->phone_no : '';

                        $smsNotification = $baseHelper->sendSMSNotification($customerEmail, 'Delivered', 'order', '');
                        $mailNotification = $baseHelper->sendMailNotification($customerEmail, 'Delivered', 'order');

                        Order::where('order_id', $order->order_id)->update(['order_status' => 'Delivered']);

                        if ($mailNotification['status'] == true || $mailNotification['status'] == null) {
                            echo 'Email sent to ' . $customerEmail . ' successfully';
                            exit();
                        }
                        else {
                            echo $mailNotification['message'];
                            exit();
                        }

                    }
                }
            }
        }
        echo "Updated Status";
        exit();
    }
}
