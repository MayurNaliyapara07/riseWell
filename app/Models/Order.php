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

        'sending_order_shipment_status',
        'sending_lab_shipment_status',
        'receiving_order_shipment_status',
        'receiving_lab_shipment_status',

        'sending_order_tracking_no',
        'sending_lab_tracking_no',
        'receiving_order_tracking_no',
        'receiving_lab_tracking_no',

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
        'shipping_and_processing_amount',
        'sending_order_status',
        'receiving_order_status',
        'sending_lab_status',
        'receiving_lab_status',


    ];


    protected $entity = 'order';

    public $filter;

    protected $_helper;

    const ORDER_STATUS_NEW_ORDER = "NewOrder";

    const ORDER_STATUS_PLACED = "Placed";

    const ORDER_STATUS_APPROVED = "Approved";

    const ORDER_STATUS_SHIPPED = "Shipped";

    const ORDER_STATUS_ARRIVED = "Arrived";

    const ORDER_STATUS_FULFILLED = "Fulfilled";

    const ORDER_STATUS_READY = "LabsReady";

    const ORDER_STATUS_DELIVERED = "Delivered";

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
        $this->selectColomns([
            $this->table . '.order_id',

            $this->table . '.sending_order_tracking_no',
            $this->table . '.sending_lab_tracking_no',

            $this->table . '.receiving_order_tracking_no',
            $this->table . '.receiving_lab_tracking_no',

            $this->table . '.sending_order_status',
            $this->table . '.sending_order_shipment_status',

            $this->table . '.sending_lab_status',
            $this->table . '.sending_lab_shipment_status',

            $this->table . '.receiving_order_status',
            $this->table . '.receiving_order_shipment_status',

            $this->table . '.receiving_lab_status',
            $this->table . '.receiving_lab_shipment_status',

            $this->table . '.customer_name',
            $this->table . '.customer_email',
            $this->table . '.payment_status',
            $this->table . '.invoice_pdf',
            $this->table . '.created_at'
        ]);

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
                                       <li class="nav-item"><a class="nav-link" href="' . route('order.show', $row->order_id) . '"><i class="nav-icon la la-eye"></i><span class="nav-text">View</span></a></li>
                                       <li class="nav-item"><a class="nav-link trackingHistory" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="nav-icon la la-history"></i><span class="nav-text">Tracking History</span></a></li>
                                       <li class="nav-item"><a class="nav-link shipmentStatus" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="nav-icon la la-shipping-fast"></i><span class="nav-text">Shipping Status</span></a></li>
                                       <li class="nav-item"><a class="nav-link orderStatus" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="nav-icon la la-eye-dropper"></i><span class="nav-text">Order Status</span></a></li>
                                </ul>
                            </div>
                        </div>';
            return $action;
        })
            ->editColumn('customer_details', function ($row) {
                $customerDetails = '<span style="width: 250px;">
                          <div class="d-flex align-items-center">
                          <div class="symbol symbol-40 symbol-info flex-shrink-0">
                          <div class="symbol-label">' . $row->customer_name[0] . '</div></div>
                          <div class="ml-2">
                          <div class="text-dark-75 font-weight-bold line-height-sm">' . $row->customer_name . '</div>
                          <a href="' . route('order.show', $row->order_id) . '" class="font-size-sm text-dark-50 text-hover-primary">' . $row->customer_email . '</a></div>
                          </div></span>';
                return $customerDetails;
            })
            ->editColumn('sending_order_status', function ($row) {
                $sendingOrderStatus = "";
                if ($row->sending_order_status == self::ORDER_STATUS_NEW_ORDER) {
                    $sendingOrderStatus = '<span class="badge badge-dark">New Order</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_PLACED) {
                    $sendingOrderStatus = '<span class="badge badge-primary">Order Placed</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_APPROVED) {
                    $sendingOrderStatus = '<span class="badge badge-success">Approved</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_SHIPPED) {
                    $sendingOrderStatus = '<span class="badge badge-info">Order Shipped</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_ARRIVED) {
                    $sendingOrderStatus = '<span class="badge badge-warning">Order Arrived</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_FULFILLED) {
                    $sendingOrderStatus = '<span class="badge badge-success">Fulfilled</span>';
                } else if ($row->sending_order_status == self::ORDER_STATUS_DELIVERED) {
                    $sendingOrderStatus = '<span class="badge badge-primary">Delivered</span>';
                }
                return $sendingOrderStatus;
            })
            ->editColumn('receiving_order_status', function ($row) {
                $receivingOrderStatus = "";
                if ($row->receiving_order_status == self::ORDER_STATUS_NEW_ORDER) {
                    $receivingOrderStatus = '<span class="badge badge-dark">New Order</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_PLACED) {
                    $receivingOrderStatus = '<span class="badge badge-primary">Order Placed</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_APPROVED) {
                    $receivingOrderStatus = '<span class="badge badge-success">Approved</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_SHIPPED) {
                    $receivingOrderStatus = '<span class="badge badge-info">Order Shipped</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_ARRIVED) {
                    $receivingOrderStatus = '<span class="badge badge-warning">Order Arrived</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_FULFILLED) {
                    $receivingOrderStatus = '<span class="badge badge-success">Fulfilled</span>';
                } else if ($row->receiving_order_status == self::ORDER_STATUS_DELIVERED) {
                    $receivingOrderStatus = '<span class="badge badge-primary">Delivered</span>';
                }
                return $receivingOrderStatus;
            })
            ->editColumn('sending_lab_status', function ($row) {
                $sendingLabsStatus = "";
                if ($row->sending_lab_status == self::ORDER_STATUS_NEW_ORDER) {
                    $sendingLabsStatus = '<span class="badge badge-dark">New Order</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_PLACED) {
                    $sendingLabsStatus = '<span class="badge badge-primary">Order Placed</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_APPROVED) {
                    $sendingLabsStatus = '<span class="badge badge-success">Approved</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_SHIPPED) {
                    $sendingLabsStatus = '<span class="badge badge-info">Order Shipped</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_ARRIVED) {
                    $sendingLabsStatus = '<span class="badge badge-warning">Order Arrived</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_FULFILLED) {
                    $sendingLabsStatus = '<span class="badge badge-success">Fulfilled</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_DELIVERED) {
                    $sendingLabsStatus = '<span class="badge badge-primary">Delivered</span>';
                } else if ($row->sending_lab_status == self::ORDER_STATUS_READY) {
                    $sendingLabsStatus = '<span class="badge badge-primary">Labs Ready</span>';
                }
                return $sendingLabsStatus;
            })
            ->editColumn('receiving_lab_status', function ($row) {
                $receivingLabsStatus = "";
                if ($row->receiving_lab_status == self::ORDER_STATUS_NEW_ORDER) {
                    $receivingLabsStatus = '<span class="badge badge-dark">New Order</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_PLACED) {
                    $receivingLabsStatus = '<span class="badge badge-primary">Order Placed</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_APPROVED) {
                    $receivingLabsStatus = '<span class="badge badge-success">Approved</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_SHIPPED) {
                    $receivingLabsStatus = '<span class="badge badge-info">Order Shipped</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_ARRIVED) {
                    $receivingLabsStatus = '<span class="badge badge-warning">Order Arrived</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_FULFILLED) {
                    $receivingLabsStatus = '<span class="badge badge-success">Fulfilled</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_DELIVERED) {
                    $receivingLabsStatus = '<span class="badge badge-primary">Delivered</span>';
                } else if ($row->receiving_lab_status == self::ORDER_STATUS_READY) {
                    $receivingLabsStatus = '<span class="badge badge-primary">Labs Ready</span>';
                }
                return $receivingLabsStatus;
            })
            ->editColumn('sending_order_shipment_status', function ($row) {

                $shipmentStatus = "";
                if ($row->sending_order_shipment_status == self::FEDEX) {
                    $shipmentStatus = '<span class="badge badge-primary">' . self::FEDEX . '</span>';
                } else if ($row->sending_order_shipment_status == self::USPS) {
                    $shipmentStatus = '<span class="badge badge-warning">' . self::USPS . '</span>';
                } else if ($row->sending_order_shipment_status == self::UPS) {
                    $shipmentStatus = '<span class="badge badge-info">' . self::UPS . '</span>';
                }
                return $shipmentStatus;
            })
            ->editColumn('receiving_order_shipment_status', function ($row) {
                $shipmentStatus = "";
                if ($row->receiving_order_shipment_status == self::FEDEX) {
                    $shipmentStatus = '<span class="badge badge-primary">' . self::FEDEX . '</span>';
                } else if ($row->receiving_order_shipment_status == self::USPS) {
                    $shipmentStatus = '<span class="badge badge-warning">' . self::USPS . '</span>';
                } else if ($row->receiving_order_shipment_status == self::UPS) {
                    $shipmentStatus = '<span class="badge badge-info">' . self::UPS . '</span>';
                }
                return $shipmentStatus;
            })
            ->editColumn('sending_lab_shipment_status', function ($row) {

                $LabsShipmentStatus = "";
                if ($row->sending_lab_shipment_status == self::FEDEX) {
                    $LabsShipmentStatus = '<span class="badge badge-primary">' . self::FEDEX . '</span>';
                } else if ($row->sending_lab_shipment_status == self::USPS) {
                    $LabsShipmentStatus = '<span class="badge badge-warning">' . self::USPS . '</span>';
                } else if ($row->sending_lab_shipment_status == self::UPS) {
                    $LabsShipmentStatus = '<span class="badge badge-info">' . self::UPS . '</span>';
                }
                return $LabsShipmentStatus;
            })
            ->editColumn('receiving_lab_shipment_status', function ($row) {
                $LabsShipmentStatus = "";
                if ($row->receiving_lab_shipment_status == self::FEDEX) {
                    $LabsShipmentStatus = '<span class="badge badge-primary">' . self::FEDEX . '</span>';
                } else if ($row->receiving_lab_shipment_status == self::USPS) {
                    $LabsShipmentStatus = '<span class="badge badge-warning">' . self::USPS . '</span>';
                } else if ($row->receiving_lab_shipment_status == self::UPS) {
                    $LabsShipmentStatus = '<span class="badge badge-info">' . self::UPS . '</span>';
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
            })
            ->addIndexColumn()
            ->rawColumns([
                'customer_details',
                'order_id',
                'sending_order_tracking_no',
                'sending_lab_tracking_no',
                'receiving_order_tracking_no',
                'receiving_lab_tracking_no',
                'sending_order_status',
                'sending_order_shipment_status',
                'sending_lab_status',
                'sending_lab_shipment_status',
                'receiving_order_status',
                'receiving_order_shipment_status',
                'receiving_lab_status',
                'receiving_lab_shipment_status',
                'payment_status',
                'created_at',
                'action'
            ])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->where('order_id', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('customer_email', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('customer_name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('payment_status', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('sending_order_tracking_no', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('sending_lab_tracking_no', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('sending_order_shipment_status', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('sending_lab_shipment_status', "LIKE", '%' . trim($search_value) . '%');
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

        if (!empty($request['sending_tracking_type']) && $request['sending_tracking_type'] == 'order') {
            $data['sending_order_shipment_status'] = $request['sending_shipment_status'];
            $data['sending_order_tracking_no'] = $request['sending_tracking_no'];
        } else if (!empty($request['sending_tracking_type']) && $request['sending_tracking_type'] == 'lab') {
            $data['sending_lab_shipment_status'] = $request['sending_shipment_status'];
            $data['sending_lab_tracking_no'] = $request['sending_tracking_no'];
        }
        else if (!empty($request['receiving_tracking_type']) && $request['receiving_tracking_type'] == 'order') {
            $data['receiving_order_shipment_status'] = $request['receiving_shipment_status'];
            $data['receiving_order_tracking_no'] = $request['receiving_tracking_no'];
        } else if (!empty($request['receiving_tracking_type']) && $request['receiving_tracking_type'] == 'lab') {
            $data['receiving_lab_shipment_status'] = $request['receiving_shipment_status'];
            $data['receiving_lab_tracking_no'] = $request['receiving_tracking_no'];
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
