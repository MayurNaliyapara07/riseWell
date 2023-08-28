<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends BaseModel
{

    protected $table='state';
    protected $primaryKey='state_id';
    protected $fillable=['state_name','country_id'];
    protected $entity = 'state';
    public $filter;
    protected $_helper;

    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->syncOriginal();
        $this->fill($attributes);
    }

    public function getStateList()
    {
        $selectColumns = [$this->table . '.state_id', $this->table . '.state_name'];
        $state = $this->setSelect()
            ->addFieldToFilter($this->table,'country_id','=',231)
            ->addOrderby($this->table, 'state_name', 'asc')
            ->get($selectColumns);
        return $state;
    }

}
