<?php

namespace App\Models;

use App\Helpers\Order\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\DataTables;

class Order extends BaseModel
{
    use HasFactory;

    protected $table = "order";

    protected $primaryKey = "order_id";

    protected $fillable = [
        'order_shipment_status',
        'lab_shipment_status',
        'order_tracking_no',
        'lab_tracking_no',
        'patients_id',
        'session_id',
        'currency',
        'customer_id',
        'customer_email',
        'customer_name',
        'customer_phone_no',
        'customer_address',
        'product_details',
        'discount_details',
        'shipping_and_processing_amount',
        'invoice_id',
        'invoice_pdf',
        'mode',
        'payment_status',
        'subscription_id',
        'payment_method_id',
        'card_brand',
        'exp_month',
        'exp_year',
        'last4',
        'status',
        'sub_total',
        'total_amount',
        'order_status',
        'lab_status',

    ];

    protected $entity = 'order';

    public $filter;

    protected $_helper;

    const ORDER_STATUS_PLACED = "Placed";

    const ORDER_STATUS_APPROVED = "Approved";

    const ORDER_STATUS_SHIPPED = "Shipped";

    const ORDER_STATUS_ARRIVED = "Arrived";

    const ORDER_STATUS_FULFILLED = "Fulfilled";

    const ORDER_STATUS_READY = "LabsReady";

    const PAYMENT_STATUS_PAID = "paid";

    const FEDEX = "Fedex";

    const USPS = "USPS";

    const UPS = "UPS";

