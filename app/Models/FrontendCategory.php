<?php

namespace App\Models;

use App\Helpers\FrontendCategory\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\DataTables\DataTables;

class FrontendCategory extends BaseModel
{
    use HasFactory;
    protected $table="frontend_category";
    protected $primaryKey="f_category_id";
    protected $fillable=['image','category_name'];

    protected $entity = 'category';
    public $filter;
    protected $_helper;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'f_category_id');
    }

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getCategoryList(){
        $this->setSelect();
        $this->selectColomns([$this->table . '.category_name',$this->table . '.image', $this->table . '.f_category_id']);
        $model = $this->getQueryBuilder();
        $columnsOrderData = $this->getOrderByFieldAndValue(request()->get("order"), request()->get("columns"), $this->primaryKey, 'DESC');
        $query = DataTables::of($model)->order(function ($query) use ($columnsOrderData) {
            $query->orderBy($columnsOrderData['columnsOrderField'], $columnsOrderData['columnsOrderType']);
        });
        $query = $query->addColumn('action', function ($row) {
            $action =  '<a href="' . route('category.edit', $row->f_category_id) . '" class="ml-3 btn btn-sm btn-warning btn-clean btn-icon" title="Edit"><i class="la la-edit"></i> </a>
                       <a href="javascript:;"  onclick="deleteRecord(\'category\',' . $row->f_category_id . ')" class="ml-3 btn btn-sm btn-danger btn-clean btn-icon" title="Delete"><i class="la la-trash"></i></a>';
            return $action;
        })->editColumn('image', function ($row) {
            $categoryImage =
                '<div class="d-flex align-items-center">
                    <a href="'.$this->getFileUrl($row->image).'">
                     <img src="'.$this->getFileUrl($row->image).'" class="w-50px h-50px rounded-3 me-3" alt="" style="border: 1px solid #EBEDF3;">
                    </a>
                 </div>';
            return $categoryImage;
        })->addIndexColumn()
            ->rawColumns(['category_name','image','action'])
            ->filter(function ($query) {
                $search_value = request()['search']['value'];
                $column = request()['columns'];
                if (!empty($search_value)) {
                    foreach ($column as $value) {
                        if ($value['searchable'] == 'true') {
                            $query->Where('category_name', "LIKE", '%' . trim($search_value) . '%');
                        }
                    }
                }
            });
        return $this->dataTableResponse($query->make(true));
    }

    public function createRecord($request){

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
        $data['f_category_id'] = !empty($request['f_category_id']) ? $request['f_category_id'] : '';
        $response = $this->saveRecord($data);
        if ($response['success']) {
            $result['success'] = true;
            $result['message'] = $response['message'];
            $result['f_category_id'] = $response['f_category_id'];
            $result['redirectUrl'] = '/category';
        } else {
            $messages = [];
            foreach ($response['message'] as $key => $responseMessage) {
                $messages[] = $responseMessage[0];
            }
            $result['message'] = !empty($messages) ? implode('<br>', $messages) : $messages;
        }
        return $result;
    }

    public function saveRecord($data){

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
        if (isset($data['f_category_id']) && $data['f_category_id'] != '') {
            $category = self::findOrFail($data['f_category_id']);
            $old_image = $category->image;
            if(!empty($data['image'])){
                $filePath = $this->getFilesDirectory();
                $this->removeFileFromStorage($filePath.'/'.$old_image);
            }
            else{
                $data['image']=$old_image;
            }
            $category->update($data);
            $category_id = $category->f_category_id;
            $this->afterSave($data, $category);
        } else {
            $category = self::create($data);
            $this->afterSave($data, $category);
            $category_id = $category->f_category_id;
        }

        $response['success'] = true;
        $response['message'] = !empty($data['f_category_id']) ? $this->successfullyMsg(self::UPDATE_FOR_MSG) : $this->successfullyMsg(self::SAVE_FOR_MSG);
        $response['f_category_id'] = $category_id;
        return $response;

    }

    public function remove($id){
        $categoryDetails = $this->loadModel($id);
        $image = $categoryDetails->image;
        if (isset($image)){
            $filePath = $this->getFilesDirectory();
            $this->removeFileFromStorage($filePath.'/'.$image);
        }
        return $this->removed($id);
    }

}
