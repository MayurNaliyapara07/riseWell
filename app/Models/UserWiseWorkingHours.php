<?php

namespace App\Models;


use App\Helpers\UserWiseWorkingHours\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserWiseWorkingHours extends BaseModel
{
    use HasFactory;
    protected $table="user_wise_working_hours";
    protected $primaryKey="user_wise_working_hours_id";
    protected $fillable=['user_id','day','start_time','end_time','time_slot','is_booked'];

    protected $entity = 'user_wise_working_hours';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
        $this->_helper = new Helper();
    }

    public function getAvailableTimesSlot($providerId,$dayName){

        $return = $this->setSelect()
            ->addFieldToFilter($this->table, 'user_id', '=', $providerId)
            ->addFieldToFilter($this->table, 'day', '=', $dayName)
            ->addFieldToFilter($this->table, 'is_booked', '=', false)
            ->get();

        return $return;
    }
}
