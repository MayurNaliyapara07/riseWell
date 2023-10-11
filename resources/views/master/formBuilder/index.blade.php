@extends('layouts.app')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @include('layouts.sub-header',[
            'title' => 'Form Builder',
            'directory'=>'master',
            'model'=>'formBuilderModel'

        ])
        <div class="container-fluid">
            <div class="card card-custom gutter-b" >
                <div class="card-body">
                    <form action="" method="post">
                        @csrf
                        <div class="row addedField">
                            @if($form)
                                @foreach($form->form_data as $formData)
                                    <div class="col-md-4" >
                                        <div class="card mb-3" id="{{ $loop->index }}" style="border: 1px solid grey !important;">
                                            <input type="hidden" name="form_generator[is_required][]" value="{{ $formData->is_required }}">
                                            <input type="hidden" name="form_generator[extensions][]" value="{{ $formData->extensions }}">
                                            <input type="hidden" name="form_generator[options][]" value="{{ implode(',',$formData->options) }}">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>@lang('Label')</label>
                                                    <input type="text" name="form_generator[form_label][]" class="form-control" value="{{ $formData->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('Type')</label>
                                                    <input type="text" name="form_generator[form_type][]" class="form-control" value="{{ $formData->type }}" readonly>
                                                </div>
                                                @php
                                                    $jsonData = json_encode([
                                                        'type'=>$formData->type,
                                                        'is_required'=>$formData->is_required,
                                                        'label'=>$formData->name,
                                                        'extensions'=>explode(',',$formData->extensions) ?? 'null',
                                                        'options'=>$formData->options,
                                                        'old_id'=>'',
                                                    ]);
                                                @endphp
                                                <div class="btn-group w-100">
                                                    <button type="button" class="btn btn-warning editFormData" data-form_item="{{ $jsonData }}" data-update_id="{{ $loop->index }}"><i class="las la-pen"></i></button>
                                                    <button type="button" class="btn btn-danger removeFormData"><i class="las la-times"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary w-100 h-45">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="formBuilderModel" tabindex="-1" role="dialog" aria-labelledby="formBuilderModel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formBuilderModel">Generate Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Form Type<span class="text-danger">*</span></label>
                            <select name="form_tupe" class="form-control" style="width: 100%;!important;">
                                <option value="">Select FormType</option>
                                <option value="">Text</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

@endpush



