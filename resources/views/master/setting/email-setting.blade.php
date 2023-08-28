@extends('layouts.app')
@section('content')
    <?php
    $mail_setting = !empty($general_setting->mail_config) ? json_decode($general_setting->mail_config) : "";
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
                        <form action="{{route('save-email-setting')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">
                                <input type="hidden" name="general_setting_id"
                                       value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Email Setting</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your email setting</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" data-toggle="modal" data-target="#testMailModel"
                                                class="btn btn-warning mr-2">Test Mail
                                        </button>
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Host
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="host" autocomplete="off"
                                                   data-msg-required="Host is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required"
                                                   value="{{!empty($mail_setting->host)?$mail_setting->host    :''}}"
                                                   placeholder="Host">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Port
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="port" autocomplete="off"
                                                   data-msg-required="Port is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required"
                                                   value="{{!empty($mail_setting->port)?$mail_setting->port    :''}}"
                                                   placeholder="Port">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Encryption
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select name="encryption" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid mb-2 required"
                                                    data-msg-required="Encryption is required">
                                                <option value="">Select Encryption</option>
                                                <option
                                                    value="ssl" {{ !empty($mail_setting->encryption) && $mail_setting->encryption == 'ssl' ? 'selected' : '' }}>
                                                    SSL
                                                </option>
                                                <option
                                                    value="tls" {{ !empty($mail_setting->encryption) && $mail_setting->encryption == 'tls' ? 'selected' : '' }}>
                                                    TLS
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">UserName
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="username" autocomplete="off"
                                                   data-msg-required="UserName is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required"
                                                   value="{{!empty($mail_setting->username)?$mail_setting->username    :''}}"
                                                   placeholder="UserName">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Password
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="password" autocomplete="off"
                                                   data-msg-required="Password is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required"
                                                   value="{{!empty($mail_setting->password)?$mail_setting->password:''}}"
                                                   placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Appointment Template
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="appointment_template"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->appointment_template)?$general_setting->appointment_template:''}}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal-->
        <div class="modal fade" id="testMailModel" tabindex="-1" role="dialog" aria-labelledby="testMailModelLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="testMailModelLabel">Test Mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                            <label>Email<span class="text-danger">*</span></label>
                            <input type="text"
                                   name="email"
                                   class="form-control" required
                                   style="width: 100%!important;"
                                   autocomplete="off"
                                   placeholder="Email"
                            />

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" id="sentTestMailButton" class="btn btn-primary font-weight-bold" onclick="sendTestMail()">Save
                        </button>
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
        function sendTestMail() {

            $('#sentTestMailButton').addClass('spinner spinner-white spinner-right');

            var email = $("input[name=email]").val();
            var general_setting_id = $("input[name=general_setting_id]").val();

            $.ajax({
                url: "/send-test-mail",
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    email: email,
                    general_setting_id: general_setting_id,
                },
                success: function (response) {
                    if (response.success) {
                        $('#sentTestMailButton').removeClass('spinner spinner-white spinner-right');
                        $('#testMailModel').modal('toggle');
                        swalSuccessWithRedirect(response.message,response.redirectUrl);
                    } else {
                        swalError(response.message);
                        $('#sentTestMailButton').removeClass('spinner spinner-white spinner-right');
                    }
                },
            });
        }
    </script>
@endpush
