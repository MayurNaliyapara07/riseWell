@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php

    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($patient->country_code) ? $patient->country_code : $default_country_phonecode;
    $phoneNo = isset($patient->phone_no) ? "+" . $phoneCode . $patient->phone_no : '';

    ?>
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
                                    <input type="hidden" name="product_request" value="1">
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
                                                <input type="hidden" id="country_code" name="country_code"
                                                       value="{{ !empty($patient->country_code) ? $patient->country_code:$default_country_phonecode  }}">
                                                <input type="text" class="form-control required"
                                                       data-msg-required="Phone No is required" id="phone_no"
                                                       placeholder="Please enter your cell phone no" name="phone_no"
                                                       @php if(!empty($patient->phone_no)) echo 'readonly' @endphp
                                                       value="{{!empty($patient)?$patient->phone_no:old('phone_no')}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">DOB</label>
                                                <input type="date" class="form-control required" placeholder=""
                                                       name="dob"
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
                                                <input type="text" class="form-control"
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
                                        {{--  <div class="col-lg-12 col-md-12">
                                            <div class="shipping-check">
                                                <input type="checkbox" name="billing_same_as_shipping" id="checkbox8"
                                                       {{ !empty($patient) && $patient->billing_same_as_shipping == 1 ? 'checked' : ''}}  class="css-checkbox">
                                                <label for="checkbox8" class="css-label">Billing Address is the same as
                                                    shipping</label>
                                            </div>
                                        </div>  --}}
                                        <div class="col-lg-12 col-md-12">
                                            <div class="shipping-check">
                                                <input type="checkbox" id="terms" name="terms" class="css-checkbox required" data-msg-required="Please accept Privacy Policy & Terms">
                                                <label for="terms" class="css-label">Click here to consent to
                                                    <a href="{{$baseHelper->getPrivacyPolicyUrl()}}">Privacy Policy</a>
                                                    and
                                                    <a href="{{$baseHelper->getTermsAndConditionsUrl()}}">Terms &
                                                        Conditions</a>.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="shipping-check">
                                                <input type="checkbox" id="consent_to_treat" name="consent_to_treat" class="css-checkbox required" data-msg-required="Please accept Consent to treat">
                                                <label for="consent_to_treat" class="css-label">Click here to accept the
                                                    <a href="{{$baseHelper->getConsentToTreatUrl()}}">Consent to
                                                        Treat.</a>
                                                </label>

                                            </div>
                                        </div>


                                        <div class="btn-area">
                                            <button type="submit" class="btn-continue">Continue</button>
                                        </div>


                                    </div>

                                </div>
                                <div class="summary-box">
                                    <h3>Order Summary</h3>
                                    <div class="product-img">
                                        <img src="{{asset('assets/frontend/images/testKit.png')}}" alt="testKit">
                                    </div>
                                    <div class="product-name">Hormone Test Kit</div>
                                    <ul class="point">
                                        <li><i class="fas fa-check"></i>Easy At-Home Testosterone Cream</li>
                                        <li><i class="fas fa-check"></i>Treatment Plan</li>
                                        <li><i class="fas fa-check"></i>Online Provider Consult</li>
                                    </ul>
                                    <ul class="totalprice">
                                        <?php
                                            $product = \Illuminate\Support\Facades\DB::table('product')->where('product_id','=',11)->first();
                                            ?>
                                        <li>Price :<span>${{$product->price}}</span></li>
                                        <li>Shipping Cost :<span>${{$product->shipping_cost}}</span></li>
                                        <li>Processing Fees :<span>${{$product->processing_fees}}</span></li>
                                        <li>Discount :<span>${{$product->discount}}</span></li>
                                        <li class="total">Total
                                            :<span>${{($product->price+$product->shipping_cost+$product->processing_fees) - $product->discount}}</span>
                                        </li>
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
@push('scripts')
    <script>
        var isPhoneNoValid = false;
        var input = document.querySelector("#phone_no");
        const iti = window.intlTelInput(input, {
            allowExtensions: true,
            formatOnDisplay: true,
            allowFormat: true,
            autoHideDialCode: true,
            placeholderNumberType: "MOBILE",
            preventInvalidNumbers: true,
            separateDialCode: true,
            initialCountry: "{{$default_country_code}}",
        });
        input.addEventListener('countrychange', () => {
            $('#country_code').val(iti.getSelectedCountryData().dialCode)
        });
        @if(isset($phoneNo))
        iti.setNumber('{{$phoneNo}}');
        @endif
    </script>
@endpush
