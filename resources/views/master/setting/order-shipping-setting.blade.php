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
                        <form action="{{route('save-general-setting')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf

                            <div class="card card-custom">
                                <input type="hidden" name="general_setting_id" value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">Order Status Settings</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1"></span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Shipping Type
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select name="shipping_type" autocomplete="off"
                                                    class="form-control form-control-lg form-control-solid mb-2 required"
                                                    data-msg-required="Shipping is required">
                                                <option value="">Select Shipping Type</option>
                                                <option
                                                    value="fedex" {{ !empty($mail_setting->fedex) && $mail_setting->fedex == 'fedex' ? 'selected' : '' }}>
                                                    Fedex
                                                </option>
                                                <option
                                                    value="usps" {{ !empty($mail_setting->usps) && $mail_setting->usps == 'usps' ? 'selected' : '' }}>
                                                    USPS
                                                </option>
                                                <option
                                                    value="ups" {{ !empty($mail_setting->ups) && $mail_setting->ups == 'ups' ? 'selected' : '' }}>
                                                    UPS
                                                </option>
                                            </select>

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
