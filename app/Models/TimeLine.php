<?php

namespace App\Models;

use App\Helpers\Timeline\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeLine extends BaseModel
{
    use HasFactory;
    protected $table="timeline";
    protected $primaryKey="timeline_id";
    protected $fillable=['patients_id','notes','created_id','type'];

    protected $entity = 'timeline';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }
}
