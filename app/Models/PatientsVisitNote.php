<?php

namespace App\Models;

use App\Helpers\PatientsVisitNote\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientsVisitNote extends BaseModel
{
    use HasFactory;
    protected $table="patients_visit_note";
    protected $primaryKey="patients_visit_note_id";
    protected $fillable=['icd_code','visit_note','patients_id','created_by'];
    protected $entity = 'patients_visit_note';

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }
}
