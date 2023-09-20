<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class BaseModel extends Model
{

    public $openingHoursOptions=[];


    protected $queryBuilder;

    use HasFactory;

    protected $defaultSortColumn = 'created_at';

    protected $_helper;

    const SAVE_FOR_MSG = 'saved';

    const UPDATE_FOR_MSG = 'updated';

    const DELETE_FOR_MSG = 'deleted';

    const SYNC_ACTION_UPDATE = 'update';

    const SYNC_ACTION_ADD = 'add';

    const SYNC_ACTION_DELETE = 'delete';

    const STATUS_ACTIVE = 1;

    const STATUS_INCTIVE = 0;

    const MODEL_BASE = '\App\Models';

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new \App\Helpers\BaseHelper;
    }

    public $dayInWeeks=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];


    public function makeOpeningHoursOptions(){
        $baseTime=Carbon::parse('today at 12 AM');
        while ($baseTime->notEqualTo(Carbon::parse('today 11:45 PM'))){
            $baseTime=$baseTime->addMinute(15);
            $this->openingHoursOptions[$baseTime->format('H:i')] = $baseTime->format('h:i A');
        }
        return $this->openingHoursOptions;
    }


    public function getState(){
        return self::where('country_id',231)->get();
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function fillableFields()
    {
        return $this->fillable;
    }

    public function hiddenFields()
    {
        return $this->hidden;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getLabelFromArray($key, $function, $arg = '')
    {
        $label = '';
        $statusList = ($arg != '') ? $this->$function($arg) : $this->$function();
        foreach ($statusList as $v) {
            if ($v['value'] == $key) {
                return $v['label'];
            }
        }

        return $label;
    }

    public function intervalLabel($key)
    {
        return $this->getLabelFromArray($key, 'getIntervalLength');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if ($model->uuid_column) {
                $model->{$model->uuid_column} = (string) Str::uuid();
            }

            self::formateNullBeforeSave($model);
        });

        self::updating(function ($model) {
            self::formateNullBeforeSave($model);
        });
    }

    public static function formateNullBeforeSave($model)
    {
        foreach ($model->getAttributes() as $key => $value) {
            if (is_null($value)) {
                unset($model->$key);
            }
        }
    }

    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function maskEmail($email)
    {
        if (empty($email) || !$this->isValidEmail($email)) {
            return '';
        }

        $em = explode('@', $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . '@' . substr_replace(end($em), str_repeat('*', strlen(end($em)) - 2), 2, strlen(end($em)));
    }

    public static function set_url_key($slug, $primaryKey, $id = '', $field = 'url_key')
    {
        $exists = self::select($primaryKey, $field)->where($field, '=', $slug)->first();

        if (!$exists || ($exists->$primaryKey == $id && !empty($id))) {
            return $slug;
        }

        $newSlug = $slug . '-1';

        return self::set_url_key($newSlug, $primaryKey);
    }

    /* Filter End */
    public function setSelect($queryBuilder = '')
    {
        if ($queryBuilder != '') {
            $this->queryBuilder = $queryBuilder;
        } else {
            $this->queryBuilder = '';
            $this->queryBuilder = $this->query();
        }

        return $this;
    }

    public function addDistinct($table, $field)
    {
        $this->queryBuilder->distinct($table . '.' . $field);

        return $this;
    }

    public function addOrderby($table, $field, $order)
    {
        $this->queryBuilder->orderBy($table . '.' . $field, $order);

        return $this;
    }

    public function getPerPageRecord($data = [])
    {
        $per_page = getConfig('per_page_record');
        if (!empty($data)) {
            $per_page = (isset($data['perPageRecord'])) ? $data['perPageRecord'] : $per_page;
        }

        return $per_page;
    }

    public function addPaging($page = 0, $per_page = 0)
    {
        /*All Records*/
        if (empty($per_page)) {
            return $this;
        }

        if (!is_numeric($page)) {
            exit('Not allowed non-numeric page number.');
        }

        if ($page > 0) {
            $limit = ($page - 1) * $per_page;
        } else {
            $limit = $page * $per_page;
        }
        $this->queryBuilder->skip($limit)->take($per_page);

        return $this;
    }

    public function addLastLoadedPaging($lastLoaded, $limit, $direction = 'desc')
    {
        if ($lastLoaded > 0) {
            if ($direction == 'desc') {
                $this->addFieldToFilter($this->table, $this->primaryKey, '<', $lastLoaded);
            } else {
                $this->addFieldToFilter($this->table, $this->primaryKey, '>', $lastLoaded);
            }
        }

        $this->queryBuilder->take($limit);

        return $this;
    }

    public function addLimit($limit)
    {
        if ($limit) {
            $this->queryBuilder->take($limit);
        }

        return $this;
    }

    public function addFieldToFilter($table, $column, $operator, $value = '')
    {
        switch ($operator) {

            case 'or':
                if (!is_array($value)) {
                    $this->queryBuilder->orWhere($table . '.' . $column, '=', $value);
                }
                break;
            case '=':
                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '=', $value);
                }
                break;

            case 'isnull':
                if (!is_array($value)) {
                    $this->queryBuilder->whereNull($table . '.' . $column);
                }
                break;
            case 'isnotnull':
                if (!is_array($value)) {
                    $this->queryBuilder->whereNotNull($table . '.' . $column);
                }
                break;
            case '!=':
                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '<>', $value);
                }
                break;

            case 'like':
                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, 'like', '%' . $value . '%');
                }
                break;

            case 'notlike':
                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, 'NOT LIKE', '%' . $value . '%');
                }
                break;

            case 'between':
                if (is_array($value)) {
                    if (count($value) > 0) {
                        $start_date = isset($value[0]) ? $value[0] : '';
                        $end_date = isset($value[1]) ? $value[1] : '';
                        if ($start_date != '' && $end_date != '') {
                            $endDateObj = Carbon\Carbon::parse($end_date);
                            $endDateObj = $endDateObj->addDays(1);
                            $end_date = $endDateObj->toDateTimeString();
                            $this->queryBuilder->where($table . '.' . $column, '>=', $start_date);
                            $this->queryBuilder->where($table . '.' . $column, '<=', $end_date);
                        }
                    }
                }
                break;
            case 'price_range':
                if (is_array($value)) {
                    if (count($value) > 0) {
                        $from_value = $value['from_value'];
                        $to_value = $value['to_value'];
                        if ($from_value != '') {
                            $this->queryBuilder->where($table . '.' . $column, '>=', $from_value);
                        }
                        if ($to_value != '') {
                            $this->queryBuilder->where($table . '.' . $column, '<=', $to_value);
                        }
                    }
                }
                break;
            case '>':

                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '>', $value);
                }
                break;
            case '>=':

                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '>=', $value);
                }
                break;

            case '<':

                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '<', $value);
                }
                break;
            case '<=':

                if (!is_array($value)) {
                    $this->queryBuilder->where($table . '.' . $column, '<=', $value);
                }
                break;
            case 'in':
                if (is_array($value)) {
                    $this->queryBuilder->whereIn($table . '.' . $column, $value);
                }
                break;
            case 'notin':
                if (is_array($value)) {
                    $this->queryBuilder->whereNotIn($table . '.' . $column, $value);
                }
                break;

            default:
        }

        return $this;
    }

    public function addSearch($search = '')
    {
        $search = trim($search);
        $searchKeyword = explode(' ', $search);
        $searchKeywordArray = [];
        if (count($searchKeyword) > 0) {
            foreach ($searchKeyword as $keyword) {
                $searchKeywordArray[] = trim($keyword);
            }
            array_unique($searchKeywordArray);
        }
        if (count($searchKeywordArray) > 0) {
            $this->queryBuilder->where(function ($query) use ($searchKeywordArray) {
                $i = 0;
                foreach ($searchKeywordArray as $keyword) { //first table
                    if ($i == 0) {
                        $query->where(function ($query) use ($keyword) {
                            $j = 0;
                            foreach ($this->searchableColumns as $column) {
                                if ($j == 0) {
                                    $query->where($this->table . '.' . $column, 'like', '%' . $keyword . '%');
                                } else {
                                    $query->orWhere($this->table . '.' . $column, 'like', '%' . $keyword . '%');
                                }
                                $j++;
                            }
                        });
                    } else {
                        $query->orWhere(function ($query) use ($keyword) {
                            $j = 0;
                            foreach ($this->searchableColumns as $column) {
                                if ($j == 0) {
                                    $query->where($this->table . '.' . $column, 'like', '%' . $keyword . '%');
                                } else {
                                    $query->orWhere($this->table . '.' . $column, 'like', '%' . $keyword . '%');
                                }
                                $j++;
                            }
                        });
                    }
                    $i++;
                }
                if (count($this->joinTables) > 0) {
                    foreach ($this->joinTables as $tableRow) {
                        if ($tableRow['searchable']) {
                            foreach ($searchKeywordArray as $keyword) {
                                if ($i == 0) {
                                    $query->where(function ($query) use ($keyword, $tableRow) {
                                        $j = 0;
                                        foreach ($tableRow['searchableColumns'] as $column) {
                                            if ($j == 0) {
                                                $query->where($tableRow['table'] . '.' . $column, 'like', '%' . $keyword . '%');
                                            } else {
                                                $query->orWhere($tableRow['table'] . '.' . $column, 'like', '%' . $keyword . '%');
                                            }
                                            $j++;
                                        }
                                    });
                                } else {
                                    $query->orWhere(function ($query) use ($keyword, $tableRow) {
                                        $j = 0;
                                        foreach ($tableRow['searchableColumns'] as $column) {
                                            if ($j == 0) {
                                                $query->where($tableRow['table'] . '.' . $column, 'like', '%' . $keyword . '%');
                                            } else {
                                                $query->orWhere($tableRow['table'] . '.' . $column, 'like', '%' . $keyword . '%');
                                            }
                                            $j++;
                                        }
                                    });
                                }
                                $i++;
                            }
                        }
                    }
                }
            });
        }

        return $this;
    }

    protected function filterList($data)
    {
        $data = $this->beforeFilterApply($data);
        if (!empty($data['filters'])) {
            foreach ($data['filters'] as $fid => $fval) {
                $table = (!empty($this->filter->fields[$fid]['table'])) ? $this->filter->fields[$fid]['table'] : $this->table;
                $operator = (!empty($this->filter->fields[$fid]['operator'])) ? $this->filter->fields[$fid]['operator'] : '=';

                if ($fid == 'created_from_date' || $fid == 'created_to_date') {
                    $fid = 'created_at';
                    if ($fid == 'created_from_date') {
                        $fval = $fval . ' 00:00:00';
                    } else {
                        $fval = $fval . ' 23:59:59';
                    }
                }
                $this->addFieldToFilter($table, $fid, $operator, $fval);
            }
        }
    }

    protected function getSelectedColumnForList()
    {
        return [$this->table . '.*'];
    }

    protected function addListJoins($data)
    {
    }

    protected function beforeFilterApply($data)
    {
        return $data;
    }

    protected function beforeLoadList($data)
    {
        return $data;
    }

    public function prepareList($data = [])
    {
        $this->setSelect();
        if (empty($data['sortBy']['value'])) {
            $data['sortBy']['value'] = $this->defaultSortColumn;
            $data['sortDirection']['value'] = 'desc';
        }

        $this->addListJoins($data);
        $this->filterList($data);
        $this->addOrderby($this->table, $data['sortBy']['value'], $data['sortDirection']['value']);
        $this->addDistinct($this->table, (!empty($data['distinct']) ? $data['distinct'] : $this->primaryKey));
    }

    public function list($data = [])
    {
        if ($data['needFilterToLoadData'] == false || !empty($data['filters'])) {
            $per_page = $this->getPerPageRecord($data);
            $page = isset($data['page']) ? $data['page'] : 1;
            $selectedColumns = $this->getSelectedColumnForList();
            $this->prepareList($data);
            $list = $this->addPaging($page, $per_page)->get($selectedColumns);

            return $this->beforeLoadList($list);
        }

        return [];
    }

    public function listTotalCount($data = [])
    {
        if ($data['needFilterToLoadData'] == false || !empty($data['filters'])) {
            $this->prepareList($data);
            $distinct = (!empty($data['distinct'])) ? $data['distinct'] : '';

            return $this->listCountForModels($this->table, $distinct);
        }

        return 0;
    }

    public function listCountForModels($table = '', $distinctCol = '')
    {
        $table = (!empty($table)) ? $table : $this->table;
        $distinct = (!empty($distinctCol) ? $distinctCol : $this->primaryKey);
        $selectedColumns = [DB::raw('count(DISTINCT ' . $table . '.' . $distinct . ') as total')];
        $totalRows = $this->get($selectedColumns)->first();

        return $totalRows['total'];
    }

    public function validateDataWithMessage($rules, $data, $messages = [])
    {

        $validator = '';
        $validationResult = [];
        $validationResult['success'] = false;
        $validationResult['message'] = [];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->passes()) {
            $validationResult['success'] = true;

            return $validationResult;
        }
        $errors = json_decode($validator->errors());
        $validationResult['success'] = false;
        $validationResult['message'] = $errors;

        return $validationResult;
    }

    public function validateDataWithRules($rules, $data)
    {
        $validator = '';
        $validationResult = [];
        $validationResult['success'] = false;
        $validationResult['message'] = [];
        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
            $validationResult['success'] = true;

            return $validationResult;
        }
        $errors = json_decode($validator->errors());
        $validationResult['success'] = false;
        $validationResult['message'] = $errors;

        return $validationResult;
    }

    public function reset()
    {
        $this->queryBuilder = '';
        $this->queryBuilder = $this->query();

        return $this;
    }

    public function get($selectColoumn = ['*'])
    {
        return $this->queryBuilder->get($selectColoumn);
    }

    public function deleteMultiple()
    {
        $data = $this->queryBuilder->get();
        if (!empty($data)) {
            foreach ($data as $del) {
                $del->delete();
            }
        }
    }

    public function formatSelectedColumns($fields)
    {
        if (!empty($fields)) {
            $selectColumns = [];
            foreach ($fields as $f) {
                $selectColumns[] = $this->table . '.' . $f;
            }
        } else {
            $selectColumns = [$this->table . '.*'];
        }

        return $selectColumns;
    }

    public function getRecordsCount()
    {
        $this->setSelect();
        $count = $this->listCountForModels();

        return $count;
    }

    public function loadModel($id, $fields = [])
    {

        $selectedColumns = [$this->table.'.*'];

        if (!empty($fields)) {
            $selectedColumns = [];
            foreach ($fields as $f) {
                $selectedColumns[] = $this->table . '.' . $f;
            }
        }

        $this->beforeLoad($id);
        $return = $this->setSelect()
            ->addFieldToFilter($this->table, $this->primaryKey, '=', $id)
            ->get($selectedColumns)
            ->first();

        return $this->afterLoad($id, $return);
    }

    public function findOneWithId($id)
    {
        return self::find($id);
    }
    public function findRelationData($columnName,$id)
    {
        return self::where($columnName,'=',$id)->get();
    }
    public function removeRelationData($columnName,$id)
    {
        return self::where($columnName,'=',$id)->delete();
    }


    public function findAll()
    {
        return self::all();
    }

    protected function beforeLoad($id)
    {
    }

    protected function afterLoad($id, $data)
    {
        return $data;
    }

    public function parentSaveRecord($data, $object = [])
    {
        $this->afterSave($data, $object);
    }

    protected function beforeSave($data = [])
    {
    }

    protected function afterSave($data, $object)
    {
    }

    public function formatedEntity($entity = '')
    {
        $entity = (!empty($entity)) ? $entity : $this->entity;

        return ucfirst(str_replace('_', ' ', $entity));
    }

    public function removed($id)
    {

        $this->beforeRemoved($id);
        $deleteObj = $this->loadModel($id);
        if (!empty($deleteObj)) {
            $deleteObj->delete();
            $this->afterRemoved($deleteObj);
            return ['status' => true, 'message' => $this->successfullyMsg(self::DELETE_FOR_MSG)];
        } else {
            return ['status' => false, 'message' => $this->unsuccessfullyMsg(self::DELETE_FOR_MSG)];
        }
    }

    public function removedNotInId($id = [])
    {
        $deleteObj = self::whereNotIn($this->primaryKey, $id)->delete();
        if (!empty($deleteObj)) {
            return ['success' => true, 'message' => $this->successfullyMsg(self::DELETE_FOR_MSG)];
        } else {
            return ['success' => false, 'message' => $this->unsuccessfullyMsg(self::DELETE_FOR_MSG)];
        }
    }

    protected function beforeRemoved($id)
    {
    }

    protected function afterRemoved($deleteObjData)
    {
    }

    public function fileToBase64($filePath, $fileType = 'image')
    {
        $type = pathinfo($filePath, PATHINFO_EXTENSION);
        $data = file_get_contents($filePath);
        $base64 = 'data:' . $fileType . '/' . $type . ';base64,' . base64_encode($data);

        return $base64;
    }

    public function getFilesBasePath($files_type = 'images')
    {
        $baseDir = $this->getFilesDirectory($files_type);
        $baseDir .= '/';

        return public_path($baseDir);
    }

    public function getFilesDirectory($files_type = 'images', $subDir = '')
    {
        return $this->_helper->getFilesDirectory($files_type, $subDir);
    }

    public function isValidBase64Image($base64)
    {
        $arr1 = explode('/', $base64);
        if (count($arr1) > 1) {
            if ($arr1[0] == 'data:image' || $arr1[0] == 'data:video') {
                $arr2 = explode(';', $arr1[1]);
                if (count($arr2) > 1) {
                    if (substr($arr2[1], 0, 7) == 'base64,') {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function storeFileFromBase64DataString($base64, $destinationPath, $fileName)
    {
        if ($base64 && $destinationPath && $fileName) {
            if (!$this->isValidBase64Image($base64)) {
                return '';
            }
            $extension = explode(';', explode('/', $base64)[1])[0];

            if ($extension) {
                $fileName = str_replace(' ', '-', strtolower(trim($fileName)));
                $fileName = preg_replace('/[^-a-z\d]/i', '', $fileName);
                $fileName .= '-' . uniqid() . '.' . $extension;
                $fileName = $this->_helper->formatFileName($fileName);
                $replace = substr($base64, 0, strpos($base64, ',') + 1);
                $file = str_replace($replace, '', $base64);
                $file = str_replace(' ', '+', $file);
                $file = base64_decode($file);
                $storagePath = $this->putFileToStorage($destinationPath, $file, $fileName);
                if ($storagePath) {
                    return $fileName;
                }
            }
        }

        return '';
    }

    public function setDisk()
    {
        if ($this->_helper->isLocalHost()) {
            $this->_disk = 'local';
        }
    }

    public function putFileToStorage($filePath, $file, $fileName = '', $fileType = 'base64', $permission = 'public')
    {
        $this->setDisk();
        $storagePath = '';
        if ($filePath && $file) {
            $isImageFile = $this->_helper->isImageFile($fileName);
            if ($isImageFile) {
                if ($fileName) {
                    $filePath .= '/' . $fileName;
                }
                $file = Image::make($file)->stream('webp', 70);
                $storagePath = Storage::disk($this->_disk)->put($filePath, $file, $permission);
            } else {
                if ($fileType == 'base64') {
                    if ($fileName) {
                        $filePath .= '/' . $fileName;
                    }
                    $storagePath = Storage::disk($this->_disk)->put($filePath, $file, $permission);
                } elseif ($fileType == 'binary') {
                    $storagePath = Storage::disk($this->_disk)->putFileAs($filePath, $file, $fileName, $permission);
                }
            }
        }
        return $storagePath;
    }

    public function removeFileFromStorage($filePath)
    {
        $this->setDisk();
        if ($filePath) {
            if (Storage::disk($this->_disk)->exists($filePath)) {
                try {
                    return Storage::disk($this->_disk)->delete($filePath);
                } catch (\Exception $e) {
                }
            }
        }

        return '';
    }

    public function getDisk()
    {
        return $this->_disk;
    }

    public function fileUploadFroalaEditor($file)
    {
        $path = $this->fileUploadDigitalOcen($file, self::FILES_DIR_NAME);
        $response = new \StdClass;
        $response->link = $this->getFileUrl($path);
        // Send response.
        return stripslashes(json_encode($response));
    }

    public function getFileUrl($imageName, $files_type = 'images', $subDir = '')
    {

        if (empty(trim($imageName))) {
            return $this->getPlaceholderForFile($files_type);
        }

        $this->setDisk();
        if ($imageName) {
            $filePath = $this->getFilesDirectory($files_type, $subDir);
            $storagePath = $filePath . '/' . $imageName;
            $storagePath = str_replace('//', '/', $storagePath);
            return asset('uploads/'.$storagePath);
//            return Storage::disk($this->_disk)->url($storagePath);
        }

        return '';
    }

    public function getPlaceholderForFile($files_type = 'images')
    {
        $return = '';
        if ($files_type == 'images') {
             $return = asset('assets/media/products/default.png');
        }

        return $return;
    }

    public function copyFile($sourceFile, $destiFile)
    {
        $this->setDisk();
        if ($sourceFile && $destiFile) {
            if (Storage::disk($this->_disk)->exists($sourceFile)) {
                Storage::disk($this->_disk)->copy($sourceFile, $destiFile);

                return true;
            }
        }

        return false;
    }

    public function moveFile($sourceFile, $destiFile)
    {
        $this->setDisk();
        if ($sourceFile && $destiFile) {
            if (Storage::disk($this->_disk)->exists($sourceFile)) {
                Storage::disk($this->_disk)->move($sourceFile, $destiFile);

                return true;
            }
        }

        return false;
    }

    public function getFileFromStorage($filePath)
    {
        $this->setDisk();
        if ($filePath) {
            if (Storage::disk($this->_disk)->exists($filePath)) {
                return Storage::disk($this->_disk)->get($filePath);
            }
        }

        return '';
    }

    public function cropSavedFile($sourceFile, $width, $height)
    {
        return true;
        $this->setDisk();
        if ($sourceFile && $width && $height) {
            $realPath = Storage::disk($this->_disk)->path($sourceFile);
            $imgFile = Image::make($realPath);
            $imgFile->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($realPath);

            return true;
        }

        return false;
    }

    public function shortString($string, $chars = 20)
    {
        return \Illuminate\Support\Str::limit($string, $chars);
    }

    public function displayDate($date)
    {
        return date('m/d/Y', strtotime($date));
    }


    public function displayTimeStamp($date)
    {
        return date('d/m/Y h:i A', strtotime($date));
    }

    public function chatTimeStamp($date)
    {
        return date('h:i A D M', strtotime($date));
    }

    public function currentTimeStamp()
    {
        return date('Y-m-d H:i:s');
    }

    public function toTimeStamp($time)
    {
        return date('Y-m-d H:i:s', $time);
    }
    public function timeFormat($time)
    {
        return Carbon::parse($time)->format('H:i A');
    }

    public function dateFormat($value)
    {

        if ($value != '' && $value != 'Invalid date') {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            return null;
        }
    }

    public function replacePlaceholders($text, $data)
    {
        $array_find = $array_value = [];
        foreach ($data as $key => $value) {
            $array_find[] = '%' . $key . '%';
            $array_value[] = $value;
        }

        return str_replace($array_find, $array_value, $text);
    }

    public function sendResetPasswordEmail($emailTo, $name, $resetUrl)
    {
        $data = ['name' => $name, 'resetUrl' => $resetUrl, 'heading' => 'PASSWORD RESET'];
        $mailObj = new \App\Models\Email\Email;
        $mailObj->send('reset-password', 'Password Reset', [$emailTo], $data, false);
    }

    public function getDateArrayFromRange($startDate, $endDate)
    {
        $dates = [];
        $ranges = CarbonPeriod::create($startDate, $endDate);
        foreach ($ranges as $date) {
            $key = $date->format('Y-m-d');
            $value = $date->format('l - F d, Y');
            $dates[$key] = $value;
        }

        return $dates;
    }

    protected function getQueries()
    {
        $addSlashes = str_replace('?', "'?'", $this->queryBuilder->toSql());

        return vsprintf(str_replace('?', '%s', $addSlashes), $this->queryBuilder->getBindings());
    }

    protected function getUserLocalTimezoneOffset()
    {
        return (!empty($_COOKIE['_ft_timezone'])) ? $_COOKIE['_ft_timezone'] : 0;
    }

    protected function isLocalTimezoneSet()
    {
        return (!empty($_COOKIE['_ft_timezone'])) ? true : false;
    }

    public function convertLocalTimeZoneDate($date)
    {
        $strtotime = Carbon\Carbon::parse($date)->subMinutes($this->getUserLocalTimezoneOffset())->toDateTimeString();

        return $strtotime;
    }

    public function changeDateToGlobalFormat($date)
    {
        $explode = explode('-', $date);

        return $explode[2] . '-' . $explode[0] . '-' . $explode[1];
    }

    public function changeDateGlobalToCommonFormat($date)
    {
        $explode = explode('-', $date);

        return $explode[1] . '-' . $explode[2] . '-' . $explode[0];
    }

    public function getExistsRecordByFields($fields)
    {
        $this->setSelect();
        foreach ($fields as $k => $v) {
            $this->addFieldToFilter($this->table, $k, '=', $v);
        }
        $record = $this->get()->first();

        return $record;
    }

    public function getSqlQuery()
    {
        $sql = Str::replaceArray('?', $this->queryBuilder->getBindings(), $this->queryBuilder->toSql());

        return $sql;
    }

    public function successfullyMsg($action = '')
    {
        $entityFormated = $this->formatedEntity();

        return $entityFormated . ' has been ' . $action . ' successfully.';
    }

    public function unsuccessfullyMsg($action = '')
    {
        $entityFormated = $this->formatedEntity();

        return $entityFormated . ' can not ' . $action . '.';
    }

    public function doesNotExitsMsg($action = '')
    {
        $entityFormated = $this->formatedEntity();

        return $entityFormated . ' doest not exits.';
    }

    public function generateUUID()
    {
        return Str::uuid()->toString();
    }

    public function generateSlug($string)
    {
        return Str::slug($string);
    }


    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function selectColomns($field)
    {
        $this->queryBuilder->select($field);
        return $this;
    }

    public function getOrderByFieldAndValue($columnsOrder, $columnsSearch, $fieldName, $orderByType = 'ASC', $optional = false)
    {
        $returnData = array();
        $returnData['columnsOrderField'] =  $fieldName;
        $returnData['columnsOrderType'] = $orderByType;
        if (!empty($columnsOrder)) {
            $columnsIndex = $columnsOrder[0]['column'];
            if ($columnsSearch[$columnsIndex]['orderable'] == 'true') {
                $returnData['columnsOrderField'] = $columnsSearch[$columnsIndex]['name'];
                $returnData['columnsOrderType'] = $columnsOrder[0]['dir'];
            }
        }

        return $returnData;
    }

    public function dataTableResponse($response)
    {
        return [
            'draw' => !empty($response->original['draw']) ? ($response->original['draw']) : 0,
            'recordsTotal' => (!empty($response->original['recordsTotal']) ? $response->original['recordsTotal'] : 0),
            'recordsFiltered' => (!empty($response->original['recordsFiltered']) ? $response->original['recordsFiltered'] : 0),
            'data' => !empty($response->original['data']) ? $response->original['data'] : [],
        ];
    }
    public function dataTableSearch()
    {
        $search_value = request()['search']['value'];
        $column = request()['columns'];
        if (!empty($search_value)) {
            foreach ($column as $value) {
                if ($value['searchable'] == 'true') {
                    $this->queryBuilder->orWhere($value['data'], "LIKE", '%' . trim($search_value) . '%');
                }
            }
        }
    }

}
