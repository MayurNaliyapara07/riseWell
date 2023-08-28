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
                        <form action="{{route('save-zoom-setting')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">
                                <input type="hidden" name="general_setting_id" value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Zoom Setting</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your zoom setting</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Zoom Client Id
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="zoom_client_url" autocomplete="off"
                                                   data-msg-required="Zoom Client Id required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->zoom_client_url)?$general_setting->zoom_client_url:''}}"
                                                   placeholder="Zoom Client Id">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Zoom Client Secret Key
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="zoom_client_secret_key" autocomplete="off"
                                                   data-msg-required="Zoom Client Secret Key required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->zoom_client_secret_key)?$general_setting->zoom_client_secret_key:''}}"
                                                   placeholder="Zoom Client Secret Key">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Zoom Account No
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   data-msg-required="Zoom Account No required"
                                                   name="zoom_account_no" autocomplete="off"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->zoom_account_no)?$general_setting->zoom_account_no:''}}"
                                                   placeholder="Zoom Account No">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Zoom Access Token
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   data-msg-required="Zoom Access Token required"
                                                   name="zoom_access_token" autocomplete="off"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->zoom_access_token)?$general_setting->zoom_access_token:''}}"
                                                   placeholder="Zoom Access Token">
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
