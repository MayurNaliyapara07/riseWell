
@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Lab Category',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'lab-category.index'
        ])
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <form action="{{(isset($category))?route('lab-category.update',$category->category_id):route('lab-category.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Image<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper"
                                                     style="background-image: url('{{ !empty($category->image)?$category->getFileUrl($category->image):asset('assets/media/products/default.png') }}')"></div>
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
                                        <label class="col-lg-3 col-form-label ">Category Name<span
                                                    class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="text" name="category_name" id="category_name" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Category Name" data-msg-required="Category Name is required"
                                                   value="{{isset($category)?$category->category_name:old('category_name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <button id="form_submit" class="btn btn-primary mr-2"><i
                                                    class="fas fa-save"></i>Save
                                        </button>
                                        <button type="reset" class="btn btn-danger"><i
                                                    class="fas fa-times"></i>Reset
                                        </button>
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
@endpush


