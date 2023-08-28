@php use Illuminate\Support\Facades\DB; @endphp
@inject('baseHelper', 'App\Helpers\BaseHelper')
<?php


$default_country_code = $baseHelper->default_country_code();
$default_country_phonecode = $baseHelper->default_country_phonecode();
$phoneCode = !empty($provider->country_code)?$provider->country_code:$default_country_phonecode;
$phoneNo = isset($provider->phone_no) ? "+" . $phoneCode . $provider->phone_no : '';
$weekOfDay = $baseHelper->weekOfDay();
$hoursList = $baseHelper->makeOpeningHoursOptions();
?>
@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Provider',
             'directory'=> 'Edit',
             'action'=>'Create',
             'back' => 'provider'
        ])
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first"
                             data-wizard-clickable="true">
                            <!--begin: Wizard Nav-->
                            <div class="wizard-nav">
                                <div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>1.</span>Provider Information</h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>2.</span>Education</h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>3.</span>Working Hours</h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-wizard-type="step">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>4.</span>State Of Lic</h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-wizard-type="step" onclick="getAssignProgram()">
                                        <div class="wizard-label">
                                            <h3 class="wizard-title">
                                                <span>5.</span>Programs</h3>
                                            <div class="wizard-bar"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Wizard Nav-->
                                <div class="row justify-content-center py-5 px-4 py-lg-6 px-lg-5">
                                    <div class="col-xl-12 col-xxl-10">

                                        <div class="form" id="kt_form">

                                            <!-- Start Provider Information -->
                                            <div class="pb-5" data-wizard-type="step-content"
                                                 data-wizard-state="current">
                                                <form class="form ajax-form"
                                                      action="{{route('provider.update',$provider->id)}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @if($provider)
                                                        @method('PUT')
                                                    @endif
                                                    <h4 class="mb-5 font-weight-bold text-dark">Provider
                                                        Information</h4>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <label>Image</label>
                                                            <div class="form-group">
                                                                <div class="image-input image-input-outline mb-5"
                                                                     id="kt_image_1">
                                                                    <div class="image-input-wrapper"
                                                                         style="background-image: url('{{ $provider->getFileUrl($provider->avatar)  }}')"></div>
                                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                           data-action="change" data-toggle="tooltip"
                                                                           title=""
                                                                           data-original-title="Change avatar">
                                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                                        <input type="file" name="avatar"
                                                                               accept=".png, .jpg, .jpeg"/>
                                                                        <input type="hidden"
                                                                               name="profile_avatar_remove"/>
                                                                    </label>

                                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                          data-action="cancel" data-toggle="tooltip"
                                                                          title="Cancel avatar"><i
                                                                                class="ki ki-bold-close icon-xs text-muted"></i></span>
                                                                    <span class="form-text text-muted">Allowed file types:  png, jpg, jpeg.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <label>Insurance Proof
                                                                @if(!empty($provider->insurance_proof))
                                                                    <a href="{{ $provider->getFileUrl($provider->insurance_proof)  }}" target="_blank" >
                                                                    <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/General/Attachment1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12.4644661,14.5355339 L9.46446609,14.5355339 C8.91218134,14.5355339 8.46446609,14.9832492 8.46446609,15.5355339 C8.46446609,16.0878187 8.91218134,16.5355339 9.46446609,16.5355339 L12.4644661,16.5355339 L12.4644661,17.5355339 C12.4644661,18.6401034 11.5690356,19.5355339 10.4644661,19.5355339 L6.46446609,19.5355339 C5.35989659,19.5355339 4.46446609,18.6401034 4.46446609,17.5355339 L4.46446609,13.5355339 C4.46446609,12.4309644 5.35989659,11.5355339 6.46446609,11.5355339 L10.4644661,11.5355339 C11.5690356,11.5355339 12.4644661,12.4309644 12.4644661,13.5355339 L12.4644661,14.5355339 Z" fill="#000000" opacity="0.3" transform="translate(8.464466, 15.535534) rotate(-45.000000) translate(-8.464466, -15.535534) "/>
        <path d="M11.5355339,9.46446609 L14.5355339,9.46446609 C15.0878187,9.46446609 15.5355339,9.01675084 15.5355339,8.46446609 C15.5355339,7.91218134 15.0878187,7.46446609 14.5355339,7.46446609 L11.5355339,7.46446609 L11.5355339,6.46446609 C11.5355339,5.35989659 12.4309644,4.46446609 13.5355339,4.46446609 L17.5355339,4.46446609 C18.6401034,4.46446609 19.5355339,5.35989659 19.5355339,6.46446609 L19.5355339,10.4644661 C19.5355339,11.5690356 18.6401034,12.4644661 17.5355339,12.4644661 L13.5355339,12.4644661 C12.4309644,12.4644661 11.5355339,11.5690356 11.5355339,10.4644661 L11.5355339,9.46446609 Z" fill="#000000" transform="translate(15.535534, 8.464466) rotate(-45.000000) translate(-15.535534, -8.464466) "/>
    </g>
