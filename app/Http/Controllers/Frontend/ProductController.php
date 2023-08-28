<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Common\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new Product();
    }

    public function index()
    {
        return view('frontend.product.index')->with('AJAX_PATH', 'get-product');;
    }

    public function getProduct(){
        return $this->_model->getProductList();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productType = $this->_model->getProductType();
        $stripeProductType = $this->_model->getStripeProductType();
        return view('frontend.product.create')->with(compact('productType','stripeProductType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->_model->createRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->_model->loadModel($id);
        $getCategoryName = $this->_model->getCategoryName($product->category_id);
        $productType = $this->_model->getProductType();
        $stripeProductType = $this->_model->getStripeProductType();
        return view('frontend.product.create')->with(compact('product','getCategoryName','productType','stripeProductType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge(['product_id' => $id]);
        return $this->_model->createRecord($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->_model->remove($id);
    }

    public function productChangeStatus($id)
    {
        $product = $this->_model->loadModel($id);
        if (!empty($product->status) && $product->status == 1) {
            $product->update(['status' => '0']);
            return $this->webResponse('Product has been in-active successfully.');
        } else {
            $product->update(['status' => '1']);
            return $this->webResponse('Product has been active successfully.');
        }
    }
}
