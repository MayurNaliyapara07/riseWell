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
        'order_status',

    ];
    protected $entity = 'order';
    public $filter;
    protected $_helper;

    const ORDER_STATUS_PLACED = "OrderPlaced";
    const ORDER_STATUS_APPROVED = "Approved";
    const ORDER_STATUS_SHIPPED = "OrderShipped";
    const ORDER_STATUS_ARRIVED = "OrderArrived";
    const ORDER_STATUS_FULFILLED = "Fulfilled";
    const PAYMENT_STATUS_PAID = "paid";
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

        $this->selectColomns([$this->table . '.order_id', $this->table . '.order_status', $this->table . '.customer_name', $this->table . '.customer_email', $this->table . '.payment_status', $this->table . '.status', $this->table . '.sub_total', $this->table . '.total_amount', $this->table . '.invoice_pdf', $this->table . '.created_at']);

        $model = $this->getQueryBuilder();

        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');

        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<a href="' . $row->invoice_pdf . '" target="_blank" class="ml-3 btn btn-sm btn-primary btn-clean btn-icon"><i class="la la-file-pdf"></i></a>
                       <a class="orderStatus ml-3 btn btn-sm btn-info btn-clean btn-icon" data-toggle="modal"  data-id="' . $row->order_id . '"><i class="la la-eye-dropper"></i></a>';
            return $action;
        })->editColumn('customer_email', function ($row) {
            $paymentId = '<a href="' . route('order.show', $row->order_id) . '" class="text-dark-75 font-weight-bold line-height-sm">' . $row->customer_email . '</a><br>';
            return $paymentId;
        })->editColumn('order_status', function ($row) {
            $orderStatus = "";
            if ($row->order_status == self::ORDER_STATUS_PLACED) {
                $orderStatus = '<span class="badge badge-success">Order Placed</span>';
            } else if ($row->order_status == self::ORDER_STATUS_APPROVED) {
                $orderStatus = '<span class="badge badge-primary">Approved</span>';
            } else if ($row->order_status == self::ORDER_STATUS_SHIPPED) {
                $orderStatus = '<span class="badge badge-info">Order Shipped</span>';
            } else if ($row->order_status == self::ORDER_STATUS_ARRIVED) {
                $orderStatus = '<span class="badge badge-warning">Order Arrived</span>';
            } else if ($row->order_status == self::ORDER_STATUS_FULFILLED) {
                $orderStatus = '<span class="badge badge-success">Fulfilled</span>';
            }
            return $orderStatus;
        })->editColumn('payment_status', function ($row) {
            if ($row->payment_status == self::PAYMENT_STATUS_PAID) {
                $paymentStatus = '<span class="badge badge-success">Paid</span>';
            } else {
                $paymentStatus = '<span class="badge badge-danger">Unpaid</span>';
            }
            return $paymentStatus;
        })->editColumn('created_at', function ($row) {
            return $this->displayDate($row->created_at);
        })->addIndexColumn()
            ->rawColumns(['order_id', 'order_status', 'customer_email', 'payment_status', 'created_at', 'action'])
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
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));

    }

}
