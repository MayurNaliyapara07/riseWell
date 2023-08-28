@extends('layouts.app')
@section('content')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit Profile</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total"></span>
                    </div>
                    <!--end::Search Form-->
                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Actions-->
                    <a href="{{url('/')}}" class="btn  font-weight-bolder btn-sm">
                            <span class="svg-icon svg-icon-warning svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo9\dist/../src/media/svg/icons\Code\Backspace.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path
                d="M8.42034438,20 L21,20 C22.1045695,20 23,19.1045695 23,18 L23,6 C23,4.8954305 22.1045695,4 21,4 L8.42034438,4 C8.15668432,4 7.90369297,4.10412727 7.71642146,4.28972363 L0.653241109,11.2897236 C0.260966303,11.6784895 0.25812177,12.3116481 0.646887666,12.7039229 C0.648995955,12.7060502 0.651113791,12.7081681 0.653241109,12.7102764 L7.71642146,19.7102764 C7.90369297,19.8958727 8.15668432,20 8.42034438,20 Z"
                fill="#000000" opacity="0.3"/>
        </g>
    </svg><!--end::Svg Icon--></span>
                        Back
                    </a>
                    <!--end::Actions-->
                    <!--begin::Dropdown-->
                    <!--end::Dropdown-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>

        <!--end::Subheader-->
        <!--begin::Entry-->
        <!--end::Entry-->
        <!--begin::Container-->
        <div class="container-fluid">


            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile </h3>
                            <div class="card-toolbar">
                                <div class="example-tools justify-content-center">

                                        <span class="example-copy" data-toggle="tooltip" title=""
                                              data-original-title="Copy code"></span>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body">

                            <!--begin::Form-->
                            <form method="post"
                                  action="{{ route('user-profile.update',$UserProfile->id) }}" enctype="multipart/form-data">

                                {{ method_field('PUT') }}

                                {{ csrf_field() }}

                                <div class="tab-content">
                                    <!--begin::Tab-->
                                    <div class="tab-pane show active px-7" id="kt_user_edit_tab_1" role="tabpanel">
                                        <!--begin::Row-->
                                        <div class="row">
                                            <div class="col-xl-2"></div>
                                            <div class="col-xl-7 my-2">
                                                <!--begin::Row-->
                                                <div class="row">
                                                    <label class="col-3"></label>
                                                    <div class="col-9">
                                                        <h6 class="text-dark font-weight-bold mb-10"></h6>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-3 text-lg-right text-left">Image
                                                        <span class="text-danger"></span> </label>
                                                    <div class="col-lg-6">
                                                        <div class="image-input image-input-outline" id="kt_image_1">

                                                            <div class="image-input-wrapper"
                                                                 style="background-image: url({{asset('uploads/'.(!empty($UserProfile)?$UserProfile->image:""))}} )"></div>
                                                            <label
                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="change" data-toggle="tooltip" title=""
                                                                data-original-title="Change avatar">
                                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                                <input type="file" name="image"
                                                                       accept=".png, .jpg, .jpeg"/>
                                                                <input type="hidden" name="image"/>
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
                                                    <label class="col-form-label col-3 text-lg-right text-left">User
                                                        Name<span class="text-danger">*</span> </label>
                                                    <div class="col-9">
                                                        <input class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror"
                                                               type="text" placeholder="Enter User Name"
                                                               value="{{isset($UserProfile)?$UserProfile->name:old('name')}}"
                                                               name="name">
                                                        @if ($errors->has('name'))
                                                            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-3 text-lg-right text-left">Email Address <span class="text-danger">*</span></label>

                                                    <div class="col-9">
                                                        <input class="form-control form-control-lg form-control-solid  @error('email') is-invalid @enderror "
                                                               type="email" placeholder="Enter Email Address" name="email"
                                                               value="{{isset($UserProfile)?$UserProfile->email:old('email')}}">
                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>

                                        </div>




                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-1">

                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2" id="submit"><i
                                                    class="fas fa-save"></i>Save
                                            </button>
                                            <button type="reset" class="btn btn-secondary"><i
                                                    class="ki ki-bold-close icon-md"></i>Reset
                                            </button>
                                        </div>
                                        <!--end::Tab-->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection




