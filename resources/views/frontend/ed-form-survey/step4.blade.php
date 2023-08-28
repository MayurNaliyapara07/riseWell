@extends('layouts.frontend')
@section('content')
    <section>
        <div class="form-area-section">
            <div class="container">
                <div class="step-list">
                    <ul class="step">
                       <li class="active"><div class="circle"></div>Step 1<span>Basic Questions</span></li>
                        <li class="active"><div class="circle"></div>Step 2<span>Medical History</span></li>
                        <li class="active"><div class="circle"></div>Step 3<span>Sexual Health</span></li>
                        <li class="active"><div class="circle"></div>Step 4<span>Checkout</span></li>
                    </ul>
                </div>
                <div class="right-form-area">
                    <h1>Checkout</h1>
                    <form id="ed_flow" action="{{route('save-step-four')}}" enctype="multipart/form-data" class="ajax-form">
                        @csrf
                        <?php
                            $productPrice =   !empty($product)?$product->price:'0';
                            $processingFees =   !empty($product)?$product->processing_fees:'0';
                            $shippingCost =   !empty($product)?$product->shipping_cost:'0';
                            $discountCost =   !empty($product)?$product->discount:'0';
                            $subTotal = $productPrice + $shippingCost + $processingFees;
                            $discountPrice = $subTotal - $discountCost;
                        ?>
                    <div class="form-block">
                        <h2>First Month Supply</h2>
                        <div class="sub">{{!empty($product)?$product->product_name:''}}</div>
                        <div class="d-flex">
                            <div class="summery-area">
                                <ul>
                                    <li>Online Doctor Consultation <del>$ 10.00</del></li>
                                    <li>Month Supply <span>$ {{$productPrice}}</span></li>
                                    <li>Processing Fees <span>$ {{$processingFees}}</span></li>
                                    <li>Shipping Cost <span>$ {{$shippingCost}}</span></li>
                                    <li class="subtotal">Subtotal<span>$ {{$subTotal}}</span></li>
                                    <li class="discount">One Time Discount<span>-$ {{$discountCost}}</span></li>
                                    <li class="total">Total<span>$ {{$discountPrice}}</span></li>
                                </ul>
                            </div>
                            <div class="purchase-block">
                                <h3>What Comes With Your RiseWell Purchase?</h3>
                                <ul>
                                    <li>Free first-class shipping</li>
                                    <li>Medication prescription valid 12 months</li>
                                    <li>Monthly refills of 30 pills at less than $3 a pill</li>
                                    <li>100% satisfaction guarantee</li>
                                    <li>Adjustable monthly refills</li>
                                    <li>Pause anytime</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                        <input type="hidden" class="form-control"
                               name="patients_id"
                               value="{{!empty($patient)?$patient->patients_id:old('patients_id')}}">
                        <div class="form-block inner-info">
                        <h2>Legal Name</h2>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Legal First Name</label>
                                    <input type="text" class="form-control"
                                           placeholder="Please enter your first name"
                                           id="first_name"
                                           value="{{!empty($patient)?$patient->first_name:old('first_name')}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="">Legal Last Name</label>
                                    <input type="text" class="form-control"
                                           placeholder="Please enter your last name"
                                           id="last_name"
                                           value="{{!empty($patient)?$patient->last_name:old('last_name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Shipping Information</h2>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 1</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Please enter your address 1" name="shipping_address_1" value="{{!empty($patient)?$patient->shipping_address_1:old('shipping_address_1')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 2</label>
                                            <input type="text" class="form-control " placeholder="Please enter your address 2" name="shipping_address_2" value="{{!empty($patient)?$patient->shipping_address_2:old('shipping_address_2')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" class="form-control" placeholder="Please enter your city" name="shipping_city_name" value="{{!empty($patient)?$patient->shipping_city_name:old('shipping_city_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <select class="form-control" id="shipping_state_id" name="shipping_state_id">
                                                <option value="" selected>Select State</option>
                                                @if($state)
                                                    @foreach($state as $value)
                                                        <option value="{{$value->state_id}}" {{ !empty($patient) && $patient->shipping_state_id == $value->state_id? 'selected' : ''}}>{{$value->state_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Zip</label>
                                            <input type="text" class="form-control" placeholder="Zipcode" name="shipping_zipcode" value="{{!empty($patient)?$patient->shipping_zip:old('shipping_zip')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 shipping-check">
                                        <input type="checkbox" name="billing_same_as_shipping" id="checkbox8" class="css-checkbox" {{ !empty($patient) && $patient->billing_same_as_shipping ==  1 ? 'checked' : ''}}>
                                        <label for="checkbox8" class="css-label">Billing Address is the same as shipping</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h2>Billing  Information</h2>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 1</label>
                                            <input type="text" class="form-control required"
                                                   data-msg-required="Address is required" placeholder="Please enter your address 1" name="billing_address_1" value="{{!empty($patient)?$patient->billing_address_1:old('billing_address_1')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Address 2</label>
                                            <input type="text" class="form-control" placeholder="Please enter your address 2" name="billing_address_2" value="{{!empty($patient)?$patient->billing_address_2:old('billing_address_2')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" class="form-control" placeholder="Please enter your city" name="billing_city_name" value="{{!empty($patient)?$patient->billing_city_name:old('billing_city_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <select class="form-control" id="billing_state_id" name="billing_state_id">
                                                <option value="" selected>Select State</option>
                                                @if($state)
                                                    @foreach($state as $value)
                                                        <option value="{{$value->state_id}}"  {{ !empty($patient) && $patient->billing_state_id == $value->state_id? 'selected' : ''}}>{{$value->state_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="">Zip</label>
                                            <input type="text" class="form-control" placeholder="Zipcode" name="billing_zipcode" value="{{!empty($patient)?$patient->billing_zip:old('billing_zip')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-block inner-info">
                                <a href="{{route('step3')}}" class="btn-back">Back</a>
                                <button type="submit" class="btn-continue">Checkout</button>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $( document ).ready(function() {
            var firstName = localStorage.getItem("firstName");
            var lastName = localStorage.getItem("lastName");
            $('#first_name').val(firstName);
            $('#last_name').val(lastName);
        });
    </script>
@endpush
