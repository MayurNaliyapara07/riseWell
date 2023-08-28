<?php

namespace App\Models;

use App\Helpers\PatientsLabReport\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PatientsLabReport extends BaseModel
{
    use HasFactory;
    protected $table="patients_lab_report";
    protected $primaryKey="patients_lab_report_id";
    protected $fillable=['created_by','patients_id','category_id','value','score'];

    protected $entity = 'patients_lab_report';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function saveLabReportHistory($data,$patientsId){
        $patientsId=!empty($patientsId)?$patientsId:'';
        foreach ($data as $value){
            $res = self::create(
                [
                    'patients_id' => $patientsId,
                    'category_id' =>!empty($value['category_id'])?$value['category_id']:'',
                    'value' => !empty($value['value'])?$value['value']:'',
                    'score' => !empty($value['score'])?$value['score']:'',
                    'created_by' => Auth::user()->id,
                ]
            );
        }
        $response['success'] = true;
        $response['patients_lab_report_id'] = $res['patients_lab_report_id'];
        return $response;
    }

    public function joinCategory(){
        $categoryObj = new Category();
        $categoryTable = $categoryObj->getTable();
        $this->queryBuilder->leftJoin($categoryTable,function($join) use($categoryTable){
            $join->on($this->table.'.category_id','=',$categoryTable.'.category_id');
        });
        return $this;
    }
    public function getLabReportHistroy($patientsId){
        $categoryObj = new Category();
        $categoryTable = $categoryObj->getTable();
        $selectedColumns=array($this->table.'.*',$categoryTable.'.category_name');
         $result = $this->setSelect()
            ->joinCategory()
            ->addFieldToFilter($this->table, 'patients_id', '=',$patientsId)
            ->get($selectedColumns);
        return $result;
    }
}
