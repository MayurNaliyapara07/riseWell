@extends('layouts.app')
@section('content')
    <?php
    $sms_setting = !empty($general_setting->sms_config) ? json_decode($general_setting->sms_config) : "";

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
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">SMS Send Method
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select name="sms_method" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid mb-2 required"
                                                    data-msg-required="SMS Method is required">
                                                <option value="">Select SMS Method</option>
                                                <option value="clickatell" {{ !empty($sms_setting->name) && $sms_setting->name == 'clickatell' ? 'selected' : '' }}>Clickatell</option>
                                                <option value="infobip" {{ !empty($sms_setting->name) && $sms_setting->name == 'infobip' ? 'selected' : '' }}>Infobip</option>
                                                <option value="messageBird" {{ !empty($sms_setting->name) && $sms_setting->name == 'messageBird' ? 'selected' : '' }}>Nessage Bird</option>
                                                <option value="nexmo" {{ !empty($sms_setting->name) && $sms_setting->name == 'nexmo' ? 'selected' : '' }}>Nexmo</option>
                                                <option value="smsBroadcast" {{ !empty($sms_setting->name) && $sms_setting->name == 'smsBroadcast' ? 'selected' : '' }}>Sms Broadcast</option>
                                                <option value="twilio" {{ !empty($sms_setting->name) && $sms_setting->name == 'twilio' ? 'selected' : '' }}>Twilio</option>
                                                <option value="textMagic" {{ !empty($sms_setting->name) && $sms_setting->name == 'textMagic' ? 'selected' : '' }}>TextMagic</option>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="configForm" id="twilio">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Account SID
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="account_sid" autocomplete="off"
                                                       data-msg-required="Account SID is required"
                                                       class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($sms_setting->account_sid)?$sms_setting->account_sid:''}}"
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
                                                       class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($sms_setting->auth_token)?$sms_setting->auth_token:''}}"
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
                                                       class="form-control form-control-lg form-control-solid mb-2 required" value="{{!empty($sms_setting->from_number)?$sms_setting->from_number:''}}"
                                                       placeholder="From Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="clickatell">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">API Key
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="clickatell_api_key" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->clickatell_api_key)?$sms_setting->clickatell_api_key:''}}"
                                                       placeholder="API Key">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="infobip">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Username
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="infobip_username" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->infobip_username)?$sms_setting->infobip_username:''}}"
                                                       placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Password
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="infobip_password" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->infobip_password)?$sms_setting->infobip_password:''}}"
                                                       placeholder="Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="messageBird">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">API Key
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="message_bird_api_key" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->message_bird_api_key)?$sms_setting->message_bird_api_key:''}}"
                                                       placeholder="API Key">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="nexmo">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">API Key
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="nexmo_api_key" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->nexmo_api_key)?$sms_setting->nexmo_api_key:''}}"
                                                       placeholder="API Key">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">API Secret
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="nexmo_api_secret" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->nexmo_api_secret)?$sms_setting->nexmo_api_secret:''}}"
                                                       placeholder="API Secret">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="smsBroadcast">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Username
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="sms_broadcast_username" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->sms_broadcast_username)?$sms_setting->sms_broadcast_username:''}}"
                                                       placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Password
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="sms_broadcast_password" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->sms_broadcast_password)?$sms_setting->sms_broadcast_password:''}}"
                                                       placeholder="Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="configForm" id="textMagic">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Username
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="text_magic_username" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->text_magic_username)?$sms_setting->text_magic_username:''}}"
                                                       placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-alert">Apiv2 Key
                                                <span class="text-danger">*</span></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input type="text"
                                                       name="apiv2_key" autocomplete="off"
                                                       class="form-control form-control-lg form-control-solid mb-2" value="{{!empty($sms_setting->apiv2_key)?$sms_setting->apiv2_key:''}}"
                                                       placeholder="Apiv2 Key">
                                            </div>
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
        var method = '';

        if (!method) {
            method = 'clickatell';
        }

        var method = '{{ !empty($sms_setting->name)?$sms_setting->name:'clickatell' }}';
        smsMethod(method);
        $('select[name=sms_method]').on('change', function() {
            var method = $(this).val();
            smsMethod(method);
        });

        function smsMethod(method){
            $('.configForm').addClass('d-none');
            if(method != 'php') {
                $(`#${method}`).removeClass('d-none');
            }
        }
    </script>
@endpush
