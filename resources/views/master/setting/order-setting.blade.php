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
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Order Placed
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="order_placed"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->order_placed)?$general_setting->order_placed:''}}
                                            </textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Order Approved
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="order_approved"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->order_approved)?$general_setting->order_approved:''}}
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Order Shipped
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="order_shipped"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->order_shipped)?$general_setting->order_shipped:''}}
                                            </textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Order Arrived
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="order_arrived"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->order_arrived)?$general_setting->order_arrived:''}}
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-alert">Order Fulfilled
                                            <span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-9">
                                            <textarea type="text"
                                                      name="order_fulfilled"
                                                      class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($general_setting->order_fulfilled)?$general_setting->order_fulfilled:''}}
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
    </div>
@endsection
@push('scripts')
    <script>
        $('.summernote').summernote({
            height: 150
        });
    </script>
@endpush
