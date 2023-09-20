<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Order;

class FedexController extends Controller
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new GeneralSetting();
    }

    public function getAccessToken()
    {
        $url = 'https://apis-sandbox.fedex.com/oauth/token';
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $fields = "grant_type=client_credentials&client_id=l770d9e3f6775b4d80810e0e3bd10bb093&client_secret=b93f0d68421842198d2e463d1d18e4a5";
        $resp = $this->curl_me($url, $headers, $fields);
        $access_token = $resp['access_token'];
        return $access_token;
    }

    public function getTrackingDetails()
    {
        $access_token = $this->getAccessToken();
        $url = "https://apis-sandbox.fedex.com/track/v1/trackingnumbers";
        $header = [
            'Authorization: Bearer ' . $access_token,
            'x-customer-transaction-id' => '624deea6-b709-470c-8c39-4b5511281492',
            'x-locale' => 'en_US',
            'Content-type' => 'application/json'
        ];

        $orders = Order::all();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $fields = '{
                "includeDetailedScans": true,
                "trackingInfo": [
                     {
                            "trackingNumberInfo": {
                            "trackingNumber":' . $order->order_tracking_no . ',
                            "carrierCode": "FDXE"
                         }
                     }
                ]
            }';
                $resp = $this->curl_me($url, $header, $fields);
                if (!empty($resp['output'])) {
                    $response = $resp['output'];
                    $completeTrackResults = $response['completeTrackResults'];
                    $trackResults = !empty($completeTrackResults[0]) ? $completeTrackResults[0]['trackResults'] : '';
                    $scanEvents = !empty($trackResults[0]) ? $trackResults[0]['scanEvents'] : '';
                    return $this->updateOrderStatus($scanEvents);
                }
            }
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

    public function updateOrderStatus($details)
    {
        if (!empty($details)) {
            foreach ($details as $key => $value) {
                if ($value == end($details)) {
                    $eventType = $value['eventType'];
                    if ($eventType == 'DL') {
                        $status = $value['eventDescription'];
                    }
                    Order::where('order_tracking_no', '=', '652332352058')->update(['order_status' => $status]);
                }
            }
        }
        echo "Updated Status";
        exit();
    }
}
