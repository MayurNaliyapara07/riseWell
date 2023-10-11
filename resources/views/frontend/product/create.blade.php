
@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Product',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'product.index'
        ])
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <form action="{{(isset($product))?route('product.update',$product->product_id):route('product.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($product))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="card-body">
                                    <input type="hidden" name="stripe_plan" id="stripe_plan" autocomplete="off"
                                           class="form-control"
                                           value="{{isset($product)?$product->stripe_plan:old('stripe_plan')}}">

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Image<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ !empty($product->image)?$product->getFileUrl($product->image):asset('assets/media/products/default.png') }}')"></div>
                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="image"
                                                           accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="image"/>
                                                </label>
                                                <span
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="cancel" data-toggle="tooltip"
                                                    title="Cancel avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                            </div>
                                            <span
                                                class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Category<span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <select class="form-control category-select2" id="categorySelect2"
                                                    name="category_id" style="width: 100%">
                                                @if(!empty($product))
                                                    <option value="{{(isset($product))?$product->category_id:(old('category_id')?old('category_id'):0)}}">
                                                        {{ isset($getCategoryName->category_name)?$getCategoryName->category_name:''}}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Product Name<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="product_name" id="product_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Product Name" data-msg-required="Product Name is required"
                                                   value="{{isset($product)?$product->product_name:old('product_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Product Type<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <select class="form-control"
                                                    name="product_type" style="width: 100%">
                                                <option value="">Select Product Type</option>
                                                @if($productType)
                                                    @foreach($productType as $type)
                                                        <option value="{{$type['value']}}" {{(isset($product)&& $product->product_type==$type['value'])?'selected':old('product_type')}}>{{$type['label']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    @if(!empty($product->type))
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label ">Product Stripe Type<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <select class="form-control"
                                                        name="type" style="width: 100%">
                                                    <option value="">Select Product Stripe Type</option>
                                                    @if($stripeProductType)
                                                        @foreach($stripeProductType as $type)
                                                            <option value="{{$type['value']}}" @if(!empty($product->type)) disabled @endif {{(isset($product)&& $product->type==$type['value'])?'selected':old('type')}} >{{$type['label']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label ">Product Stripe Type<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <select class="form-control required"  data-msg-required="Product Stripe Type is required"
                                                        name="type" style="width: 100%">
                                                    <option value="">Select Product Stripe Type</option>
                                                    @if($stripeProductType)
                                                        @foreach($stripeProductType as $type)
                                                            <option value="{{$type['value']}}" @if(!empty($product->type)) disabled @endif {{(isset($product)&& $product->type==$type['value'])?'selected':old('type')}} >{{$type['label']}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">SKU<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="sku" id="sku" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="SKU" data-msg-required="Product SKU is required"
                                                   value="{{isset($product)?$product->sku:old('sku')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Price<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="price" id="price" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Price" data-msg-required="Price is required"
                                                   value="{{isset($product)?$product->price:old('price')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Discount<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="discount" id="discount" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Discount"
                                                   value="{{isset($product)?$product->discount:old('discount')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Shipping Cost<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="shipping_cost" id="shipping_cost" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Shipping Cost"
                                                   value="{{isset($product)?$product->shipping_cost:old('shipping_cost')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Processing Fees<span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="processing_fees" id="processing_fees" autocomplete="off"
                                                   class="form-control"
                                                   placeholder="Processing Fees"
                                                   value="{{isset($product)?$product->processing_fees:old('processing_fees')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Membership Subscription<span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <input type="number" step="any" name="membership_subscription" id="membership_subscription" autocomplete="off"
                                                   class="form-control"
                                                   placeholder=""
                                                   value="{{isset($product)?$product->membership_subscription:old('membership_subscription')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Benifit<span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <textarea type="text" name="benifit" id="benifit" autocomplete="off"
                                                      class="form-control summernote"
                                                      rows="3"
                                                      placeholder=""
                                            >{{isset($product)?$product->benifit:old('benifit')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Sort Description<span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <textarea type="text" name="sort_description" id="sort_description" autocomplete="off"
                                                      class="form-control summernote"
                                                      rows="3"
                                                      placeholder=""
                                            >{{isset($product)?$product->sort_description:old('sort_description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Long Description<span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <textarea type="text" name="long_description" id="long_description" autocomplete="off"
                                                      class="form-control summernote"
                                                      rows="3"
                                                      placeholder=""
                                            >{{isset($product)?$product->long_description:old('long_description')}}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <button id="form_submit" class="btn btn-primary mr-2"><i
                                                    class="fas fa-save"></i>Save
                                        </button>
                                        <button type="reset" class="btn btn-danger"><i
                                                    class="fas fa-times"></i>Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script>
        $('.summernote').summernote({
            height: 150
        });
    </script>
    <script>

        $(".category-select2").select2({
            placeholder:"Select Category",
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('category-list')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                    };
                }, processResults: function (response) {
                    return {results: response};
                }, cache: true
            }
        });
    </script>
@endpush


