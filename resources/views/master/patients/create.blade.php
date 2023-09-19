@inject('baseHelper','App\Helpers\User\Helper')
@extends('layouts.app')
@section('content')
    <?php
    $default_country_code = $baseHelper->default_country_code();
    $default_country_phonecode = $baseHelper->default_country_phonecode();
    $phoneCode = !empty($patientDetails->country_code)?$patientDetails->country_code:$default_country_phonecode;
    $phoneNo = isset($patientDetails->phone_no) ? "+" . $phoneCode . $patientDetails->phone_no : '';
    ?>
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Patients',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'patients'
        ])
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <form action="{{(isset($patients))?route('patients.update',$patients->patients_id):route('patients.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($patients))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-1 col-form-label ">Image <span
                                                    class="text-danger"></span></label>
                                        <div class="col-lg-6">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ !empty($patients->image)?$patients->getFileUrl($patients->image):asset('assets/media/users/default.jpg') }}')"></div>
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
                                        <div class="col-lg-4">
                                            <label>Member Id<span class="text-danger">*</span></label>
                                            <input type="text" name="member_id" autocomplete="off" readonly
                                                   class="form-control required"
                                                   placeholder="Member Id" data-msg-required="MemberId is required"
                                                   value="{{isset($memberId)?$memberId:$patients->member_id}}">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>First Name<span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="First Name"
                                                   data-msg-required="First name  is required"
                                                   value="{{isset($patients)?$patients->first_name:old('first_name')}}">

                                        </div>
                                        <div class="col-lg-4">
                                            <label>Last Name<span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Last Name"
                                                   data-msg-required="Last name  is required"
                                                   value="{{isset($patients)?$patients->last_name:old('last_name')}}">

                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label>Dob<span class="text-danger">*</span></label>
                                            <div class="input-group date">
                                                <input type="text" name="dob"
                                                       class="form-control required"
                                                       data-msg-required="Dob is required"
                                                       autocomplete="off"
                                                       placeholder="dd-mm-yyyy"
                                                       id="dob"
                                                       value="{{ !empty(old('dob'))?old('dob'):(!empty($patients->dob)?date('d/m/Y',strtotime($patients->dob)):date('d/m/Y')) }}">
                                                <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Profile Claimed<span class="text-danger">*</span></label>
                                            <div class="input-group date">
                                                <input type="text" name="profile_claimed"
                                                       class="form-control required"
                                                       data-msg-required="Profile Claimed is required"
                                                       autocomplete="off"
                                                       placeholder="dd-mm-yyyy"
                                                       id="profile_claimed"
                                                       value="{{ !empty(old('profile_claimed'))?old('profile_claimed'):(!empty($patients->profile_claimed)?date('d/m/Y',strtotime($patients->profile_claimed)):date('d/m/Y')) }}">
                                                <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Email<span class="text-danger">*</span></label>
                                            <input type="text" name="email" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Email" data-msg-required="Email is required"
                                                   data-rule-email="true"
                                                   value="{{isset($patients)?$patients->email:old('email')}}">

                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <input type="hidden" id="country_code" name="country_code"
                                                   value="{{ !empty($patients->country_code) ? $patients->country_code: $default_country_phonecode  }}">

                                            <label>Phone No<span class="text-danger">*</span></label>
                                            <input type="text" name="phone_no" id="phone_no"
                                                   class="form-control required"
                                                   placeholder="Phone No" autocomplete="off"
                                                   data-msg-required="Phone no is required"
                                                   data-rule-digits="true"
                                                   data-rule-minlength="8"
                                                   value="{{isset($patients)?$patients->phone_no:old('phone_no')}}">

                                        </div>
                                        <div class="col-lg-4">
                                            <label>Gender<span class="text-danger"></span></label>
                                            <select class="form-control required" data-msg-required="Gender is required"
                                                    type="text" name="gender" style="width: 100%">
                                                <option value="">Select Gender</option>
                                                <option value="M" {{(isset($patients)&& $patients->gender=='M')?'selected':old('M')}}>
                                                    Male
                                                </option>
                                                <option value="F" {{(isset($patients)&& $patients->gender=='F')?'selected':old('F')}}>
                                                    FeMale
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>SSN<span class="text-danger"></span></label>
                                            <input type="text" name="ssn"
                                                   class="form-control"
                                                   placeholder="SSN" autocomplete="off" data-rule-minlength="4"
                                                   data-rule-maxlength="4"
                                                   value="{{isset($patients)?$patients->ssn:old('ssn')}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label>City <span class="text-danger">*</span></label>
                                            <input type="text" name="city_name"
                                                   class="form-control required"
                                                   placeholder="City" autocomplete="off"
                                                   data-msg-required="City is required"
                                                   value="{{isset($patients)?$patients->city_name:old('city_name')}}">

                                        </div>
                                        <div class="col-lg-4">
                                            <label>State<span class="text-danger">*</span></label>
                                            <select name="state_id" class="form-control state-select2" id="stateSelect2"
                                                    style="width: 100%">
                                                @if(!empty($patients))
                                                    <option value="{{(isset($patients))?$patients->state_id:(old('state_id')?old('state_id'):0)}}">
                                                        {{ isset($getStatName->state_name)?$getStatName->state_name:''}}
                                                    </option>
                                                @endif
                                            </select>

                                        </div>
                                        <div class="col-lg-4">
                                            <label>Zip<span class="text-danger">*</span></label>
                                            <input type="text" name="zip" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Zip" data-msg-required="Zip is required"
                                                   value="{{isset($patients)?$patients->zip:old('zip')}}">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label>Address<span class="text-danger">*</span></label>
                                            <textarea type="text" name="address" autocomplete="off"
                                                      class="form-control required" placeholder="Address"
                                                      data-msg-required="Address is required">{{isset($patients)?$patients->address:old('address')}}</textarea>

                                        </div>
                                    </div>
                                    <div class="example-preview">
                                        <ul class="nav nav-light-primary nav-pills" id="myTab" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" id="profile-tab" data-toggle="tab"
                                                   href="#profile" aria-controls="profile">
																	<span class="nav-icon">
																		<i class="flaticon2-layers-1"></i>
																	</span>
                                                    <span class="nav-text">Address</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-5" id="myTabContent">
                                            <div class="tab-pane fade active show" id="profile" role="tabpanel"
                                                 aria-labelledby="profile-tab">

                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h5 style=" padding:10px;text-align: center">BILLING
                                                                ADDRESS</h5>


                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 1</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="billing_address_1" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->billing_address_1:old('billing_address_1')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 2</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="billing_address_2" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->billing_address_2:old('billing_address_2')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 3</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="billing_address_3" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->billing_address_3:old('billing_address_3')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">State </label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control state-select2" id="billingStateSelect2"
                                                                            name="billing_state_id" style="width: 100%">
                                                                        @if(!empty($patients))
                                                                            <option value="{{(isset($patients))?$patients->billing_state_id:(old('billing_state_id')?old('billing_state_id'):0)}}">
                                                                                {{ isset($getShippingStatName->state_name)?$getShippingStatName->state_name:''}}
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">City</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" name="billing_city_name"
                                                                           autocomplete="off" class="form-control"
                                                                           placeholder="City"
                                                                           value="{{isset($patients)?$patients->billing_city_name:old('billing_city_name')}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Zip</label>
                                                                <div class="col-xl-8">
                                                                    <input type="text" name="billing_zip"
                                                                           autocomplete="off" maxlength="10"
                                                                           class="form-control" placeholder="Zip"
                                                                           value="{{isset($patients)?$patients->billing_zip:old('billing_zip')}}">

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-6">

                                                            <h5 style="padding:10px;text-align: center">SHIPPING
                                                                ADDRESS</h5>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 1</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="shipping_address_1" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->shipping_address_1:old('shipping_address_1')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 2</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="shipping_address_2" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->shipping_address_2:old('shipping_address_2')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Address 3</label>
                                                                <div class="col-lg-8">
                                                                    <textarea name="shipping_address_3" autocomplete="off"
                                                                              class="form-control"
                                                                              placeholder="Address">{{isset($patients)?$patients->shipping_address_3:old('shipping_address_3')}}</textarea>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">State </label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control state-select2" id="shippingStateSelect2"
                                                                            name="shipping_state_id" style="width: 100%">
                                                                        @if(!empty($patients))
                                                                            <option value="{{(isset($patients))?$patients->shipping_state_id:(old('shipping_state_id')?old('shipping_state_id'):0)}}">
                                                                                {{ isset($getShippingStatName->state_name)?$getShippingStatName->state_name:''}}
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">City</label>
                                                                <div class="col-lg-8">
                                                                    <input type="text" name="shipping_city_name"
                                                                           autocomplete="off" class="form-control"
                                                                           placeholder="City"
                                                                           value="{{isset($patients)?$patients->shipping_city_name:old('shipping_city_name')}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label">Zip</label>
                                                                <div class="col-xl-8">
                                                                    <input type="text" name="shipping_zip"
                                                                           autocomplete="off" maxlength="10"
                                                                           class="form-control" placeholder="Zip"
                                                                           value="{{isset($patients)?$patients->shipping_zip:old('shipping_zip')}}">

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane fade" id="contact" role="tabpanel"
                                                 aria-labelledby="contact-tab">


                                            </div>
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
    <script>

        $('#stateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#billingStateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#shippingStateSelect2').select2({
            placeholder: "Select a state"
        });
        $('#dob').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom left",
            endDate: "today",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });


        $('#profile_claimed').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            endDate: "today",
            orientation: "bottom left",
            templates: arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });

        $(".state-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('state-list')}}",
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
