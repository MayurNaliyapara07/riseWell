<?php

namespace App\Models;

use App\Helpers\Category\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\DataTables;

class Category extends BaseModel
{
    use HasFactory;

    protected $table = "category";
    protected $primaryKey = "category_id";
    protected $fillable = ['category_name', 'image'];

    protected $entity = 'category';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getCategoryList()
    {
        $this->setSelect();
        $this->selectColomns([$this->table . '.category_name', $this->table . '.image', $this->table . '.category_id']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action = '<a href="' . route('lab-category.edit', $row->category_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>
                       <a href="javascript:;"  onclick="deleteRecord(\'lab-category\',' . $row->category_id . ')" class="ml-3 btn btn-sm btn-danger btn-clean btn-icon" title="Delete"><i class="la la-trash"></i></a>';
            return $action;
        })->editColumn('image', function ($row) {
            $categoryImage =
                '<div class="d-flex align-items-center">
                     <img src="' . $this->getFileUrl($row->image) . '" class="w-50px h-50px rounded-3 me-3" alt="" style="border: 1px solid #EBEDF3;">
                     </div>';
            return $categoryImage;
        })->addIndexColumn()
            ->rawColumns(['category_name', 'image', 'action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->where('category_name', "LIKE", '%' . trim($search_value) . '%');
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
        $data['category_name'] = $request['category_name'];
        $data['category_id'] = !empty($request['category_id']) ? $request['category_id'] : '';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['category_id'] = $response['category_id'];
            $result['redirectUrl'] = '/lab-category';
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

        $rules['category_name'] = 'required';

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
        if (isset($data['category_id']) && $data['category_id'] != '') {
            $category = self::findOrFail($data['category_id']);
            if (!empty($data['image'])){
                $old_image = $category->image;
            }
            $category->update($data);
            if(!empty($old_image)){
                $filePath = $this->getFilesDirectory();
                $this->removeFileFromStorage($filePath.'/'.$old_image);
            }
            $category_id = $category->category_id;
            $this->afterSave($data, $category);
        } else {
            $category = self::create($data);
            $this->afterSave($data, $category);
            $category_id = $category->category_id;
        }

        $response['success'] = true;
        $response['message'] = !empty($data['category_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['category_id'] = $category_id;
        return $response;

    }

    public function remove($id)
    {
        $categoryDetails = $this->loadModel($id);
        $image = $categoryDetails->image;
        if (isset($image)) {
            $filePath = $this->getFilesDirectory();
            $this->removeFileFromStorage($filePath . '/' . $image);
        }
        return $this->removed($id);
    }


}
