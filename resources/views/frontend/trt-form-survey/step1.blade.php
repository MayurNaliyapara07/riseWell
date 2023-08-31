@extends('layouts.frontend')
@section('content')
    <section>
        <div class="trt-section">
            <div class="container">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                        <form action="{{route('save-trt-step-one')}}" method="post" enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <div class="main-align-top">
                                <div class="detail-area">
                                    <h1>Personal Information</h1>
                                    <input type="hidden" name="trt_refill" value="1">
                                    <input type="hidden" name="member_id" value="{{!empty($memberId)?$memberId:''}}">
                                    <input type="hidden" name="product_id" value="{{!empty($productId)?$productId:''}}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">legal First Name</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="legal First Name is required"
                                                       placeholder="Please enter your legal first name"
                                                       name="first_name"
                                                       @php if(!empty($patient->first_name)) echo 'readonly' @endphp
                                                       value="{{!empty($patient)?$patient->first_name:old('first_name')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">legal Last Name</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="legal Last Name is required"
                                                       placeholder="Please enter your legal first name" name="last_name"
                                                       @php if(!empty($patient->last_name)) echo 'readonly' @endphp
                                                       value="{{!empty($patient)?$patient->last_name:old('last_name')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Email Address</label>
                                                <input type="text" class="form-control required"
                                                       data-rule-email="true"
                                                       data-msg-required="Email Address is required"
                                                       placeholder="Please enter your email address" name="email"
                                                       @php if(!empty($patient->email)) echo 'readonly' @endphp
                                                       value="{{!empty($patient)?$patient->email:old('email')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Cell Phone Number</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Phone No is required"
                                                       placeholder="Please enter your cell phone no" name="phone_no"
                                                       @php if(!empty($patient->phone_no)) echo 'readonly' @endphp
                                                       value="{{!empty($patient)?$patient->phone_no:old('phone_no')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">DOB</label>
                                                <input type="date" class="form-control required" placeholder="" name="dob"
                                                       data-msg-required="DOB is required"
                                                       @php if(!empty($patient->dob)) echo 'readonly' @endphp
                                                       value="{{!empty($patient) ? $patient->dob : old('dob')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <h2>Shipping Information</h2>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Billing Address is required"
                                                       placeholder="Please enter your address"
                                                       name="billing_address_1"
                                                       value="{{!empty($patient) ? $patient->billing_address_1 : old('billing_address_1')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">APT/Suite #</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="APT/Suite is required"
                                                       placeholder="Please enter your apt/suite" name="apt"
                                                       value="{{!empty($patient) ? $patient->apt : old('apt')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">City</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Billing City is required"
                                                       placeholder="Please enter your city"
                                                       name="billing_city_name"
                                                       value="{{!empty($patient) ? $patient->billing_city_name : old('billing_city_name')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="">State</label>
                                                <select name="billing_state_id" class="form-control required" id=""
                                                        data-msg-required="Billing State is required">
                                                    <option value="">Select State</option>
                                                    @if($state)
                                                        @foreach($state as $value)
                                                            <option
                                                                value="{{$value['state_id']}}" {{ !empty($patient) && $patient->billing_state_id == $value['state_id']? 'selected' : ''}}>{{$value['state_name']}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="">Zip Code</label>
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Billing Zip code is required"
                                                       placeholder="Zip code"
                                                       name="billing_zipcode"
                                                       value="{{!empty($patient) ? $patient->billing_zip : old('billing_zip')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="shipping-check">
                                                <input type="checkbox" name="billing_same_as_shipping" id="checkbox8"
                                                       {{ !empty($patient) && $patient->billing_same_as_shipping == 1 ? 'checked' : ''}}  class="css-checkbox">
                                                <label for="checkbox8" class="css-label">Billing Address is the same as
                                                    shipping</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-area">
                                        <button type="submit" class="btn-continue">Continue</button>
                                    </div>
                                </div>
                                <div class="summary-box">
                                    <h3>Order Summary</h3>
                                    <div class="product-img">
                                        <img src="{{!empty($productDetails->image)?asset('uploads/images/product/'.$productDetails->image):asset('assets/media/products/default.png')}}" alt="">
                                    </div>
                                    <div class="product-name">Hormone Test Kit</div>
                                    <ul class="point">
                                        <li><i class="fas fa-check"></i>Easy At-Home Testosterone Cream</li>
                                        <li><i class="fas fa-check"></i>Treatment Plan</li>
                                        <li><i class="fas fa-check"></i>Online Provider Consult</li>
                                    </ul>
                                    <ul class="totalprice">
                                        <li>Price :<span>${{$productDetails->price}}</span></li>
                                        <li>Shipping Cost :<span>${{$productDetails->shipping_cost}}</span></li>
                                        <li>Processing Fees :<span>${{$productDetails->processing_fees}}</span></li>
                                        <li>Discount :<span>${{$productDetails->discount}}</span></li>
                                        <li class="total">Total :<span>${{($productDetails->price+$productDetails->shipping_cost+$productDetails->processing_fees) - $productDetails->discount}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
