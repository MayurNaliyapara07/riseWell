<?php

namespace App\Models;

use App\Helpers\Product\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Stripe\Exception\ApiErrorException;
use Yajra\DataTables\DataTables;

class Product extends BaseModel
{
    use HasFactory;

    protected $table = "product";
    protected $primaryKey = "product_id";
    protected $fillable = ['type', 'stripe_plan', 'status','image', 'product_name', 'product_type', 'long_description', 'sort_description', 'slug', 'benifit', 'membership_subscription', 'category_id', 'sku', 'price', 'discount', 'shipping_cost', 'processing_fees'];

    protected $entity = 'product';
    public $filter;
    protected $_helper;

    const PRODUCT_TYPE_ED = 'ED';
    const PRODUCT_TYPE_TRT = 'TRT';

    const PRODUCT_STRIPE_TYPE_1 = 'OneTime';
    const PRODUCT_STRIPE_TYPE_2 = 'Subscription';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $stripe;
    protected $stripe_secret_key;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
        $gs = $this->_helper->gs();
        $this->stripe_secret_key = $gs->stripe_secret_key;
        $this->stripe = new \Stripe\StripeClient($this->stripe_secret_key);
    }

    public function getProductType()
    {
        return [
            ['key' => self::PRODUCT_TYPE_ED, 'value' => self::PRODUCT_TYPE_ED, 'label' => self::PRODUCT_TYPE_ED],
            ['key' => self::PRODUCT_TYPE_TRT, 'value' => self::PRODUCT_TYPE_TRT, 'label' => self::PRODUCT_TYPE_TRT],
        ];
    }

    public function getStripeProductType()
    {
        return [
            ['key' => self::PRODUCT_STRIPE_TYPE_1, 'value' => self::PRODUCT_STRIPE_TYPE_1, 'label' => self::PRODUCT_STRIPE_TYPE_1],
            ['key' => self::PRODUCT_STRIPE_TYPE_2, 'value' => self::PRODUCT_STRIPE_TYPE_2, 'label' => self::PRODUCT_STRIPE_TYPE_2],
        ];
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id');
    }

    public function getProductBySkU($sku,$type)
    {
        $this->setSelect();
        $selectedColumn = $this->selectColomns([$this->table . '.product_id', $this->table . '.product_name', $this->table . '.image', $this->table . '.sku', $this->table . '.price', $this->table . '.discount', $this->table . '.shipping_cost', $this->table . '.processing_fees', $this->table . '.product_type', $this->table . '.benifit', $this->table . '.membership_subscription', $this->table . '.stripe_plan', $this->table . '.slug']);
        $this->addFieldToFilter($this->table, 'sku', 'like', $sku);
        $this->addFieldToFilter($this->table, 'product_type', 'like', $type);
        $result = $this->get($selectedColumn)->first();
        return $result;

    }

    public function getCategoryName($categoryId)
    {
        $categoryObj = new FrontendCategory();
        $categoryTable = $categoryObj->getTable();
        $categoryName = $categoryObj->setSelect()->addFieldToFilter($categoryTable, 'f_category_id', '=', $categoryId)->get()->first();
        return $categoryName;
    }

    private function joinCategory()
    {
        $categoryObj = new FrontendCategory();
        $categoryTable = $categoryObj->getTable();
        $this->queryBuilder->leftJoin($categoryTable, function ($join) use ($categoryTable) {
            $join->on($this->table . '.category_id', '=', $categoryTable . '.f_category_id');
        });
        return $this;
    }

    public function getProductList()
    {
        $categoryObj = new FrontendCategory();
        $categoryTable = $categoryObj->getTable();
        $this->setSelect();
        $this->joinCategory();
        $this->selectColomns([$this->table . '.product_id',$this->table . '.product_type', $this->table . '.image',$this->table . '.status', $this->table . '.product_name', $this->table . '.sku', $this->table . '.price', $categoryTable . '.category_name']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });

        $query = $query->addColumn('action', function ($row) {
            $action = '<a href="' . route('product.edit', $row->product_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>';
            return $action;
        })->editColumn('product_type', function ($row) {
            if ($row->product_type == self::PRODUCT_TYPE_ED) {
                return '<span class="label label-lg label-primary label-inline">'.self::PRODUCT_TYPE_ED.'</span>';
            } else {
                return '<span class="label label-lg label-success label-inline">'.self::PRODUCT_TYPE_TRT.'</span>';
            }

        })->editColumn('status', function ($row) {
            if ($row->status == $this::STATUS_ACTIVE) {
                return '<span class="switch switch-sm switch-icon"><label><input type="checkbox" checked="checked" onclick="productChangeStatus(\'product-change-status\',' . $row->product_id . ')" name="select"/><span></span></label></span>';
            } else {
                return '<span class="switch switch-sm switch-icon"><label><input onclick="productChangeStatus(\'product-change-status\',' . $row->product_id . ')"  type="checkbox"  /><span></span></label></span>';
            }

        })->editColumn('image', function ($row) {
            $categoryImage =
                '<div class="d-flex align-items-center">
                     <img src="' . $this->getFileUrl($row->image) . '" class="w-50px h-50px rounded-3 me-3" alt="" style="border: 1px solid #EBEDF3;">
                     </div>';
            return $categoryImage;
        })->addIndexColumn()
            ->rawColumns(['category_name', 'product_name','product_type', 'image', 'sku', 'price', 'action','status'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->where('product_name', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('sku', "LIKE", '%' . trim($search_value) . '%');
                            $query->orWhere('price', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function createRecord($request)
    {
        $data = [];
        $result = ['success' => false, 'message' => ''];
        if ($request->hasFile('image')) {
            $logo = $request->file('image');
            $dir = $this->getFilesDirectory();
            $fileName = uniqid() . '.' . $logo->extension();
            $storagePath = $this->putFileToStorage($dir, $logo, $fileName, 'binary');
            if ($storagePath) {
                $data['image'] = $fileName;
            }
        }
        $data['type'] = $request['type'];
        $data['product_name'] = $request['product_name'];
        $data['stripe_plan'] = !empty($request['stripe_plan']) ? $request['stripe_plan'] : '';
        $data['product_type'] = $request['product_type'];
        $data['sku'] = $request['sku'];
        $data['slug'] = Str::slug($request['product_name']);
        $data['price'] = $request['price'];
        $data['discount'] = $request['discount'];
        $data['shipping_cost'] = $request['shipping_cost'];
        $data['processing_fees'] = $request['processing_fees'];
        $data['benifit'] = $request['benifit'];
        $data['membership_subscription'] = $request['membership_subscription'];
        $data['long_description'] = $request['long_description'];
        $data['sort_description'] = $request['sort_description'];
        $data['category_id'] = $request['category_id'];
        $data['product_id'] = !empty($request['product_id']) ? $request['product_id'] : '';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['product_id'] = $response['product_id'];
            $result['redirectUrl'] = '/product';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveRecord($data)
    {

        $rules['product_name'] = 'required';
        $rules['price'] = 'required|numeric';
        $rules['product_type'] = 'required';

        if (!empty($data['product_id'])) {
            $rules['sku'] = 'required|unique:' . $this->table . ',sku,' . $data['product_id'] . ',product_id';
        } else {
            $rules['sku'] = 'required|unique:' . $this->table;
            $rules['type'] = 'required';
        }

        $response = [];
        $response['success'] = false;
        $response['message'] = '';

        $validationResult = $this->validateDataWithRules($rules, $data);
        if ($validationResult['success'] == false) {
            $response['success'] = false;
            $response['message'] = ($validationResult['message']);
            return $response;
        }

        $this->beforeSave($data);

        if (isset($data['product_id']) && $data['product_id'] != '') {

            $product = self::findOrFail($data['product_id']);

            $product->update($data);

            $product_id = $product->product_id;

            $this->afterSave($data, $product);

        } else {

            $price = $data['price'] * 100;

            $productName = $data['product_name'];

            $productType = $data['type'];

            $stripePlan = $this->saveProductStripe($productName, $productType, $price);

            $data['stripe_plan'] = $stripePlan;

            $product = self::create($data);

            $this->afterSave($data, $product);

            $product_id = $product->product_id;
        }


        $response['success'] = true;
        $response['message'] = !empty($data['product_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['product_id'] = $product_id;
        return $response;

    }

    public function remove($id)
    {
        $this->beforeRemoved($id);
        $deleteObj = $this->loadModel($id);

        if (!empty($deleteObj)) {

            if (!empty($deleteObj['stripe_plan'])) {
                if (!empty($deleteObj->type == 'OneTime')){
                    $stripePrice = $this->stripe->prices->retrieve($deleteObj->stripe_plan);
                    $this->stripe->products->update($stripePrice->product,['active'=>false]);
                }
                else{
                    $stripePlan = $this->stripe->plans->retrieve($deleteObj->stripe_plan);

                    if (!empty($stripePlan['product'])) {
                        $this->stripe->plans->delete($stripePlan['id']);
                        $this->stripe->products->delete($stripePlan['product']);
                    }
                }
            }

            $deleteObj->delete();
            $this->afterRemoved($deleteObj);
            return ['status' => true, 'message' => $this->successfullyMsg(self::DELETE_FOR_MSG)];
        } else {
            return ['status' => false, 'message' => $this->unsuccessfullyMsg(self::DELETE_FOR_MSG)];
        }
    }

    public function saveProductStripe($productName, $productType, $price)
    {
        if (!empty($productType) && $productType == "OneTime") {
            $product_detail = $this->stripe->products->create([
                'name' => $productName,
            ]);
            $product_id = $product_detail->id;
            $price = $this->stripe->prices->create([
                'unit_amount' => $price,
                'currency' => 'usd',
                'product' => $product_id,
            ]);
            return $price->id;
        } else {
            $stripeProduct = $this->stripe->products->create(['name' => $productName]);
            $stripePlanCreation = $this->stripe->plans->create([
                'amount' => $price,
                'currency' => 'USD',
                'interval' => 'month',
                'product' => $stripeProduct->id,
            ]);
            return $stripePlanCreation->id;
        }
    }

}
