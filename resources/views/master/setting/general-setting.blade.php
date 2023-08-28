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

                                <div class="card-header py-3">
                                    <div class="card-title align-items-start flex-column">
                                        <h3 class="card-label font-weight-bolder text-dark">General Settings</h3>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change your general settings</span>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                        <button type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <input type="hidden" name="general_setting_id"
                                           value="{{!empty($general_setting->general_setting_id)?$general_setting->general_setting_id:''}}">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Site Logo
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ !empty($general_setting->site_logo)?$general_setting->getFileUrl($general_setting->site_logo):asset('assets/media/users/default.jpg') }}')"></div>
                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="site_logo"
                                                           accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="site_logo"/>
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
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Site Logo Dark
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <div class="image-input image-input-outline" id="kt_image_2">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ !empty($general_setting->site_logo_dark)?$general_setting->getFileUrl($general_setting->site_logo_dark):asset('assets/media/users/default.jpg') }}')"></div>
                                                <label
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                    data-action="change" data-toggle="tooltip" title=""
                                                    data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="site_logo_dark"
                                                           accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="site_logo_dark"/>
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
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Site Title
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input type="text"
                                                   name="site_title"
                                                   data-msg-required="Site Title is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 required"
                                                   value="{{!empty($general_setting->site_title)?$general_setting->site_title:''}}"
                                                   placeholder="Site Title">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Default Country
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">

                                            <select name="country_code"
                                                   data-msg-required="Country Code is required"
                                                   class="form-control form-control-lg form-control-solid mb-2 country-code-select2 required">

                                                @if(!empty($general_setting))
                                                    <option value="{{(isset($general_setting))?$general_setting->country_code:(old('country_code')?old('country_code'):0)}}">
                                                        {{ isset($getCountryName->country_name)?$getCountryName->country_name:''}}
                                                    </option>
                                                @endif

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
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
    <script>
        $('.summernote').summernote({
            height: 150
        });
        $(".country-code-select2").select2({
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('country-code-list')}}",
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