</svg><!--end::Svg Icon--></span>
                                                                    </a>

                                                                @endif
                                                            </label>
                                                            <input type="file" class="form-control"
                                                                   accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                                                            text/plain, application/pdf, image/*"
                                                                   name="insurance_proof"
                                                                   placeholder="Insurance Proof"
                                                                   value=""/>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Suffix<span class="text-danger">*</span></label>
                                                                <select name="suffix" class="form-control required"
                                                                        data-msg-required="Suffix is required">
                                                                    <option value="">Select Suffix</option>
                                                                    @foreach($getSuffix as $key=>$suffix)
                                                                        <option value="{{$suffix['value']}}" {{(isset($provider) && $provider->suffix==$suffix['value'])?'selected':old('suffix')}}>
                                                                            {{$suffix['label']}}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>First Name<span
                                                                            class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                       data-msg-required="First name is required"
                                                                       name="first_name"
                                                                       placeholder="First Name"
                                                                       value="{{(isset($provider))?$provider->first_name:old('first_name')}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Last Name<span
                                                                            class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                       name="last_name"
                                                                       data-msg-required="Last name is required"
                                                                       placeholder="Last Name"
                                                                       value="{{(isset($provider))?$provider->last_name:old('last_name')}}"/>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Email<span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                       name="email"
                                                                       data-msg-required="Email is required"
                                                                       data-rule-email="true"
                                                                       placeholder="Email"
                                                                       value="{{(isset($provider))?$provider->email:old('email')}}"/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Role<span
                                                                            class="text-danger">*</span></label>
                                                                <input type="text" class="form-control required"
                                                                       name="user_type"
                                                                       data-msg-required="User Role is required"
                                                                       disabled
                                                                       placeholder="Role"
                                                                       value="{{(isset($provider))?$provider->user_type:old('user_type')}}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Phone No<span
                                                                            class="text-danger">*</span></label>
                                                                <input type="hidden" id="country_code" name="country_code"
                                                                       value="{{ !empty($provider->country_code) ? $provider->country_code: $default_country_phonecode  }}">
                                                                <input type="text" class="form-control required"
                                                                       name="phone_no" id="phone_no"
                                                                       data-msg-required="Phone No is required"
                                                                       data-rule-digits="true" data-rule-minlength="8"
                                                                       data-rule-maxlength="10"
                                                                       placeholder="Phone No"
                                                                       value="{{(isset($provider))?$provider->phone_no:old('phone_no')}}"/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Designation</label>
                                                                <input type="text" class="form-control"
                                                                       name="designation"
                                                                       placeholder="Designation"
                                                                       value="{{(isset($provider))?$provider->designation:old('designation')}}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Date Of Brith</label>
                                                                <div class="input-group date">
                                                                    <input type="text" name="dob"
                                                                           class="form-control required"
                                                                           data-msg-required="Dob is required"
                                                                           autocomplete="off"
                                                                           placeholder="dd-mm-yyyy"
                                                                           id="dob"
                                                                           value="{{ !empty(old('dob'))?old('dob'):(!empty($provider->dob)?date('d/m/Y',strtotime($provider->dob)):date('d/m/Y')) }}">
                                                                    <div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-calendar"></i>
															</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Gender<span class="text-danger">*</span></label>
                                                                <select name="gender" class="form-control required"
                                                                        data-msg-required="Gender is required">
                                                                    <option value="">Select Gender</option>
                                                                    <option value="M" {{(isset($provider)&& $provider->gender=='M')?'selected':old('M')}} >
                                                                        Male
                                                                    </option>
                                                                    <option value="F" {{(isset($provider)&& $provider->gender=='F')?'selected':old('F')}}>
                                                                        Female
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <!--begin::Input-->
                                                            <div class="form-group">
                                                                <label>Zip</label>
                                                                <input type="text" class="form-control" name="zip"
                                                                       placeholder="Zip"
                                                                       value="{{(isset($provider))?$provider->zip:old('zip')}}"/>

                                                            </div>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>SSN</label>
                                                                <input type="text" class="form-control" name="ssn"
                                                                       placeholder="SSN"
                                                                       value="{{(isset($provider))?$provider->ssn:old('ssn')}}"/>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea class="form-control" name="address"
                                                                  placeholder="Address">{{(isset($provider))?$provider->address:old('address')}}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>City</label>
                                                                <input type="text" class="form-control" name="city_name"
                                                                       placeholder="City"
                                                                       value="{{(isset($provider))?$provider->city_name:old('city_name')}}"/>

                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>State</label>
                                                                <select name="state_id"
                                                                        class="form-control state-select2"
                                                                        style="width: 100%">
                                                                    <option value="">Select State</option>
                                                                    @foreach($getState as $items)
                                                                        <option value="{{$items->state_id}}" {{ isset($provider->state_id) && $provider->state_id==$items->state_id ? 'selected' : ''}}>
                                                                            {{$items->state_name}}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bio</label>
                                                        <textarea class="form-control" name="bio"
                                                                  placeholder="Bio">{{(isset($provider))?$provider->bio:old('bio')}}</textarea>
                                                    </div>
                                                    <div class="separator separator-dashed my-8"></div>
                                                    <button type="submit"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">
                                                        Submit
                                                    </button>

                                                </form>
                                            </div>
                                            <!-- End Provider Information -->

                                            <!-- Start Education Information -->
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h4 class="mb-10 font-weight-bold text-dark">Educations:</h4>
                                                <form class="form ajax-form"
                                                      action="{{route('school.update',$provider->id)}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @if($provider)
                                                        @method('PUT')
                                                    @endif

                                                    <div class="rounded p-10">
                                                        @if(count($educationDetails) > 0)
                                                            <div id="kt_docs_repeater_nested">
                                                                <div class="form-group">
                                                                    <div data-repeater-list="education">
                                                                        @foreach($educationDetails as $val)
                                                                            <div data-repeater-item>
                                                                                <div class="form-group row mb-5">
                                                                                    <div class="col-md-3">
                                                                                        <label class="form-label">School:</label>
                                                                                        <input type="text" name="school"
                                                                                               class="form-control mb-2 mb-md-0"
                                                                                               placeholder="School"
                                                                                               value="{{!empty($val->school_name)?$val->school_name:''}}"/>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="inner-repeater">
                                                                                            <div data-repeater-list="degreeDetails"
                                                                                                 class="mb-5">
                                                                                                <div data-repeater-item>
                                                                                                    @if(!empty($val->getDegreeDetails))
                                                                                                        @foreach($val->getDegreeDetails as $value)
                                                                                                            <label class="form-label">Degree:</label>
                                                                                                            <div class="input-group pb-3">
                                                                                                                <input type="text"
                                                                                                                       class="form-control"
                                                                                                                       placeholder="Degree"
                                                                                                                       name="degree"
                                                                                                                       value="{{!empty($value->degree)?$value->degree:""}}"/>
                                                                                                            </div>
                                                                                                            <label class="form-label">Year:</label>
                                                                                                            <div class="input-group pb-3">
                                                                                                                <input type="text"
                                                                                                                       class="form-control"
                                                                                                                       placeholder="Year"
                                                                                                                       name="year"
                                                                                                                       value="{{!empty($value->year)?$value->year:""}}"/>
                                                                                                            </div>
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                    <button class="border border-secondary btn btn-icon btn-flex btn-light-danger"
                                                                                                            data-repeater-delete
                                                                                                            type="button">
                                                                                                        <i class="la la-trash fs-5"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <button class="btn btn-sm btn-flex btn-light-primary"
                                                                                                    data-repeater-create
                                                                                                    type="button">
                                                                                                <i class="la la-plus fs-5"></i>
                                                                                                Add
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-4">
                                                                                        <a href="javascript:"
                                                                                           data-repeater-delete
                                                                                           class="btn btn-sm btn-flex btn-light-danger mt-3 mt-md-9">
                                                                                            <i class="la la-trash fs-5"></i>
                                                                                            Delete Row
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <a href="javascript:" data-repeater-create
                                                                       class="btn btn-flex btn-light-primary">
                                                                        <i class="la la-plus fs-3"></i>
                                                                        Add
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        @else
                                                            <div id="kt_docs_repeater_nested">
                                                                <div class="form-group">
                                                                    <div data-repeater-list="education">
                                                                        <div data-repeater-item>
                                                                            <div class="form-group row mb-5">
                                                                                <div class="col-md-3">
                                                                                    <label class="form-label">School:</label>
                                                                                    <input type="text" name="school"
                                                                                           class="form-control mb-2 mb-md-0"
                                                                                           placeholder="School"/>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="inner-repeater">
                                                                                        <div data-repeater-list="degreeDetails"
                                                                                             class="mb-5">
                                                                                            <div data-repeater-item>
                                                                                                <label class="form-label">Degree:</label>
                                                                                                <div class="input-group pb-3">
                                                                                                    <input type="text"
                                                                                                           name="degree"
                                                                                                           class="form-control"
                                                                                                           placeholder="Degree"/>
                                                                                                </div>
                                                                                                <label class="form-label">Year:</label>
                                                                                                <div class="input-group pb-3">
                                                                                                    <input type="text"
                                                                                                           name="year"
                                                                                                           class="form-control"
                                                                                                           placeholder="Year"/>
                                                                                                </div>


                                                                                                <button class="border border-secondary btn btn-icon btn-flex btn-light-danger"
                                                                                                        data-repeater-delete
                                                                                                        type="button">
                                                                                                    <i class="la la-trash fs-5"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <button class="btn btn-sm btn-flex btn-light-primary"
                                                                                                data-repeater-create
                                                                                                type="button">
                                                                                            <i class="la la-plus fs-5"></i>
                                                                                            Add
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <a href="javascript:"
                                                                                       data-repeater-delete
                                                                                       class="btn btn-sm btn-flex btn-light-danger mt-3 mt-md-9">
                                                                                        <i class="la la-trash fs-5"></i>
                                                                                        Delete Row
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <a href="javascript:" data-repeater-create
                                                                       class="btn btn-flex btn-light-primary">
                                                                        <i class="la la-plus fs-3"></i>
                                                                        Add
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <button type="submit"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">
                                                        Save
                                                    </button>
                                                </form>
                                            </div>
                                            <!-- End Education Information -->

                                            <!-- Start Working Hour Information -->
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h4 class="mb-10 font-weight-bold text-dark">Working Hours (EST)</h4>
                                                <div class="mb-5">
                                                </div>
                                                <form class="form ajax-form"
                                                      action="{{route('working-hours.update',$provider->id)}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @if($provider)
                                                        @method('PUT')
                                                    @endif

                                                    <?php
                                                    $day1 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 1)->get();
                                                    $day2 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 2)->get();
                                                    $day3 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 3)->get();
                                                    $day4 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 4)->get();
                                                    $day5 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 5)->get();
                                                    $day6 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 6)->get();
                                                    $day7 = \Illuminate\Support\Facades\DB::table('provider_working_hours')->where('user_id', $provider->id)->where('day', 7)->get();

                                                    ?>
                                                    <div class="weekly-content" data-day="1">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_MON">
                                                                        <input type="checkbox" value="1"
                                                                               name="checked_week_days[]" {{count($day1) > 0?'checked':''}}>
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Mon
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">
                                                                    @forelse($day1 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[1][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[1][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[1][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[1][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="2">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_TUE">
                                                                        <input type="checkbox" value="2" {{count($day2) > 0?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Tue
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">

                                                                    @forelse($day2 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[2][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[2][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[2][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[2][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="3">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_WED">
                                                                        <input type="checkbox" value="3" {{count($day3) > 0 ?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Wed
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">

                                                                    @forelse($day3 as $val)

                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[3][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[3][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>

                                                                    @empty

                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[3][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[3][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>

                                                                    @endforelse

                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="4">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_THU">
                                                                        <input type="checkbox" value="4" {{count($day4) > 0?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Thu
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">

                                                                    @forelse($day4 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[4][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[4][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[4][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[4][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="5">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_FRI">
                                                                        <input type="checkbox" value="5"  {{count($day5) > 0?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Fri
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">

                                                                    @forelse($day5 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[5][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[5][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[5][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[5][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse

                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="6">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_SAT">
                                                                        <input type="checkbox" value="6" {{count($day6) > 0 ?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Sat
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">
                                                                    @forelse($day6 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[6][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[6][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[6][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[6][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="weekly-content" data-day="7">
                                                        <div class="d-flex w-100 align-items-center position-relative border-bottom">
                                                            <div class="d-flex flex-md-row flex-column w-100 weekly-row my-3">
                                                                <div class="col-2 form-check form-check-custom form-check-solid mb-0 checkbox-content d-flex align-items-center">
                                                                    <label class="checkbox checkbox-lg"
                                                                           id="chkShortWeekDay_SUN">
                                                                        <input type="checkbox" value="7" {{count($day7) > 0 ?'checked':''}}
                                                                        name="checked_week_days[]">
                                                                        <span></span>
                                                                        &nbsp; &nbsp;Sun
                                                                    </label>
                                                                </div>
                                                                <div class="session-times">

                                                                    @forelse($day7 as $val)
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot" id="{{$val->provider_working_hours_id}}">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[7][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->start_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[7][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}" {{$value == $val->end_time ? 'selected':''}}>{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <a type="button" onclick="deleteBtn({{$val->provider_working_hours_id}});">
                                                                                    <i class="fa fa-trash ml-5 ms-5 fs-3 text-danger"
                                                                                       aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @empty
                                                                        <div class="align-items-center justify-content-between mt-md-0 mt-10 timeSlot">
                                                                            <div class="d-flex align-items-center mb-3 add-slot">
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="startTimes[7][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="small-border me-3">-</span>
                                                                                <div class="col-md-6">
                                                                                    <select class="form-control"
                                                                                            name="endTimes[7][]">
                                                                                        <option value=""></option>
                                                                                        @foreach($workingHours as $value)
                                                                                            <option value="{{$value}}">{{$value}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>

                                                                            </div>
                                                                            <span class="error-msg text-danger"></span>
                                                                        </div>
                                                                    @endforelse

                                                                </div>
                                                            </div>

                                                            <div class="weekly-icon position-absolute end-0 d-flex">
                                                                <button type="button" title="plus"
                                                                        class="btn px-2 text-gray-600 fs-2 add-session-time">
                                                                    <i class="fa fa-plus ms-5 fs-3 text-dark"
                                                                       aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <button type="submit"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4 mt-10">
                                                        Save
                                                    </button>
                                                </form>


                                            </div>
                                            <!-- End Working Hour Information -->

                                            <!-- Start State Of Lic Information -->
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <h4 class="mb-10 font-weight-bold text-dark">State Of Lic</h4>
                                                <form class="form ajax-form"
                                                      action="{{route('state-of-lic.update',$provider->id)}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @if($provider)
                                                        @method('PUT')
                                                    @endif
                                                    <div id="state_of_lic_repeter">
                                                        <div class="form-group row" id="state_of_lic">
                                                            <div data-repeater-list="stateOfLic"
                                                                 class="col-xl-12">


                                                                @php $stateOfLicDetails=!empty(old('state_of_lic_details'))?old('state_of_lic_details'):(empty($stateOfLic)?[]:$stateOfLic);
                                                                $i=0;
                                                                @endphp

                                                                @if(count($stateOfLicDetails) > 0)
                                                                    @php $i=0;
                                                                    @endphp
                                                                    @foreach($stateOfLicDetails as $key=>$lic)
                                                                        <div data-repeater-item
                                                                             class="form-group row align-items-center">
                                                                            <div class="col-lg-5">

                                                                                <label>State:</label>
                                                                                <select name="state_id"
                                                                                        class="form-control state-lic-select2"
                                                                                        style="width: 100%">
                                                                                    <option value="">Select..</option>

                                                                                    @foreach($getState as $items)
                                                                                        <option value="{{$items->state_id}}" {{ isset($lic['state_id']) && $lic['state_id']==$items->state_id ? 'selected' : ''}}>
                                                                                            {{$items->state_name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-lg-5">
                                                                                <label>Lic:</label>
                                                                                <input type="text" class="form-control"
                                                                                       placeholder="Lic" name="lic_no"
                                                                                       value="{{ isset($lic['lic_no'])?$lic['lic_no']:''}}"/>

                                                                            </div>
                                                                            <div class="col-lg-1">
                                                                                <a href="javascript:"
                                                                                   data-repeater-delete=""
                                                                                   class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                                    <i class="la la-trash-o"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div data-repeater-item
                                                                         class="form-group row align-items-center">
                                                                        <div class="col-lg-5">
                                                                            <label>State:</label>
                                                                            <select name="state_id"
                                                                                    class="form-control state-lic-select2"
                                                                                    style="width: 100%">
                                                                                <option value="">Select..</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-lg-5">
                                                                            <label>Lic:</label>
                                                                            <input type="text" class="form-control"
                                                                                   placeholder="Lic" name="lic_no"/>

                                                                        </div>
                                                                        <div class="col-lg-1">
                                                                            <a href="javascript:"
                                                                               data-repeater-delete=""
                                                                               class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                                <i class="la la-trash-o"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-form-label text-right"></label>
                                                            <div class="col-lg-4">
                                                                <a href="javascript:" data-repeater-create=""
                                                                   class="btn btn-sm font-weight-bolder btn-light-primary">
                                                                    <i class="la la-plus"></i>Add
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">
                                                        Save
                                                    </button>

                                                </form>


                                            </div>
                                            <!-- End State Of Lic Information -->

                                            <!-- Start Assign Program Information -->
                                            <div class="pb-5" data-wizard-type="step-content">
                                                <div class="form-group row">
                                                    <div class="col-lg-8">
                                                        <h4 class="mb-10 font-weight-bold text-dark">Assigned
                                                            programs:</h4>

                                                        <div id="assignProgramList">

                                                        </div>

                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" data-toggle="modal"
                                                                data-id="{{ $provider->id }}"
                                                                class="btn btn-sm font-weight-bolder btn-light-primary assignProgramModel">
                                                            <i class="la la-plus"></i>Add New
                                                        </button>
                                                    </div>


                                                </div>

                                                <!--end::Select-->
                                            </div>
                                            <!-- End Assign Program Information -->

                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <button type="button"
                                                            class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-prev">Previous
                                                    </button>
                                                </div>
                                                <div>
                                                    <button type="button"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-submit">Submit
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-next">Next
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="assignProgramModel" data-backdrop="static" tabindex="-1" role="dialog"
                 aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Assign Program</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="user_id"
                                   name="user_id" value="">

                            <div class="form-group row">
                                <label class="col-lg-12 col-form-label">Event Name <span
                                            class="text-danger">*</span></label>
                                <div class="col-lg-12">
                                    <select name="event_id" class="form-control event-select2" id="event_id"
                                            data-msg-required="Event Name is required" style="width: 100%;!important;">
                                        <option value="">Select Event</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-primary" onclick="saveAssignProgram()">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('styles')
    <style>
        .align-items-center {
            align-items: center !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .position-relative {
            position: relative !important;
        }

        .d-flex {
            display: flex !important;
        }

        @media (min-width: 768px) {
            .flex-md-row {
                flex-direction: row !important;
            }
        }

        .my-3 {
            margin-top: 0.75rem !important;
            margin-bottom: 0.75rem !important;
        }

        .flex-column {
            flex-direction: column !important;
        }

        .d-flex {
            display: flex !important;
        }

        .end-0 {
            right: 0 !important;
        }

        .position-absolute {
            position: absolute !important;
        }

        .d-flex {
            display: flex !important;
        }

        .fs-2 {
            font-size: 1.25rem !important;
        }

        .px-2 {
            padding-right: 0.5rem !important;
            padding-left: 0.5rem !important;
        }
    </style>
    <link href="{{asset('assets/css/pages/wizard/wizard-3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/intTelInput.css')}}" rel="stylesheet" type="text/css">
@endpush
@push('scripts')
    <script src="{{asset('assets/js/pages/custom/wizard/wizard-3.js')}}"></script>
    <script src="{{asset('assets/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
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
        var avatar1 = new KTImageInput('kt_image_1');
        var avatar1 = new KTImageInput('kt_image_2');
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
        $('#kt_docs_repeater_nested').repeater({
            repeaters: [{
                selector: '.inner-repeater',
                show: function () {
                    $(this).slideDown();
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            }],

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
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
        $(".event-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('event-list')}}",
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
        $('#education').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
        $('#school_details').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
        $('#state_of_lic_repeter').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                $(".state-lic-select2").select2({
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
            },

            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
        $(".state-lic-select2").select2({
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
        jQuery(document).ready(function () {
            KTFormRepeater.init();
        });
    </script>
    <script>
        $(document).on("click", ".assignProgramModel", function () {
            var Id = $(this).data('id');
            $("input[name=user_id]").val(Id);
            $('#assignProgramModel').modal('show');
        });
        $(document).ready(function () {
            getAssignProgram();
        });
        function getAssignProgram() {
            $.ajax({
                type: "GET",
                url: "/get-assign-program" + "/" + {!!  !empty($provider->id)?$provider->id:'' !!},
                dataType: 'json',
                success: function (response) {
                    $('#assignProgramList').html(response);
                }
            });
        }
        function saveAssignProgram() {
            var eventId = $("select[name=event_id]").val();
            var user_id = $("input[name=user_id]").val();
            $.ajax({
                url: "/save-assign-program",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    event_id: eventId,
                    id: user_id,
                },
                success: function (response) {
                    if (response.success) {
                        $('#assignProgramModel').modal('toggle');
                        $('#program_name').val('');
                        $('#duration').val('');
                        getAssignProgram();
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }
                },
            });
        }
        function assignProgramStatusUpdate(assignProgramId) {
            $.ajax({
                url: "/assign-program-change-status",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    assign_program_id: assignProgramId,
                },
                success: function (response) {
                    if (response.status) {
                        getAssignProgram();
                        swalSuccess(response.message);
                    } else {
                        swalError(response.message);
                    }

                }
            });
        }
        function deleteBtn(clickId) {
            $.ajax({
                    url: "/delete-provider-working-hours",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id: clickId,
                    },
                    success: function (response) {
                        if(response.status == true){
                            $('#'+response.id).hide();
                        } else{
                            $('#create_'+clickId).hide();
                        }
                    }
            });

        }
    </script>
@endpush
