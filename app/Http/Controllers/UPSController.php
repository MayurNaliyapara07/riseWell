<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Storage;
use URL;

class UPSController extends Controller
{
    /***** ***** ***** UPS Rates ***** ***** *****
     * $requestOption = Rate, Shop
     * Service Codes:
     *      01 = Next Day Air
     *      02 = 2nd Day Air
     *      03 = Ground
     *      12 = 3 Day Select
     *      13 = Next Day Air Saver
     *      14 = UPS Next Day Air Early
     *      59 = 2nd Day Air A.M.
     * Packaging Type:
     *      00 = UNKNOWN
     *      01 = UPS Letter
     *      02 = Package
     *      03 = Tube
     *      04 = Pak
     *      21 = Express Box
     *      24 = 25KG Box
     *      25 = 10KG Box
     *      30 = Pallet
     *      2a = Small Express Box
     *      2b = Medium Express Box
     *      2c = Large Express Box.
     ***** ***** ***** ***** ***** ***** *****/
    public function UPSRates($requestOption = "Shop", $userAddress, $sellerAddress, $weight = 1)
    {

        $url = config('constants.ups.ups_url') . '/rest/Rate';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "UPSSecurity":{
                    "UsernameToken":{
                        "Username":"' . config('constants.ups.user_name') . '",
                        "Password":"' . config('constants.ups.password') . '"
                    },
                    "ServiceAccessToken":{
                        "AccessLicenseNumber":"' . config('constants.ups.access_license_number') . '"
                    }
                },
                "RateRequest":{
                    "Request":{
                        "RequestOption":"' . $requestOption . '"
                    },
                    "Shipment":{
                        "ShipmentRatingOptions":{
                            "UserLevelDiscountIndicator":"TRUE"
                        },
                        "Shipper":{
                            "Name":"Billy Blanks",
                            "ShipperNumber":"",
                            "Address":{
                            "AddressLine":"' . $sellerAddress->physical_address . '",
                            "City":"' . $sellerAddress->physical_city . '",
                            "StateProvinceCode":"' . $sellerAddress->physical_state . '",
                            "PostalCode":"' . $sellerAddress->physical_zip_code . '",
                            "CountryCode":"US"
                            }
                        },
                        "ShipTo":{
                            "Name":"Sarita Lynn",
                            "Address":{
                            "AddressLine":"' . $sellerAddress->physical_address . '",
                            "City":"' . $sellerAddress->physical_city . '",
                            "StateProvinceCode":"' . $sellerAddress->physical_state . '",
                            "PostalCode":"' . $sellerAddress->physical_zip_code . '",
                            "CountryCode":"US"
                            }
                        },
                        "ShipFrom":{
                            "Name":"Billy Blanks",
                            "Address":{
                            "AddressLine":"' . $sellerAddress->physical_address . '",
                            "City":"' . $sellerAddress->physical_city . '",
                            "StateProvinceCode":"' . $sellerAddress->physical_state . '",
                            "PostalCode":"' . $sellerAddress->physical_zip_code . '",
                            "CountryCode":"US"
                            }
                        },
                        "Service":{
                            "Code":"03",
                            "Description":"Ground"
                        },
                        "ShipmentTotalWeight":{
                            "UnitOfMeasurement":{
                            "Code":"LBS",
                            "Description":"Pounds"
                            },
                            "Weight":"' . $weight . '"
                        },
                        "Package":{
                            "PackagingType":{
                            "Code":"02",
                            "Description":"Package"
                            },
                            "PackageWeight":{
                            "UnitOfMeasurement":{
                                "Code":"LBS"
                            },
                            "Weight":"' . $weight . '"
                            }
                        }
                    }
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    public function getTrackingInfo($trackingID)
    {

        $url = config('constants.ups.ups_url') . '/track/v1/details/' . $trackingID . '?local=en_US';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Username: ' . config('constants.ups.user_name'),
                'Password: ' . config('constants.ups.password'),
                'AccessLicenseNumber: ' . config('constants.ups.access_license_number')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function getTrackingInfoXML($trackingID)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('constants.ups.ups_url') . '/webservices/Track',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:v1="http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0"
            xmlns:v3="http://www.ups.com/XMLSchema/XOLTWS/Track/v2.0"
            xmlns:v11="http://www.ups.com/XMLSchema/XOLTWS/Common/v1.0">
            <soapenv:Header>
            <v1:UPSSecurity>
            <v1:UsernameToken>
            <v1:Username>' . config('constants.ups.user_name') . '</v1:Username>
            <v1:Password>' . config('constants.ups.password') . '</v1:Password>
            </v1:UsernameToken>
            <v1:ServiceAccessToken>
            <v1:AccessLicenseNumber>' . config('constants.ups.access_license_number') . '</v1:AccessLicenseNumber>
            </v1:ServiceAccessToken>
            </v1:UPSSecurity>
            </soapenv:Header>
            <soapenv:Body>
            <v3:TrackRequest>
            <v11:Request>
            <v11:RequestOption>0</v11:RequestOption>
            <v11:TransactionReference>
            <v11:CustomerContext>No Description</v11:CustomerContext>
            </v11:TransactionReference>
            </v11:Request>
            <v3:InquiryNumber>' . $trackingID . '</v3:InquiryNumber>
            </v3:TrackRequest>
            </soapenv:Body>
            </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    // FUNCTION TO MUNG THE XML SO WE DO NOT HAVE TO DEAL WITH NAMESPACE
    function mungXML($xml)
    {
        $obj = SimpleXML_Load_String($xml);
        if ($obj === FALSE) return $xml;

        // GET NAMESPACES, IF ANY
        $nss = $obj->getNamespaces(TRUE);
        if (empty($nss)) return $xml;

        // CHANGE ns: INTO ns_
        $nsm = array_keys($nss);
        foreach ($nsm as $key) {
            // A REGULAR EXPRESSION TO MUNG THE XML
            $rgx
                = '#'               // REGEX DELIMITER
                . '('               // GROUP PATTERN 1
                . '\<'              // LOCATE A LEFT WICKET
                . '/?'              // MAYBE FOLLOWED BY A SLASH
                . preg_quote($key)  // THE NAMESPACE
                . ')'               // END GROUP PATTERN
                . '('               // GROUP PATTERN 2
                . ':{1}'            // A COLON (EXACTLY ONE)
                . ')'               // END GROUP PATTERN
                . '#'               // REGEX DELIMITER
            ;
            // INSERT THE UNDERSCORE INTO THE TAG NAME
            $rep
                = '$1'          // BACKREFERENCE TO GROUP 1
                . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
            ;
            // PERFORM THE REPLACEMENT
            $xml = preg_replace($rgx, $rep, $xml);
        }

        return $xml;

    } // End :: mungXML()

    public function SendOrderStatusEmail($status, $orderItem)
    {
        $orderQuery = "SELECT o.order_number, u.* FROM `orders` as o inner join users as u on u.id = o.buyer_id where o.id = " . $orderItem->order_id;
        $orderResult = DB::select(DB::raw($orderQuery));
        $orderResult = $orderResult[0];
        $buyer = $orderResult;


        $sellerQuery = "SELECT * from users where id = " . $orderItem->seller_id;
        $sellerResult = DB::select(DB::raw($sellerQuery));
        $sellerResult = $sellerResult[0];
        $seller = $sellerResult;


        switch ($status) {
            case "Confirmed":
                /////////////// Email to Buyer ////////////////
                $message = "Your order Number:" . $buyer->order_number . " has been confirmed.";
                $subject = "Order is confirmed";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($buyer->email, $buyer->last_name, $message, $subject);
                $response = ['toBuyer' => $emailResponse];
                /////////////// Email to Seller ////////////////
                $message = "Your have successfully confirmed the Order Number:" . $buyer->order_number;
                $subject = "Order is confirmed";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($seller->email, $seller->last_name, $message, $subject);
                $response = ['toSeller' => $emailResponse];
                break;
            case "Cancelled":
                $message = "For some reason your order Number:" . $buyer->order_number . " is cancelled.";
                $subject = "Order is cancelled";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($buyer->email, $buyer->last_name, $message, $subject);
                $response = ['toBuyer' => $emailResponse];
                /////////////// Email to Seller ////////////////
                $message = "You have cancelled order Number:" . $buyer->order_number;
                $subject = "Order is cancelled";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($seller->email, $seller->last_name, $message, $subject);
                $response = ['toSeller' => $emailResponse];
                break;
            case "Shipped":
                $message = "Your order Number:" . $buyer->order_number . " is shipped.";
                $subject = "Order is shipped";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($buyer->email, $buyer->last_name, $message, $subject);
                $response = ['toBuyer' => $emailResponse];
                /////////////// Email to Seller ////////////////
                $message = "You have successfully shipped order Number:" . $buyer->order_number;
                $subject = "Order is shipped";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($seller->email, $seller->last_name, $message, $subject);
                $response = ['toSeller' => $emailResponse];
                break;
            case "Delivered":
                $message = "Your order Number:" . $buyer->order_number . " is delivered.";
                $subject = "Order is delivered";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($buyer->email, $buyer->last_name, $message, $subject);
                $response = ['toBuyer' => $emailResponse];
                /////////////// Email to Seller ////////////////
                $message = "You have successfully received order Number:" . $buyer->order_number;
                $subject = "Order is delivered";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($seller->email, $seller->last_name, $message, $subject);
                $response = ['toSeller' => $emailResponse];
                break;
            case "NoPayment":
                $message = "Your order Number:" . $buyer->order_number . " is is not confirmed due to payment failed.";
                $subject = "Order is confirmation failed";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($buyer->email, $buyer->last_name, $message, $subject);
                $response = ['toBuyer' => $emailResponse];
                /////////////// Email to Seller ////////////////
                $message = "Your order Number:" . $buyer->order_number . " is is not confirmed due to payment failed.";
                $subject = "Order is confirmation failed";
                $emailResponse = app('App\Http\Controllers\OrdersController')->SendMail($seller->email, $seller->last_name, $message, $subject);
                $response = ['toSeller' => $emailResponse];
                break;

        }

        return $response;
    }

    public function rates(Request $request)
    {
        $data = $request->all();
        $data = (array)$data;

        $products = DB::table('cart_items as ci')
            ->join('products as pd', 'pd.id', '=', 'ci.product_id')
            ->select('pd.*', 'ci.item_price as cart_item_price', 'ci.quantity as cart_quantity', 'ci.id as cart_id')
            ->where('ci.user_id', $data['user_id'])
            ->get();

        $userAddressQuery = "SELECT physical_address, physical_city, TRIM(physical_state) as physical_state, physical_zip_code FROM `pharmacy_addresses` where user_id = " . $data['user_id'];
        $result = DB::select(DB::raw($userAddressQuery));

        if (isset($result) && !empty($result[0])) {
            $userAddress = $result[0];

            $shipping = array();
            foreach ($products as $seller) {
                $sellerAddressQuery = "SELECT ci.*, p.name, pa.physical_address, pa.physical_city, IFNULL(gs.abv, TRIM(pa.physical_state)) as physical_state,
                    pa.physical_zip_code, (p.weight * ci.quantity) as weight
                    FROM `cart_items` AS ci
                    INNER JOIN products AS p ON p.id = ci.product_id
                    INNER JOIN pharmacy_addresses AS pa ON pa.user_id = p.user_id
                    LEFT JOIN geo_states AS gs ON gs.name = TRIM(pa.physical_state)
                    where ci.product_id = " . $seller->id;

                $sellerAddress = DB::select(DB::raw($sellerAddressQuery));
                $sellerAddress = $sellerAddress[0];

                $upsRateData = json_decode($this->UPSRates("Shop", $userAddress, $sellerAddress, $sellerAddress->weight));
                array_push($shipping, $upsRateData);
            }
        }

        return response()->json(["shipping" => $shipping]);
    }

    /***** ***** ***** ***** ***** ***** *****
     * Tracking Status
     * D Delivered
     * I In Transit
     * M Billing Information Received
     * MV Billing Information Voided
     * P Pickup
     * X Exception
     * RS Returned to Shipper
     * DO Delivered Origin CFS (Freight Only)
     * DD Delivered Destination CFS (Freight Only)
     * W Warehousing (Freight Only)
     * NA Not Available
     * O Out for Delivery
     ***** ***** ***** ***** ***** ***** *****/
    public function track(Request $request)
    {
        if (isset($request->id) && isset($request->tracking_id) && isset($request->user_id)) {
            $itemID = $request->id;
            $userID = $request->user_id;
            $trackingID = $request->tracking_id;

            $deliveryDate = null;
            $status = 'Confirmed';

            try {
                $method = "xml";
                $trackingInfo = $this->getTrackingInfoXML($trackingID);

                /***** XML Method *****/
                $plainXML = $this->mungXML(trim($trackingInfo));
                $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
                /*
                foreach($arrayResult['soapenv_Body']['trk_TrackResponse']['trk_Shipment'] as $key => $trackData){
                    print_r($key);
                    echo '<br><br>';
                }
                dd($arrayResult);
                */
                /***** XML Method ****/
                //dd($arrayResult['soapenv_Body']['soapenv_Fault']['detail']['err_Errors']['err_ErrorDetail']['err_PrimaryErrorCode']['err_Description']);


                if ($method == 'xml') {
                    $trackingInfo = $arrayResult;

                    if (isset($trackingInfo['soapenv_Body']['soapenv_Fault']['detail']['err_Errors']['err_ErrorDetail']['err_PrimaryErrorCode']['err_Description'])) {
                        return response()->json(array(
                            'code' => 404,
                            'message' => $trackingInfo['soapenv_Body']['soapenv_Fault']['detail']['err_Errors']['err_ErrorDetail']['err_PrimaryErrorCode']['err_Description']
                        ), 404);
                    }


                    $status = 'Confirmed'; //Pending, Confirmed, Cancelled, Shipped, Delivered
                    $shippingDate = null;
                    $deliveryDate = null;


                    if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_PickupDate'])) {
                        $status = 'Shipped';
                        $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_PickupDate'];
                        $shippingDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' 00:00:00';
                    }

                    if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'])) {
                        if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'] == 'DELIVERED' ||
                            $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Type'] == 'D'
                        ) {
                            $status = 'Delivered';
                            $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Date'];
                            $tmpTime = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Time'];
                            $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                            $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                        }

                        if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'] == 'ORIGIN SCAN') {
                        }
                    }

                    if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Description'])) {
                        if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Description'] == 'DELIVERED' ||
                            $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Type'] == 'D'
                        ) {
                            $status = 'Delivered';
                            $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Date'];
                            $tmpTime = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Time'];
                            $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                            $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                        }
                    }

                    if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity'])) {
                        foreach ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity'] as $pkg) {
                            if (isset($pkg['trk_Status']['trk_Description'])) {
                                if ($pkg['trk_Status']['trk_Description'] == 'DELIVERED') {
                                    $status = 'Delivered';
                                    $tmpDate = $pkg['trk_Date'];
                                    $tmpTime = $pkg['trk_Time'];
                                    $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                                    $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                                }
                            }

                            if (isset($pkg['trk_Status']['trk_Type'])) {
                                if ($pkg['trk_Status']['trk_Type'] == 'D') {
                                    $status = 'Delivered';
                                    $tmpDate = $pkg['trk_Date'];
                                    $tmpTime = $pkg['trk_Time'];
                                    $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                                    $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                                }
                            }
                        }
                    }


                    $t1Query = "SELECT * FROM `order_items` where id = " . $itemID;
                    $t1Result = DB::select(DB::raw($t1Query));
                    $t1Result = $t1Result[0];
                    if ($status == 'Shipped') {
                        $this->SendOrderStatusEmail($status, $t1Result);
                    } else if ($status == 'Delivered') {
                        $this->SendOrderStatusEmail($status, $t1Result);
                    }


                    $query = "update `order_items` set status = '$status', shipping_date = '$shippingDate', delivery_date = '$deliveryDate' where id = " . $itemID;
                    DB::statement($query);
                    $data['status'] = $status;
                    $data['shipping'] = $shippingDate;
                    $data['delivered'] = $deliveryDate;
                    $data['track'] = $itemID;
                    return response()->json(["shipping" => $data]);

                    /*
                    if(isset($trackingInfo['soapenv_Body']['trk_TrackResponse'])){

                        if(isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'])){
                            $trackingInfo = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'];
                            $data['date'] = null;

                            if(isset($trackingInfo['trk_Activity']['trk_Date'])){
                                $data['date'] = $trackingInfo['trk_Activity']['trk_Date'];
                            }

                            $data['time'] = null;
                            if(isset($trackingInfo['trk_Activity']['trk_Time'])){
                                $data['time'] = $trackingInfo['trk_Activity']['trk_Time'];
                            }

                            $data['status'] = '';
                            if(isset($trackingInfo['trk_Activity']['trk_Status'])){
                                $data['status'] = $trackingInfo['trk_Activity']['trk_Status']['trk_Description'];
                            }

                            $data['type'] = '';
                            if(isset($trackingInfo['trk_Activity']['trk_Status'])){
                                $data['type'] = $trackingInfo['trk_Activity']['trk_Status']['trk_Type'];
                            }

                            $data['type'] = strtolower(trim($data['type']));

                            if($data['type'] == 'i'){ $status = 'Shipped'; } else
                            if($data['type'] == 'd'){
                                $status = 'Delivered';
                                $deliveryDate = substr($data['date'],0,4) . '-' . substr($data['date'],4,2) . '-' . substr($data['date'],6,4);
                            }

                            $query = "update `order_items` set tracking_id = '$trackingID', status = '$status', delivery_date = '$deliveryDate' where id = $itemID";
                            DB::statement($query);
                            return response()->json(["shipping" => $data]);
                        }
                    }
                    */
                } else {
                    $trackingInfo = json_decode($trackingInfo);
                    if (isset($trackingInfo->trackResponse)) {
                        $data['date'] = $trackingInfo->trackResponse->shipment[0]->package[0]->activity[0]->date;
                        $data['time'] = $trackingInfo->trackResponse->shipment[0]->package[0]->activity[0]->time;
                        $data['status'] = $trackingInfo->trackResponse->shipment[0]->package[0]->activity[0]->status->description;
                        $data['type'] = $trackingInfo->trackResponse->shipment[0]->package[0]->activity[0]->status->type;

                        $data['type'] = strtolower(trim($data['type']));

                        if ($data['type'] == 'i') {
                            $status = 'Shipped';
                        } else
                            if ($data['type'] == 'd') {
                                $status = 'Delivered';
                                $deliveryDate = substr($data['date'], 0, 4) . '-' . substr($data['date'], 4, 2) . '-' . substr($data['date'], 6, 4);
                            }

                        $query = "update `order_items` set tracking_id = '$trackingID', status = '$status', delivery_date = '$deliveryDate' where id = $itemID";
                        DB::statement($query);
                        return response()->json(["shipping" => $data]);
                    }
                }
            } catch (Exception $e) {
                $query = "update `order_items` set tracking_id = '$trackingID' where id = $itemID";
                DB::statement($query);
                return response()->json(["shipping" => $trackingID]);
            }

            $query = "update `order_items` set tracking_id = '$trackingID' where id = $itemID";
            DB::statement($query);
            return response()->json(["shipping" => $trackingID]);
        }

        return response()->json(array(
            'code' => 404,
            'message' => 'All fields required'
        ), 404);
    }

    public function trackAll(Request $request)
    {
        $query = "SELECT * FROM `order_items` where tracking_id != '' and status != 'Delivered'";
        $result = DB::select(DB::raw($query));


        foreach ($result as $item) {
            $deliveryDate = null;
            $status = 'Confirmed';


            $trackingInfo = $this->getTrackingInfoXML($item->tracking_id);

            /***** XML Method *****/
            $plainXML = $this->mungXML(trim($trackingInfo));
            $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            /***** XML Method ****/


            $trackingInfo = $arrayResult;
            /*
            foreach($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity'] as $pkg){
                dd($pkg['trk_Status']['trk_Type']);
                //['trk_Activity']['trk_Status']['trk_Type']
            }
            dd($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']);
            */
            //dd($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']);
            $trackingInfoJson = json_encode($arrayResult);
            echo '<br><br>Tracking: ' . $item->tracking_id;
            echo '<br>';
            echo $trackingInfoJson;

            if (isset($trackingInfo['soapenv_Body']['soapenv_Fault']['detail']['err_Errors']['err_ErrorDetail']['err_PrimaryErrorCode']['err_Description'])) {
                echo '<br>';
                echo $item->tracking_id . ' : ' . $trackingInfo['soapenv_Body']['soapenv_Fault']['detail']['err_Errors']['err_ErrorDetail']['err_PrimaryErrorCode']['err_Description'];
            } else {
                $status = 'Confirmed'; //Pending, Confirmed, Cancelled, Shipped, Delivered
                $shippingDate = null;
                $deliveryDate = null;


                if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_PickupDate'])) {
                    $status = 'Shipped';
                    $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_PickupDate'];
                    $shippingDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' 00:00:00';
                }

                if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'])) {
                    if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'] == 'DELIVERED' ||
                        $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Type'] == 'D'
                    ) {
                        $status = 'Delivered';
                        $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Date'];
                        $tmpTime = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Time'];
                        $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                        $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                    }

                    if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity']['trk_Status']['trk_Description'] == 'ORIGIN SCAN') {
                    }
                }

                if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Description'])) {
                    if ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Description'] == 'DELIVERED' ||
                        $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Status']['trk_Type'] == 'D'
                    ) {
                        $status = 'Delivered';
                        $tmpDate = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Date'];
                        $tmpTime = $trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package'][0]['trk_Activity']['trk_Time'];
                        $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                        $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                    }
                }

                if (isset($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity'])) {
                    foreach ($trackingInfo['soapenv_Body']['trk_TrackResponse']['trk_Shipment']['trk_Package']['trk_Activity'] as $pkg) {
                        if (isset($pkg['trk_Status']['trk_Description'])) {
                            if ($pkg['trk_Status']['trk_Description'] == 'DELIVERED') {
                                $status = 'Delivered';
                                $tmpDate = $pkg['trk_Date'];
                                $tmpTime = $pkg['trk_Time'];
                                $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                                $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                            }
                        }

                        if (isset($pkg['trk_Status']['trk_Type'])) {
                            if ($pkg['trk_Status']['trk_Type'] == 'D') {
                                $status = 'Delivered';
                                $tmpDate = $pkg['trk_Date'];
                                $tmpTime = $pkg['trk_Time'];
                                $deliveryDate = substr($tmpDate, 0, 4) . '-' . substr($tmpDate, 4, 2) . '-' . substr($tmpDate, 6, 4) . ' ';
                                $deliveryDate .= substr($tmpTime, 0, 2) . ':' . substr($tmpTime, 2, 2) . ':' . substr($tmpTime, 4, 4);
                            }
                        }
                    }
                }


                $t1Query = "SELECT * FROM `order_items` where id = " . $item->id;
                $t1Result = DB::select(DB::raw($t1Query));
                $t1Result = $t1Result[0];
                if ($status == 'Shipped') {
                    $this->SendOrderStatusEmail($status, $item->id);
                } else if ($status == 'Delivered') {
                    $this->SendOrderStatusEmail($status, $item->id);
                }

                $query = "update `order_items` set status = '$status', shipping_date = '$shippingDate', delivery_date = '$deliveryDate' where id = " . $item->id;
                DB::statement($query);

                echo '<br>';
                echo $item->tracking_id . ' : ' . $status . ' >> ' . $deliveryDate;
            }
        }
    }

    public function shipment(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wwwcie.ups.com/ups.app/xml/ShipConfirm',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<?xml version="1.0"?>
        <AccessRequest xml:lang="en-US">
            <AccessLicenseNumber>' . config('constants.ups.access_license_number') . '</AccessLicenseNumber>
            <UserId>' . config('constants.ups.user_name') . '</UserId>
            <Password>' . config('constants.ups.password') . '</Password>
        </AccessRequest>
        <?xml version="1.0"?>
        <ShipmentConfirmRequest xml:lang="en-US">
            <Request>
                <TransactionReference>
                    <CustomerContext>Your Customer Context</CustomerContext>
                </TransactionReference>
                <RequestAction>ShipConfirm</RequestAction>
                <RequestOption>validate</RequestOption>
            </Request>
            <Shipment>
                <Shipper>
                    <Name>Plego Technologies</Name>
                    <AttentionName>Saad Yusuf</AttentionName>
                    <CompanyDisplayableName>Plego</CompanyDisplayableName>
                    <PhoneNumber>1234567890</PhoneNumber>
                    <ShipperNumber>B3A724</ShipperNumber>
                    <TaxIdentificationNumber>1234567877</TaxIdentificationNumber>
                    <Address>
                        <AddressLine1>4949 Forest Ave, First FL</AddressLine1>
                        <City>Downers Grove</City>
                        <StateProvinceCode>IL</StateProvinceCode>
                        <PostalCode>60515</PostalCode>
                        <CountryCode>US</CountryCode>
                    </Address>
                </Shipper>
                <ShipTo>
                    <CompanyName>CompanyName</CompanyName>
                    <AttentionName>Ship To Attn Name</AttentionName>
                    <PhoneNumber>1234567890</PhoneNumber>
                    <Address>
                        <AddressLine1>11221 Katy Freeway, Ste. 201</AddressLine1>
                        <City>Houston</City>
                        <StateProvinceCode>TX</StateProvinceCode>
                        <PostalCode>77079</PostalCode>
                        <CountryCode>US</CountryCode>
                    </Address>
                </ShipTo>
                <ShipFrom>
                    <CompanyName>Plego Technologies</CompanyName>
                    <AttentionName>Ship From Attn Name</AttentionName>
                    <PhoneNumber>1234567890</PhoneNumber>
                    <Address>
                        <AddressLine1>4949 Forest Ave, First FL</AddressLine1>
                        <City>Downers Grove</City>
                        <StateProvinceCode>IL</StateProvinceCode>
                        <PostalCode>60515</PostalCode>
                        <CountryCode>US</CountryCode>
                    </Address>
                </ShipFrom>
                <PaymentInformation>
                    <Prepaid>
                        <BillShipper>
                            <AccountNumber>B3A724</AccountNumber>
                        </BillShipper>
                    </Prepaid>
                </PaymentInformation>
                <Service>
                    <Code>12</Code>
                    <Description>3 Day Select</Description>
                </Service>
                <Package>
                    <PackagingType>
                        <Code>02</Code>
                        <Description>Package</Description>
                    </PackagingType>
                    <Dimensions>
                        <UnitOfMeasurement>
                            <Code>IN</Code>
                            <Description>Inches</Description>
                        </UnitOfMeasurement>
                        <Length>5</Length>
                        <Width>4</Width>
                        <Height>2</Height>
                    </Dimensions>
                    <PackageWeight>
                        <UnitOfMeasurement>
                            <Code>LBS</Code>
                            <Description>Pounds</Description>
                        </UnitOfMeasurement>
                        <Weight>1</Weight>
                    </PackageWeight>
                </Package>
            </Shipment>
            <LabelSpecification>
                <LabelPrintMethod>
                    <Code>GIF</Code>
                    <Description>GIF</Description>
                </LabelPrintMethod>
                <LabelImageFormat>
                    <Code>GIF</Code>
                    <Description>GIF</Description>
                </LabelImageFormat>
            </LabelSpecification>
        </ShipmentConfirmRequest>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Cookie: ak_bmsc=8008F99B4D316960D8C592B21BE5E5FE~000000000000000000000000000000~YAAQrw4VAkALYIuGAQAA1yrctxNO+E6uI+rAQWHEJexxxIeSqQXZwRPBZ4o5P6oIryv3wynDRTb+9ZnK5ioqoJqNX9WzbgQ8BBfORnsH94y6KGdFaCRKJXaDHWYyHmRPq7C3DOCOElgaeq0dJFd0pU79zVPDJpSZ/nzrcJzTL4xJWyjTkLKwMPEW6XxtB2BIdKupbFvrQ1DuMhI7Hgu7p1tgsJndAeCPMZpMl0AXrVM5oYfr1MLe/JqcIERxP7jlEsc5qRvf515n/xN3fx0yRupNO9Wkpr85wAipewAQCn+gGzkdMB4rHklfr4IgT2Nf3T1UiF36CHqsIUeqP4hiYAhZ7XgFs8r5AqA0jKwcV6LFkwFzCt1J4aJ1hw==; bm_sv=06A9CC770460C29DDC300A5E32356628~YAAQrw4VAnwvYouGAQAAQWI5uBOK5vDqithGPd8kT0DRfBsGK/I0nhucmi4ower/wvcuFNFdqdNithUHHkTFxdrX/tvjux18fDDNeR//e/i2CsvTXVJM0DW4gxnPisRw5Alnrd0ZXbF87+2jmIRYNty9vx1K/ur6AW929vnJDvsBTi7lpcWPJjr0XpqqI1GMvw9yCdAwFtGerU7i3WoArIxnaa2XeggF/kHHs6ISu8zYMGTuHamHObJG2PHgyw==~1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        $plainXML = $this->mungXML(trim($response));
        $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        $strUnique = sprintf('%u', ip2long($_SERVER['REMOTE_ADDR'])) . floor(microtime(true) * 1000);

        /*
        $file=fopen(public_path() . "/shipment/" . $strUnique . ".gif","w");
        fwrite($file,base64_decode($arrayResult['ShipmentDigest']));
        */
        $image = base64_decode($arrayResult['ShipmentDigest']);
        $response = Response::make($image, 200);
        $response->header('content-type', 'image/gif');

        return $response;
    }

    public function label(Request $request)
    {
        $trackingID = '1Z12345E8791315413';

        if (isset($request->track)) {
            $trackingID = $request->track;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wwwcie.ups.com/webservices/LBRecovery',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:v1="http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0"
        xmlns:v11="http://www.ups.com/XMLSchema/XOLTWS/LBRecovery/v1.0"
        xmlns:v12="http://www.ups.com/XMLSchema/XOLTWS/Common/v1.0">
            <soapenv:Header>
                <v1:UPSSecurity>
                    <v1:UsernameToken>
                        <v1:Username>' . config('constants.ups.user_name') . '</v1:Username>
                        <v1:Password>' . config('constants.ups.password') . '</v1:Password>
                    </v1:UsernameToken>
                    <v1:ServiceAccessToken>
                        <v1:AccessLicenseNumber>' . config('constants.ups.access_license_number') . '</v1:AccessLicenseNumber>
                    </v1:ServiceAccessToken>
                </v1:UPSSecurity>
            </soapenv:Header>
            <soapenv:Body>
                <v11:LabelRecoveryRequest>
                    <v11:LabelSpecification>
                        <v11:LabelImageFormat>
                            <v11:Code>GIF</v11:Code>
                        </v11:LabelImageFormat>
                        <v11:HTTPUserAgent>Mozilla/4.5</v11:HTTPUserAgent>
                    </v11:LabelSpecification>
                    <v11:Translate>
                        <v11:LanguageCode>eng</v11:LanguageCode>
                        <v11:DialectCode>GB</v11:DialectCode>
                        <v11:Code>01</v11:Code>
                    </v11:Translate>
                    <v11:TrackingNumber>' . $trackingID . '</v11:TrackingNumber>
                </v11:LabelRecoveryRequest>
            </soapenv:Body>
        </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml',
                'Cookie: ak_bmsc=D9F7A3D83C3B5E98125970578EBE57DB~000000000000000000000000000000~YAAQtBTfrWsMyTKGAQAAcARluBMau1WlwR2KoCQTjtai69CsSLfLcbvlDpDV1jRq9x/FBp+eRQPZUuh2Eh2TQvfWAAeuNui3Z7lSHkwQaNPbBwG13J+JRC2Ew41iG1b42xwPUJKpKWE1hCWs9YCJQKgpd+BG9WCBhJt3CdXPqDFnyIPT2+qUOBYqmeQgdoCs2qCEFonhjnZPDihcGH+3w5ngmO0t1/e/09IP7KZ7UPEZZyuU+V1MHugMh+nBEifCAnlLgDxcpaUokn92LISg1N/prbv0maL2jJk+pcdy3b2TFeT/gfo4YbTJZEP/O7xtR/DjO+wvfQb+ymy0hsh3P6NUmrh1jaKMycecqJtPrTGNJ15wkuxyTlH3dQ==; bm_sv=06A9CC770460C29DDC300A5E32356628~YAAQrw4VAnwvYouGAQAAQWI5uBOK5vDqithGPd8kT0DRfBsGK/I0nhucmi4ower/wvcuFNFdqdNithUHHkTFxdrX/tvjux18fDDNeR//e/i2CsvTXVJM0DW4gxnPisRw5Alnrd0ZXbF87+2jmIRYNty9vx1K/ur6AW929vnJDvsBTi7lpcWPJjr0XpqqI1GMvw9yCdAwFtGerU7i3WoArIxnaa2XeggF/kHHs6ISu8zYMGTuHamHObJG2PHgyw==~1'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        $plainXML = $this->mungXML(trim($response));
        $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        $strUnique = sprintf('%u', ip2long($_SERVER['REMOTE_ADDR'])) . floor(microtime(true) * 1000);


        if (isset($arrayResult['soapenv_Body']['labelRecovery_LabelRecoveryResponse']['labelRecovery_LabelResults']['labelRecovery_LabelImage']['labelRecovery_GraphicImage'])) {
            $gImage = $arrayResult['soapenv_Body']['labelRecovery_LabelRecoveryResponse']['labelRecovery_LabelResults']['labelRecovery_LabelImage']['labelRecovery_GraphicImage'];

            $imageFile = public_path() . "/shipment/" . $strUnique;
            //$file=fopen($imageFile . ".gif","w");
            //fwrite($file,base64_decode($gImage));
            $storedFile = Storage::disk('public_labels')->put($strUnique . ".gif", base64_decode($gImage));


            /*
            $image = base64_decode($gImage);
            $response = \Response::make($image,200);
            $response->header('content-type', 'image/gif');
            return $response;
            */

            $image = URL::to('/') . "/shipment/" . $strUnique . ".gif";

            $html = '<style>
            .rotate_image {
                -webkit-transform: rotate(90deg);
                -moz-transform: rotate(90deg);
                -ms-transform: rotate(90deg);
                -o-transform: rotate(90deg);
                transform: rotate(90deg);
                margin-top: 500;
            }

            h1 {
                color: green;
            }
        </style>';
            $html .= '<img id="image_canv" src="' . $image . '" class="rotate_image">';


            return $html;
        }
        return 'Missing/Invalid LabelSpecification/ LabelImageFormat/Code';
    }
}
