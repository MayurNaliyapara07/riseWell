@inject('baseHelper','App\Helpers\Frontend\Helper')
@extends('layouts.frontend')
@section('content')
    <?php

    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($patient->country_code)?$patient->country_code:$default_country_phonecode;
    $phoneNo = isset($patient->phone_no) ? "+" . $phoneCode . $patient->phone_no : '';

    ?>
    <!--get-started-->
    <section>
        <div class="trt-section">
            <div class="container">
                <ul class="nav trt-tab" id="myTab" role="tablist">
                    <li><a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true"><div class="circle">1</div>Personal Information</a></li>
                    <li><a class="nav-link " id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false"><div class="circle">2</div>Symptom Status</a></li>
                    <li><a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" role="tab" aria-controls="step3" aria-selected="false"><div class="circle">3</div>Lifestyle & Treatment</a></li>
                    <li><a class="nav-link" id="step4-tab" data-toggle="tab" href="#step4" role="tab" aria-controls="step4" aria-selected="false"><div class="circle">4</div>Symptom Assessment</a></li>
                    <li><a class="nav-link" id="step5-tab" data-toggle="tab" href="#step5" role="tab" aria-controls="step5" aria-selected="false"><div class="circle">5</div>Shipping & Billing </a></li>
                    <li><a class="nav-link" id="step6-tab" data-toggle="tab" href="#step6" role="tab" aria-controls="step6" aria-selected="false"><div class="circle">6</div>Follow Up</a></li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                        <h1>Personal Information</h1>
                        <form action="{{route('save-trt-step-one-refill')}}" method="post" enctype="multipart/form-data"
                              class="ajax-form">
                            @csrf
                            <input type="hidden" name="patients_id" value="{{!empty($patient->patients_id)?$patient->patients_id:''}}">
                            <input type="hidden" name="product_id" value="{{!empty($patient->product_id)?$patient->product_id:''}}">
                            <input type="hidden" name="member_id" value="{{!empty($patient->member_id)?$patient->member_id:''}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">legal First Name</label>
                                        <input type="text" class="form-control"
                                               placeholder="Please enter your legal first name" name="first_name"
                                               @php if(!empty($patient->first_name)) echo 'readonly' @endphp
                                               value="{{!empty($patient)?$patient->first_name:old('first_name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">legal Last Name</label>
                                        <input type="text" class="form-control"
                                               placeholder="Please enter your legal first name" name="last_name"
                                               @php if(!empty($patient->last_name)) echo 'readonly' @endphp
                                               value="{{!empty($patient)?$patient->last_name:old('last_name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Email Address</label>
                                        <input type="text" class="form-control"
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
                                        <label for="">Birthdate</label>
                                        <input type="date" class="form-control" placeholder="" name="dob"
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
                                        <input type="text" class="form-control required" placeholder="Please enter your address"
                                               data-msg-required="Billing Address is required"
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
                                        <input type="text" class="form-control required" placeholder="Please enter your city"
                                               name="billing_city_name"
                                               data-msg-required="Billing City is required"
                                               value="{{!empty($patient) ? $patient->billing_city_name : old('billing_city_name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">State</label>
                                        <select name="billing_state_id" class="form-control required" id=""
                                                data-msg-required="Billing state is required">
                                            <option value="">Select State</option>
                                            @if($state)
                                                @foreach($state as $value)
                                                    <option value="{{$value['state_id']}}" {{ !empty($patient) && $patient->billing_state_id == $value['state_id']? 'selected' : ''}}>{{$value['state_name']}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Zip Code</label>
                                        <input type="text" class="form-control required" placeholder="Please enter your zip code"
                                               name="billing_zipcode"
                                               data-msg-required="Billing Zipcode is required"
                                               value="{{!empty($patient) ? $patient->billing_zip : old('billing_zip')}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="shipping-check">
                                        <input type="checkbox" name="billing_same_as_shipping" id="checkbox8" {{ !empty($patient->same_shipping_as_billing) && $patient->same_shipping_as_billing == 1 ? 'checked' : ''}}  class="css-checkbox">
                                        <label for="checkbox8" class="css-label">Billing Address is the same as
                                            shipping</label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-area">
                                <button type="submit" class="btn-continue">Continue</button>
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
