@inject('baseHelper','App\Helpers\User\Helper')
@extends('layouts.app')
@section('content')
    <?php

    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($user->country_code)?$user->country_code:$default_country_phonecode;
    $phoneNo = isset($user->phone_no) ? "+" . $phoneCode . $user->phone_no : '';

    ?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'User',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'user.index'
        ])
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <form action="{{(isset($user))?route('user.update',$user->id):route('user.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="card-body">


                                    <input type="hidden" name="user_type"
                                           value="{{!empty($user)?$user->user_type:'User'}}">

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Suffix<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select name="suffix" class="form-control required"
                                                    data-msg-required="Suffix is required">
                                                <option value="">Select Suffix</option>
                                                @foreach($getSuffix as $suffix)
                                                    <option value="{{$suffix['value']}}" {{(!empty($user)&& $user->suffix==$suffix['value'])?'selected':old('suffix')}} >
                                                        {{$suffix['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">First Name<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="first_name" id="first_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="First Name" data-msg-required="First name  is required"
                                                   value="{{!empty($user)?$user->first_name:old('first_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Middle Name<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="middle_name" id="middle_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Middle Name" data-msg-required="Middle name is required"
                                                   value="{{!empty($user)?$user->middle_name:old('middle_name')}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Last Name<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="last_name" autocomplete="off"
                                                   class="form-control  required "
                                                   placeholder="Last Name" data-msg-required="Last name  is required"
                                                   value="{{!empty($user)?$user->last_name:old('last_name')}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Email<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="email" id="email" autocomplete="off"
                                                   class="form-control required"
                                                   data-msg-required="Email is required"
                                                   data-rule-email="true"
                                                   placeholder="Email"
                                                   value="{{!empty($user)?$user->email:old('email')}}">

                                        </div>
                                    </div>
                                    @if(empty($user))
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label ">Password<span
                                                    class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" name="password" id="password" autocomplete="off"
                                                       class="form-control required"
                                                       placeholder="Password" data-msg-required="Password  is required"
                                                       value="">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label  ">Phone No<span
                                                    class="text-danger">*</span></label>
                                        <input type="hidden" id="country_code" name="country_code"
                                               value="{{ !empty($user->country_code) ? $user->country_code:$default_country_phonecode  }}">
                                        <div class="col-lg-6">
                                            <input type="text" name="phone_no" id="phone_no"
                                                   class="form-control required"
                                                   placeholder="phone no" autocomplete="off"
                                                   data-msg-required="Phone no  is required" data-rule-digits="true"
                                                   data-rule-minlength="8"
                                                   value="{{!empty($user)?$user->phone_no:old('phone_no')}}">
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Gender<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <select name="gender" class="form-control required"
                                                    data-msg-required="Gender is required">
                                                <option value="">Select Gender</option>
                                                @foreach($getGender as $gender)
                                                    <option value="{{$gender['value']}}" {{(!empty($user)&& $user->gender==$gender['value'])?'selected':old('gender')}} >
                                                        {{$gender['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-lg-3 col-form-label">Address <span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <textarea name="address" class="form-control summernote"
                                                      rows="5">{{!empty($user)&&$user->address?$user->address:old('address')}}</textarea>
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
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('styles')
    <link href="{{asset('assets/css/intTelInput.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('assets/js/intlTelInput.js')}}"></script>
    <script>
        var isPhoneNoValid = false;
        var input = document.querySelector("#phone_no");
        const iti = window.intlTelInput(input, {
            allowExtensions:true,
            formatOnDisplay:true,
            allowFormat:true,
            autoHideDialCode:true,
            placeholderNumberType:"MOBILE",
            preventInvalidNumbers:true,
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


