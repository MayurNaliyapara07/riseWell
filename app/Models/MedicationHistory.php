<?php

namespace App\Models;

use App\Helpers\MedicationHistory\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MedicationHistory extends BaseModel
{
    use HasFactory;
    protected $table="medication_history";
    protected $primaryKey="medication_history_id";
    protected $fillable=[
        'created_by',
        'patients_id',
        'medication_name',
        'description',
        'dosage',
        'qty'
    ];

    protected $entity = 'medication_history';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function saveMedicationHistory($data,$patientsId){

        $patientsId=!empty($patientsId)?$patientsId:'';
        foreach ($data as $value){
            $medicationName = !empty($value['medication_name'])?$value['medication_name']:'';
            $description = !empty($value['description'])?$value['description']:'';
            $dosage = !empty($value['dosage'])?$value['dosage']:'';
            $qty = !empty($value['qty'])?$value['qty']:'';
            $res = self::create(
                [
                    'patients_id' => $patientsId,
                    'created_by' => Auth::user()->id,
                    'medication_name' => $medicationName,
                    'description' => $description,
                    'dosage' => $dosage,
                    'qty' => $qty,
                ]
            );
        }
        $response['success'] = true;
        $response['medication_history_id'] = $res['medication_history_id'];
        return $response;
    }
}