    const PAYMENT_STATUS_UNPAID = "unpaid";

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getOrder()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.order_id',$this->table.'.lab_shipment_status',$this->table.'.lab_tracking_no',$this->table . '.order_shipment_status', $this->table . '.order_tracking_no', $this->table . '.order_status', $this->table . '.customer_name', $this->table . '.customer_email', $this->table . '.payment_status', $this->table . '.status', $this->table.'.lab_status', $this->table . '.invoice_pdf', $this->table . '.created_at']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
                $action = '<div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-sm btn-primary btn-clean btn-icon" data-toggle="dropdown">
                                <i class="la la-cog"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <ul class="nav nav-hoverable flex-column">
                                       <li class="nav-item"><a class="nav-link" href="' . $row->invoice_pdf . '" target="_blank"><i class="nav-icon la la-file-pdf"></i><span class="nav-text">PDF</span></a></li>
                                       <li class="nav-item"><a class="nav-link" href="'.route('order.show', $row->order_id).'"><i class="nav-icon la la-eye"></i><span class="nav-text">View</span></a></li>
                                </ul>
                            </div>
                        </div>
                       <a class="shipmentStatus ml-3 btn btn-sm btn-primary btn-icon" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="fas fa-shipping-fast"></i></a>
                       <a class="orderStatus ml-3 btn btn-sm btn-info btn-clean btn-icon" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="la la-eye-dropper"></i></a>';
            return $action;
        })->editColumn('customer_details', function ($row) {
            $customerDetails = '<span style="width: 250px;">
                          <div class="d-flex align-items-center">
                          <div class="symbol symbol-40 symbol-info flex-shrink-0">
                          <div class="symbol-label">' . $row->customer_name[0] . '</div></div>
                          <div class="ml-2">
                          <div class="text-dark-75 font-weight-bold line-height-sm">' . $row->customer_name . '</div>
                          <a href="'.route('order.show', $row->order_id).'" class="font-size-sm text-dark-50 text-hover-primary">' . $row->customer_email . '</a></div>
                          </div></span>';
            return $customerDetails;
        })->editColumn('order_status', function ($row) {
            $orderStatus = "";
            if ($row->order_status == self::ORDER_STATUS_PLACED) {
                $orderStatus = '<span class="badge badge-primary">Order Placed</span>';
            }
            else if ($row->order_status == self::ORDER_STATUS_APPROVED) {
                $orderStatus = '<span class="badge badge-success">Approved</span>';
            }
            else if ($row->order_status == self::ORDER_STATUS_SHIPPED) {
                $orderStatus = '<span class="badge badge-info">Order Shipped</span>';
            }
            else if ($row->order_status == self::ORDER_STATUS_ARRIVED) {
                $orderStatus = '<span class="badge badge-warning">Order Arrived</span>';
            }
            else if ($row->order_status == self::ORDER_STATUS_FULFILLED) {
                $orderStatus = '<span class="badge badge-success">Fulfilled</span>';
            }
            return $orderStatus;
        })->editColumn('lab_status', function ($row) {
                $labsStatus = "";
                if ($row->lab_status == self::ORDER_STATUS_PLACED) {
                    $labsStatus = '<span class="badge badge-primary">Order Placed</span>';
                }
                else if ($row->lab_status == self::ORDER_STATUS_APPROVED) {
                    $labsStatus = '<span class="badge badge-success">Order Approved</span>';
                }
                else if ($row->lab_status == self::ORDER_STATUS_SHIPPED) {
                    $labsStatus = '<span class="badge badge-info">Order Shipped</span>';
                }
                else if ($row->lab_status == self::ORDER_STATUS_ARRIVED) {
                    $labsStatus = '<span class="badge badge-warning">Order Arrived</span>';
                }
                else if ($row->lab_status == self::ORDER_STATUS_FULFILLED) {
                    $labsStatus = '<span class="badge badge-success">Fulfilled</span>';
                }
                else if ($row->lab_status == self::ORDER_STATUS_READY) {
                    $labsStatus = '<span class="badge badge-primary">Labs Ready</span>';
                }
                return $labsStatus;
            })
            ->editColumn('order_shipment_status', function ($row) {
            $shipmentStatus = "";
            if ($row->order_shipment_status == self::FEDEX) {
                $shipmentStatus = '<span class="badge badge-primary">'.self::FEDEX.'</span>';
            }
            else if ($row->order_shipment_status == self::USPS) {
                $shipmentStatus = '<span class="badge badge-warning">'.self::USPS.'</span>';
            }
            else if ($row->order_shipment_status == self::UPS) {
                $shipmentStatus = '<span class="badge badge-info">'.self::UPS.'</span>';
            }
            return $shipmentStatus;
        })->editColumn('lab_shipment_status', function ($row) {
                $LabsShipmentStatus = "";
                if ($row->lab_shipment_status == self::FEDEX) {
                    $LabsShipmentStatus = '<span class="badge badge-primary">'.self::FEDEX.'</span>';
                }
                else if ($row->lab_shipment_status == self::USPS) {
                    $LabsShipmentStatus = '<span class="badge badge-warning">'.self::USPS.'</span>';
                }
                else if ($row->lab_shipment_status == self::UPS) {
                    $LabsShipmentStatus = '<span class="badge badge-info">'.self::UPS.'</span>';
                }
                return $LabsShipmentStatus;
            })
            ->editColumn('payment_status', function ($row) {
            if ($row->payment_status == self::PAYMENT_STATUS_PAID) {
                $paymentStatus = '<span class="badge badge-success">Paid</span>';
            } else {
                $paymentStatus = '<span class="badge badge-danger">Unpaid</span>';
            }
            return $paymentStatus;
        })
            ->editColumn('created_at', function ($row) {
            return $this->displayDate($row->created_at);
        })->addIndexColumn()
            ->rawColumns(['order_id', 'order_tracking_no','lab_tracking_no', 'order_status','lab_status','order_shipment_status','lab_shipment_status','customer_details', 'payment_status', 'created_at', 'action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->where('customer_email', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('customer_name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('payment_status', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('status', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('order_tracking_no', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('order_shipment_status', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('order_id', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));

    }

    public function createShipmentDetails($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        $data['order_id'] = $request['order_id'];
        if (!empty($request['tracking_type']) && $request['tracking_type'] == 'order'){
            $data['order_shipment_status'] = $request['shipment_status'];
            $data['order_tracking_no'] = $request['tracking_no'];
        }
        else{
            $data['lab_shipment_status'] = $request['shipment_status'];
            $data['lab_tracking_no'] = $request['tracking_no'];
        }
        $response = $this->saveShipmentDetails($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['order_id'] = $response['order_id'];
            $result['redirectUrl'] = '/order';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }

        return $result;
    }

    public function saveShipmentDetails($data)
    {
        $rules['order_id'] = 'required';
        $message['order_id.required'] = 'Order Id is required';

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithMessage($rules, $data, $message);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }
        $this->beforeSave($data);

        $order = self::findOrFail($data['order_id']);
        $order->update($data);
        $order_id = $order->order_id;
        $this->afterSave($data, $order);

        $response['success'] = true;
        $response['message'] = 'Shipment Status has been updated successfully !';
        $response['order_id'] = $order_id;
        return $response;

    }

}
