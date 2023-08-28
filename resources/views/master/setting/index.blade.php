@inject('baseHelper','App\Helpers\User\Helper')
@extends('layouts.app')
@section('content')
    <?php
    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($current_user->country_code)?$current_user->country_code:$default_country_phonecode;
    $phoneNo = isset($current_user->phone_no) ? "+" . $phoneCode . $current_user->phone_no : '';
    $profileLogo = $baseHelper->profileLogo();


    ?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Profile Overview-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    @include('master.setting.setting-menu')
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Card-->
                        <form action="{{route('user-update',$current_user->id)}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @method('PUT')
                            <div class="card card-custom card-stretch">
                                <!--begin::Header-->
                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6">Personal Info</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Image <span
                                                class="text-danger"></span></label>
                                        <div class="col-lg-9">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ $profileLogo}}')"></div>
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
                                        <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid required"
                                                   type="text"
                                                   name="first_name"
                                                   data-msg-required="First name  is required"
                                                   value="{{!empty($current_user)?$current_user->first_name:old('first_name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid required"
                                                   type="text"
                                                   name="last_name"
                                                   data-msg-required="Last name  is required"
                                                   value="{{!empty($current_user)?$current_user->last_name:old('last_name')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <input type="hidden" id="country_code" name="country_code"
                                                       value="{{ !empty($current_user->country_code) ? $current_user->country_code: $default_country_phonecode  }}">
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid"
                                                       name="phone_no"
                                                       id="phone_no"
                                                       data-msg-required="Phone no is required"
                                                       data-rule-digits="true"
                                                       data-rule-minlength="8"
                                                       value="{{!empty($current_user->country_code)?$current_user->country_code.''.$current_user->phone_no:old('phone_no')}}"
                                                       placeholder="Phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="la la-at"></i></span></div>
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid required"
                                                       data-msg-required="Email is required"
                                                       data-rule-email="true"
                                                      name="email"
                                                       value="{{!empty($current_user)?$current_user->email:old('email')}}"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Profile Overview-->
            </div>
            <!--end::Container-->
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{asset('assets/css/intTelInput.css')}}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
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
