@extends('layouts.app')
@section('content')
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
                        <form action="{{route('change-password')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   name="current_password"
                                                   data-msg-required="Current Password is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value=""
                                                   placeholder="Current password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   name="new_password"
                                                   data-msg-required="New Password is required"
                                                   class="form-control form-control-lg form-control-solid required" value=""
                                                   placeholder="New password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Confirm
                                            Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="password"
                                                   name="confirm_password"
                                                   data-msg-required="Confirm Password is required"
                                                   class="form-control form-control-lg form-control-solid required" value=""
                                                   placeholder="Confirm password">
                                        </div>
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
