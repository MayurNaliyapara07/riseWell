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
                        <form action="{{route('save-sms-setting')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">
                                <input type="hidden" name="general_setting_id" value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Twilio SMS Setting</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your sms setting</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Account SID
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="account_sid" autocomplete="off"
                                                   data-msg-required="Account SID is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->account_sid)?$general_setting->account_sid:''}}"
                                                   placeholder="Account SID">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Auth Token
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="auth_token" autocomplete="off"
                                                   data-msg-required="Auth Token is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->auth_token)?$general_setting->auth_token:''}}"
                                                   placeholder="Auth Token">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">From Number
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="from_number" autocomplete="off"
                                                   data-msg-required="From Number is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->from_number)?$general_setting->from_number:''}}"
                                                   placeholder="From Number">
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
@push('scripts')
    <script>
        $('.summernote').summernote({
            height: 150
        });
    </script>
@endpush
