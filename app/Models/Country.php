<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends BaseModel
{
    use HasFactory;
    protected $table='country';
    protected $primaryKey='country_id';
    protected $fillable=['country_name','code','phonecode'];

}
