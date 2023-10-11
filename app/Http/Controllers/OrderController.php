<?php

namespace App\Http\Controllers;

use App\Helpers\BaseHelper;
use App\Http\Controllers\Common\BaseController;
use App\Models\Order;
use App\Models\OrderWiseStatus;
use App\Models\Patients;
use App\Models\Schedule;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use function Laravel\Prompts\error;

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

    public function appointmentBook($orderId,$patientsId){

        $order = $this->_model->loadModel($orderId);
        if (!empty($order)){
            if ($order->sending_lab_status == 'LabsReady' || $orderId->receiving_order_status == 'LabsReady'){
                $patientsObj = new Patients();
                $patientDetails = $patientsObj->loadModel($patientsId);
                $assignProgram = app('\App\Http\Controllers\Common\CommonController')->getRendomAssignProgram();
                $providers = app('\App\Http\Controllers\Common\CommonController')->getRandomProvider($patientDetails->state_id);
                return view('frontend.appointment')->with(compact('patientsId','orderId','patientDetails','assignProgram','providers'));
            }
        }
        else{
            return abort(404, 'Page Not Found');
        }
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
        $trackingType = $request['tracking_type'];
        $sendingType = $request['sending_type'];

        if ($trackingType == 'order' && $sendingType == 'sending') {
            $orderStatus = $request->order_status;
            $field = 'sending_order_status';
        }
        if ($trackingType == 'lbs' && $sendingType == 'sending') {
            $orderStatus = $request->order_status;
            $field = 'sending_lab_status';
        }


        if ($trackingType == 'order' && $sendingType == 'receiving') {
            $orderStatus = $request->order_status;
            $field = 'receiving_order_status';
        }

        if ($trackingType == 'lbs' && $sendingType == 'receiving') {
            $orderStatus = $request->order_status;
            $field = 'receiving_lab_status';
        }




        $orderDetails = $this->_model->loadModel($orderId);
        $patientsObj = new Patients();
        $patientsDetails = $patientsObj->loadModel($orderDetails->patients_id);
        if ((!empty($orderDetails))) {

            $orderDetails->update([$field => $orderStatus]);

            OrderWiseStatus::updateOrCreate(
                ['order_id' => $orderId, 'status' => 'Order' . $orderStatus],
                ['description' => 'Your Order is ' . $orderStatus, 'date' => Carbon::now()]
            );

            $customerEmail = !empty($orderDetails->customer_email) ? $orderDetails->customer_email : '';
            $customerPhoneNo = !empty($patientsDetails->phone_no) ? $patientsDetails->country_code . "" . $patientsDetails->phone_no : '';
            $smsNotification = $baseHelper->sendSMSNotification($customerPhoneNo, $orderStatus, $trackingType, '');
            $mailNotification = $baseHelper->sendMailNotification($customerEmail, $orderStatus, $trackingType);
            if ($mailNotification['status'] == true || $mailNotification['status'] == null) {
                return $this->webResponse('Email sent to ' . $customerEmail . ' successfully');
            } else {
                return $this->webResponse($mailNotification['message'], false);
            }
        }
    }


    public function saveShipmentStatus(Request $request)
    {
        return $this->_model->createShipmentDetails($request->all());
    }

    public function getTrackingHistory(Request $request)
    {
        $orderId = $request->post('order_id');
        if (!empty($orderId)) {
            $timeLine =  DB::table('order_wise_status')
                ->select(['status','date','order_id','description', DB::raw("date_format(date, '%d %M %Y %h:%i')as date")])
                ->where('order_id', $orderId)
                ->get()->toArray();
            return response()->json([$timeLine], 200);
        }
    }

}
