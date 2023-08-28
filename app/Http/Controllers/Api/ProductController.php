<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FrontendCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getCategory(){
        $products = FrontendCategory::with(['products' => function ($query) {
            $query->orderBy('product_name', 'ASC');
        },'products.productImages'])->get();
        return response()->json(['data'=>$products,'msg'=>'category fetch successfully','status'=>true],200);
    }

    public function getProductDetails($productId){
        $productDetails = Product::find($productId);
        if ($productDetails){
            return response()->json(['data'=>$productDetails,'msg'=>'product details fetch successfully','status'=>true],200);
        }
        return response()->json(['data'=>$productDetails,'msg'=>'product id does not exits !','status'=>false],200);
    }

    public function getProduct(){
        $products = Product::all();
        return response()->json(['data'=>$products,'msg'=>'product fetch successfully','status'=>true],200);
    }

}
