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
                        <form action="{{route('save-payment-gateway-setting')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">
                                <input type="hidden" name="general_setting_id" value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Stripe Payment Gateway Setting</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your payment gateway setting</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Stripe Key
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="stripe_key" autocomplete="off"
                                                   data-msg-required="Stripe Key required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->stripe_key)?$general_setting->stripe_key:''}}"
                                                   placeholder="Stripe Key">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Stripe Secret Key
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="stripe_secret_key" autocomplete="off"
                                                   data-msg-required="Stripe Secret Key required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->stripe_secret_key)?$general_setting->stripe_secret_key:''}}"
                                                   placeholder="Stripe Secret Key">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Stripe Webhook Key
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   data-msg-required="Stripe Webhook Key required"
                                                   name="stripe_webhook_key" autocomplete="off"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->stripe_webhook_key)?$general_setting->stripe_webhook_key:''}}"
                                                   placeholder="Stripe Webhook Key">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Stripe Webhook URL
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   data-msg-required="Stripe Webhook URL required"
                                                   name="stripe_webhook_url" autocomplete="off"
                                                   class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($general_setting->stripe_webhook_url)?$general_setting->stripe_webhook_url:''}}"
                                                   placeholder="Stripe Webhook URL">
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
