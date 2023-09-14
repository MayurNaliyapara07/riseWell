<?php

namespace App\Http\Controllers;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Common\BaseController;
use App\Models\Order;
use App\Models\Patients;
use App\Models\Schedule;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class OrderController extends BaseController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new Order();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.order.index')->with('AJAX_PATH', 'get-order');
    }

    public function getOrder()
    {

        return $this->_model->getOrder();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->_model->loadModel($id);
        return view('master.order.show')->with(compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderTrack($id)
    {
        print_r($id);
    }

    public function orderStatusChange(Request $request)
    {

        $baseHelper = new BaseHelper();
        $orderId = $request->order_id;
        if (!empty($request['tracking_type']) && $request['tracking_type'] == 'order'){
            $orderStatus = $request->order_status;
            $field = 'order_status';
            $message = "Order";
        }
        else{
            $orderStatus = $request->order_status;
            $field = 'labs_status';
            $message = "Labs";
        }
        $orderDetails = $this->_model->loadModel($orderId);
        $patientsObj = new Patients();
        $patientsDetails  = $patientsObj->loadModel($orderDetails->patients_id);
        if ((!empty($orderDetails))) {
            $orderDetails->update([$field => $orderStatus]);
            $customerEmail = !empty($orderDetails->customer_email) ? $orderDetails->customer_email : '';
            $customerPhoneNo = !empty($patientsDetails->phone_no) ? $patientsDetails->country_code."".$patientsDetails->phone_no : '';


            $baseHelper->sendMailNotification($customerEmail,$orderStatus);
            $baseHelper->sendSMSNotification($customerPhoneNo,$orderStatus);
            return $this->webResponse($message.' Status has been updated successfully.');
        }
    }


    public function saveShipmentStatus(Request $request)
    {
        return $this->_model->createShipmentDetails($request->all());
    }


}
