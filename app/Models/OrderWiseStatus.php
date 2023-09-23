<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWiseStatus extends Model
{
    use HasFactory;
    protected $table="order_wise_status";
    protected $primaryKey="order_wise_status_id";
    protected $fillable = ['order_id','status','date','description','eventType'];

    protected $dates = [
        'date',
    ];
}
