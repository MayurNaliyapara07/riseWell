
@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header', [
             'title' => 'Notification Template',
             'directory'=> 'master',
             'action'=>'Create',
             'back' => 'notification-template'
        ])
        <div class="container">
            <div class="row">
                @if(!empty($notificationTemplate->shortcodes))

                    <div class="col-lg-12">
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped- table-bordered table-hover table-checkable" id="notification_template_table" style="margin-top: 13px !important">
                                            <thead>
                                            <tr>
                                                <th>Short Code</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($notificationTemplate->shortcodes as $shortCode =>$codeDetails)
                                                <tr>
                                                    <td><span class="short-codes">@{{@php echo $shortCode @endphp}}</span></td>
                                                    <td>{{$codeDetails}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="col-lg-12">
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <form action="{{(isset($notificationTemplate))?route('notification-template.update',$notificationTemplate->notification_template_id):route('notification-template.store')}}"
                              method="post" enctype="multipart/form-data" class="ajax-form">
                            @csrf
                            @if(isset($notificationTemplate))
                                @method('PUT')
                            @endif

                            <div class="card-body">
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Subject<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input type="text" name="subj" id="subj" autocomplete="off"
                                                   class="form-control required"
                                                   placeholder="Subject" data-msg-required="Subject is required"
                                                   value="{{isset($notificationTemplate)?$notificationTemplate->subj:old('subj')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label ">Template<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                             <textarea type="text"
                                                       name="email_body"
                                                       class="form-control form-control-lg form-control-solid mb-2 summernote">
                                                {{!empty($notificationTemplate->email_body)?$notificationTemplate->email_body:''}}
                                            </textarea>
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
        <script>
            $('.summernote').summernote({
                height: 250
            });
        </script>
    <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
@endpush


