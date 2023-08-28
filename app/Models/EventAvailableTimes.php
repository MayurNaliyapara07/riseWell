<?php

namespace App\Models;

use App\Helpers\EventAvailableTimes\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAvailableTimes extends BaseModel
{
    use HasFactory;
    protected $table="event_available_times";
    protected $primaryKey="event_available_times_id";
    protected $fillable=['day','start_time','end_time','event_id'];
    protected $entity = 'event_available_times';
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
