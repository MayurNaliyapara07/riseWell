<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BaseController;
use App\Models\Order;
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

    public function orderTrack($id){
        print_r($id);
    }

    public function orderStatusChange(Request $request){
        $orderId = $request->order_id;
        $orderStatus = $request->order_status;
        $orderDetails = $this->_model->loadModel($orderId);
        if ((!empty($orderDetails))) {
            $orderDetails->update(['order_status' => $orderStatus]);
            $customerEmail = !empty($orderDetails->customer_email)?$orderDetails->customer_email:'';
            if (!empty($customerEmail)){
                $order['order_id'] =$orderId;
                $order['order_status'] =!empty($orderDetails->order_status)?$orderDetails->order_status:'';
                $order['traking_url'] = url('order-track')."/".$orderId;
                Mail::to($customerEmail)->send(new OrderStatus($order));
            }
            return $this->webResponse('Order Status has been updated successfully.');
        }
    }
}
