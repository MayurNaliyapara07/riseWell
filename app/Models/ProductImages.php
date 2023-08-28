<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends BaseModel
{
    use HasFactory;
    protected $table="product_images";
    protected $primaryKey="product_images_id";
    protected $fillable=['product_id','image'];
}
