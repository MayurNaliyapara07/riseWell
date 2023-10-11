<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    use HasFactory;
    protected $table="form_builder";
    protected $primaryKey="form_builder_id";
    protected $fillable = [];
    public $casts = [
        'form_data'=>'object'
    ];

}
